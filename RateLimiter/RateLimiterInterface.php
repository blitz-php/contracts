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
	 * Incrémente le compteur de tentatives.
	 *
	 * Cette méthode ajoute le montant spécifié au nombre de tentatives effectuées.
	 * Elle ne vérifie PAS de limite maximale : elle se contente de consommer
	 * des tokens, même si cela rend le solde négatif.
	 *
	 * Utile pour les opérations manuelles où l'on souhaite :
	 * - Consommer N tokens d'un coup (ex: upload de 5MB = 5 tentatives)
	 * - Incrémenter progressivement sans blocage
	 * - Gérer manuellement la logique de limite dans l'application
	 *
	 * @param string $key    Clé unique
	 * @param int    $decaySeconds Durée de la fenêtre en secondes
	 * @param int    $amount Nombre de tentatives à ajouter (défaut: 1)
	 *
	 * @return int Nombre de tentatives déjà effectuées après l'opération
	 *             (et non le nombre de tentatives restantes)
	 *
	 * @example
	 * // Ajouter 1 tentative
	 * $count = $strategy->increment('login:192.168.1.1', 900);
	 * // $count = 1 (1 tentative effectuée)
	 *
	 * // Ajouter 5 tentatives d'un coup
	 * $count = $strategy->increment('upload:user:123', 3600, 5);
	 * // $count = 5 (5 tentatives effectuées)
	 *
	 * // Pour connaître les tentatives restantes, utilisez remaining()
	 * $remaining = $strategy->remaining('login:192.168.1.1', 5);
	 * // $remaining = 4 (5 max - 1 effectuée)
	 */
    public function increment(string $key, int $decaySeconds = 60, int $amount = 1): int;

    /**
	 * Décrémente le compteur de tentatives.
	 *
	 * Cette méthode retire le montant spécifié du nombre de tentatives effectuées.
	 * Cela permet d'"annuler" des tentatives ou de corriger une sur-incrémentation.
	 *
	 * Cas d'usage :
	 * - Login réussi : annuler la tentative échouée précédente
	 * - Correction d'un bug de double comptage
	 * - Remboursement de tentatives après une erreur système
	 *
	 * @param string $key    Clé unique
	 * @param int    $decaySeconds Durée de la fenêtre en secondes
	 * @param int    $amount Nombre de tentatives à retirer (défaut: 1)
	 *
	 * @return int Nombre de tentatives déjà effectuées après l'opération
	 *             (et non le nombre de tentatives restantes)
	 *
	 * @example
	 * // Annuler une tentative de login échouée
	 * $count = $strategy->decrement('login:192.168.1.1', 900);
	 * // Avant : 3 tentatives effectuées → Après : 2 tentatives effectuées
	 *
	 * // Pour connaître les tentatives restantes, utilisez remaining()
	 * $remaining = $strategy->remaining('login:192.168.1.1', 5);
	 * // $remaining = 3 (5 max - 2 effectuées)
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
