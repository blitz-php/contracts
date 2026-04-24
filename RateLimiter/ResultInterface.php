<?php

namespace BlitzPHP\Contracts\RateLimiter;

/**
 * Interface pour le résultat d'une tentative de rate limiting.
 * 
 * Définit le contrat que tous les objets de résultat doivent respecter.
 * Un ResultInterface est retourné par Limiter::attempt() et contient
 * toutes les informations nécessaires pour :
 * - Savoir si la requête est autorisée
 * - Informer le client de son quota
 * - Générer les headers HTTP standards
 * 
 * @package BlitzPHP\Contracts\RateLimiter
 */
interface ResultInterface
{
    /**
     * Vérifie si la requête est autorisée.
     * 
     * Cette méthode est le principal point de décision après un appel à attempt().
     * Si elle retourne false, le client doit être bloqué et recevoir une erreur 429.
     * 
     * @return bool True si la requête peut être traitée, false si la limite est atteinte
     */
    public function isAllowed(): bool;
    
    /**
     * Génère les headers HTTP standards pour le rate limiting.
     * 
     * Retourne un tableau associatif prêt à être utilisé avec les réponses HTTP.
     * Les headers standards incluent :
     * - X-RateLimit-Limit     : La limite maximale configurée
     * - X-RateLimit-Remaining : Le nombre de requêtes restantes
     * - X-RateLimit-Reset     : Le timestamp Unix du reset
     * 
     * Note : Le header Retry-After n'est PAS inclus ici car il n'est pertinent
     * qu'en cas de dépassement. Il est géré séparément via un mécanisme spécifique.
     * 
     * @return array<string, string> Tableau de headers HTTP
     * 
     * @example
     * [
     *     'X-RateLimit-Limit'     => '60',
     *     'X-RateLimit-Remaining' => '42',
     *     'X-RateLimit-Reset'     => '1700000000',
     * ]
     */
    public function toHeaders(): array;
}
