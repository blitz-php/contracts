<?php

namespace BlitzPHP\Contracts\RateLimiter;

/**
 * Interface pour les stratégies de rate limiting.
 * 
 * Définit le contrat que toutes les stratégies de rate limiting doivent implémenter.
 * Chaque stratégie (Token Bucket, Sliding Window, Fixed Window, etc.) fournit
 * sa propre logique algorithmique pour déterminer si une requête est autorisée.
 * 
 * Les implémentations doivent être sans état (stateless) autant que possible,
 * le cache étant la seule source de vérité pour l'état des compteurs.
 */
interface Limiter
{
    /**
     * Tente de consommer un ou plusieurs tokens dans le bucket.
     * 
     * Cette méthode est le cœur de la stratégie. Elle doit :
     * 1. Récupérer l'état actuel depuis le cache
     * 2. Appliquer l'algorithme spécifique (refill, calcul de fenêtre, etc.)
     * 3. Vérifier si le coût demandé peut être satisfait
     * 4. Mettre à jour l'état dans le cache si autorisé
     * 5. Retourner un résultat détaillé
     * 
     * Note concernant cost=0 :
     * Lorsque $cost vaut 0, la méthode doit vérifier l'état sans consommer de tokens.
     * Cependant, elle PEUT réinitialiser la fenêtre si celle-ci est expirée.
     * Ce comportement est intentionnel pour éviter de bloquer inutilement.
     * 
     * @param string $key    Clé unique d'identification (ex: "login:192.168.1.1")
     * @param int    $limit  Nombre maximum de tokens disponibles dans la fenêtre
     * @param int    $window Durée de la fenêtre en secondes
     * @param int    $cost   Coût de l'opération en tokens (défaut: 1, 0 = simple vérification)
     * 
     * @return ResultInterface Résultat détaillé contenant :
     *                         - allowed   : bool   - si la requête est autorisée
     *                         - limit     : int    - limite maximale configurée
     *                         - remaining : int    - tokens restants après l'opération
     *                         - reset     : int    - timestamp Unix du reset
     *                         - retryAfter: int    - secondes à attendre avant réessayer
     *                         - metadata  : array  - données supplémentaires spécifiques à la stratégie
     */
    public function attempt(string $key, int $limit, int $window, int $cost = 1): ResultInterface;
    
    /**
     * Réinitialise complètement le compteur pour une clé donnée.
     * 
     * Supprime toutes les données associées à cette clé dans le cache,
     * permettant de repartir à zéro. Utile pour :
     * - Réinitialiser manuellement après un login réussi
     * - Nettoyer après un bannissement levé
     * - Tests unitaires
     * 
     * @param string $key Clé unique à réinitialiser
     * 
     * @return bool True si la réinitialisation a réussi, false sinon
     */
    public function reset(string $key): bool;
    
    /**
     * Récupère le nombre de tentatives actuelles pour une clé donnée.
     * 
     * Retourne le nombre de tokens consommés jusqu'à présent dans la fenêtre.
     * Une valeur de 0 signifie soit que la clé n'a jamais été utilisée,
     * soit que la fenêtre a expiré et a été réinitialisée.
     * 
     * @param string $key Clé unique
     * 
     * @return int Nombre de tentatives (0 si jamais utilisé ou fenêtre expirée)
     */
    public function attempts(string $key): int;

    /**
     * Récupère le nombre de tentatives restantes avant d'atteindre la limite.
     * 
     * Cette méthode calcule combien de requêtes supplémentaires peuvent être
     * effectuées avant d'être bloqué. Contrairement à availableIn(), elle
     * donne une information quantitative et non temporelle.
     * 
     * @param string $key   Clé unique
     * @param int    $limit Limite maximale configurée
     * 
     * @return int Nombre de tentatives restantes (0 si la limite est atteinte)
     */
    public function remaining(string $key, int $limit): int;
    
    /**
     * Incrémente le compteur sans vérifier de limite maximale.
     * 
     * Contrairement à attempt(), cette méthode ne vérifie PAS si la limite
     * est dépassée. Elle se contente d'ajouter le montant spécifié au compteur.
     * Utile pour les opérations manuelles où l'on souhaite :
     * - Consommer N tokens d'un coup (ex: upload de 5MB = 5 tokens)
     * - Incrémenter progressivement sans blocage
     * - Gérer manuellement la logique de limite dans l'application
     * 
     * Note : Le montant PEUT rendre le compteur négatif. C'est intentionnel
     * pour permettre une flexibilité maximale en mode manuel.
     * 
     * @param string $key    Clé unique
     * @param int    $window Fenêtre de temps en secondes (pour le TTL du cache)
     * @param int    $amount Nombre de tokens à consommer (défaut: 1)
     * 
     * @return int Nombre total de tokens consommés après l'opération
     * 
     * @example
     * // Consommer 5 tokens pour un upload volumineux
     * $strategy->increment('upload:user:123', 3600, 5);
     */
    public function increment(string $key, int $window, int $amount = 1): int;

    /**
     * Décrémente le compteur manuellement.
     * 
     * Permet d'"annuler" des tentatives ou de corriger une sur-incrémentation.
     * L'implémentation par défaut appelle increment() avec un montant négatif.
     * 
     * Cas d'usage :
     * - Login réussi : annuler la tentative échouée précédente
     * - Correction d'un bug de double comptage
     * - Remboursement de tokens après une erreur système
     * 
     * @param string $key    Clé unique
     * @param int    $window Fenêtre de temps en secondes
     * @param int    $amount Nombre de tokens à restaurer (défaut: 1)
     * 
     * @return int Nombre total de tokens consommés après l'opération
     * 
     * @example
     * // Annuler une tentative de login échouée
     * $strategy->decrement('login:192.168.1.1', 900, 1);
     */
    public function decrement(string $key, int $window, int $amount = 1): int;
    
    /**
     * Calcule le temps restant avant qu'un nouveau token soit disponible.
     * 
     * Retourne le nombre de secondes à attendre avant de pouvoir effectuer
     * une nouvelle requête. Cette méthode est typiquement utilisée pour :
     * - Informer l'utilisateur du temps d'attente
     * - Définir le header HTTP "Retry-After"
     * - Implémenter une logique de backoff
     * 
     * @param string $key Clé unique
     * 
     * @return int Nombre de secondes avant le prochain token disponible
     *             (0 si des tokens sont disponibles immédiatement)
     */
    public function availableIn(string $key): int;
}
