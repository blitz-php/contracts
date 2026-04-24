<?php

namespace BlitzPHP\Contracts\RateLimiter;

/**
 * Interface pour le service de rate limiting principal.
 * 
 * Définit le contrat que le Throttler (ou tout autre service de rate limiting)
 * doit respecter. Cette interface permet de découpler l'application du service
 * concret et facilite le remplacement par une implémentation alternative.
 * 
 * Le service de rate limiting est une façade de haut niveau qui :
 * - Délègue la logique algorithmique aux stratégies (Limiter)
 * - Fournit des méthodes utilitaires pratiques (attempt, hit, clear)
 * - Gère les limiteurs nommés
 * - Nettoie les clés automatiquement
 * 
 * @package BlitzPHP\Contracts\RateLimiter
 */
interface RateLimiterInterface
{
    /**
     * Tente d'exécuter un callback si la limite n'est pas dépassée.
     * 
     * Pattern "check and execute" qui combine la vérification de la limite
     * et l'exécution de l'action en une seule méthode. Le compteur n'est
     * incrémenté QUE si le callback s'exécute avec succès.
     * 
     * Idéal pour les opérations atomiques comme :
     * - Envoi de message
     * - Traitement de paiement
     * - Génération de rapport
     * 
     * @param string   $key          Clé unique d'identification
     * @param int      $maxAttempts  Nombre maximum de tentatives autorisées
     * @param callable $callback     Action à exécuter si la limite le permet
     * @param int      $decaySeconds Durée de la fenêtre en secondes (défaut: 60)
     * 
     * @return mixed Le résultat du callback si autorisé, false si limité
     * 
     * @example
     * $result = $rateLimiter->attempt('send-message:' . $userId, 5, function () {
     *     return $messageService->send();
     * }, 60);
     * 
     * if ($result === false) {
     *     return response()->json(['error' => 'Too many messages'], 429);
     * }
     */
    public function attempt(string $key, int $maxAttempts, callable $callback, int $decaySeconds = 60): mixed;
    
    /**
     * Vérifie si la limite est dépassée SANS incrémenter le compteur.
     * 
     * Contrairement à attempt(), cette méthode ne consomme PAS de token.
     * Elle est utile pour :
     * - Vérifier l'état avant d'effectuer une action
     * - Afficher le statut à l'utilisateur
     * - Logique conditionnelle basée sur le quota restant
     * 
     * Note : Cette méthode PEUT réinitialiser la fenêtre si elle est expirée.
     * C'est intentionnel pour éviter de bloquer inutilement.
     * 
     * @param string $key          Clé unique
     * @param int    $maxAttempts  Nombre maximum autorisé
     * @param int    $decaySeconds Fenêtre de temps en secondes (défaut: 60)
     * 
     * @return bool True si la limite est dépassée, false sinon
     * 
     * @example
     * if ($rateLimiter->tooManyAttempts('login:' . $ip, 5, 900)) {
     *     return 'Too many login attempts. Please try again in 15 minutes.';
     * }
     */
    public function tooManyAttempts(string $key, int $maxAttempts, int $decaySeconds = 60): bool;
    
    /**
     * Incrémente le compteur avec un montant personnalisé.
     * 
     * Permet de consommer plusieurs tokens d'un coup, utile pour :
     * - Requêtes coûteuses (upload volumineux = 5 tokens)
     * - Opérations batch
     * - Pénalités proportionnelles
     * 
     * @param string $key          Clé unique
     * @param int    $decaySeconds Durée de la fenêtre en secondes
     * @param int    $amount       Nombre de tokens à consommer (défaut: 1)
     * 
     * @return int Nombre total de tentatives après incrémentation
     * 
     * @example
     * // Un upload de 5 MB coûte 5 tokens
     * $rateLimiter->increment('upload:' . $userId, 3600, 5);
     * 
     * // Incrémentation simple (équivalent à hit())
     * $rateLimiter->increment('send-message:' . $userId, 60);
     */
    public function increment(string $key, int $decaySeconds = 60, int $amount = 1): int;
    
    /**
     * Décrémente le compteur pour "annuler" des tentatives.
     * 
     * Utile pour corriger des incrémentations abusives ou annuler
     * des tentatives qui ne devraient pas être comptabilisées :
     * - Login réussi : annuler la tentative échouée
     * - Erreur système : rembourser les tokens
     * - Correction manuelle par un administrateur
     * 
     * @param string $key          Clé unique
     * @param int    $decaySeconds Durée de la fenêtre en secondes
     * @param int    $amount       Nombre de tokens à restaurer (défaut: 1)
     * 
     * @return int Nombre total de tentatives après décrémentation
     * 
     * @example
     * // Annuler une tentative de login échouée
     * $rateLimiter->decrement('login:' . $ip, 900);
     * 
     * // Corriger une sur-incrémentation de 3
     * $rateLimiter->decrement('api:' . $key, 60, 3);
     */
    public function decrement(string $key, int $decaySeconds = 60, int $amount = 1): int;
    
    /**
     * Récupère le nombre de tentatives actuelles pour une clé.
     * 
     * @param string $key Clé unique
     * 
     * @return int Nombre de tentatives (0 si jamais utilisé)
     */
    public function attempts(string $key): int;
    
    /**
     * Réinitialise complètement le compteur pour une clé.
     * 
     * @param string $key Clé unique
     * 
     * @return bool True si la réinitialisation a réussi
     */
    public function reset(string $key): bool;
    
    /**
     * Calcule le nombre de tentatives restantes avant d'atteindre la limite.
     * 
     * @param string $key         Clé unique
     * @param int    $maxAttempts Maximum autorisé
     * 
     * @return int Tentatives restantes (0 si la limite est atteinte)
     */
    public function remaining(string $key, int $maxAttempts): int;
    
    /**
     * Calcule le temps restant avant la réinitialisation du compteur.
     * 
     * Retourne le nombre de secondes à attendre avant qu'un nouveau token
     * soit disponible. Typiquement utilisé pour le header Retry-After.
     * 
     * @param string $key Clé unique
     * 
     * @return int Secondes avant reset (0 si disponible immédiatement)
     */
    public function availableIn(string $key): int;
    
    /**
     * Récupère toutes les informations d'une clé en un seul appel.
     * 
     * Pratique pour les endpoints de statut ou les tableaux de bord.
     * Évite de faire plusieurs appels individuels.
     * 
     * @param string $key         Clé unique
     * @param int    $maxAttempts Maximum autorisé
     * 
     * @return array{attempts: int, remaining: int, limit: int, available_in: int, is_limited: bool}
     * 
     * @example
     * $info = $rateLimiter->info('api:' . $userId, 60);
     * // [
     * //     'attempts'     => 42,
     * //     'remaining'    => 18,
     * //     'limit'        => 60,
     * //     'available_in' => 0,
     * //     'is_limited'   => false,
     * // ]
     */
    public function info(string $key, int $maxAttempts): array;
}
