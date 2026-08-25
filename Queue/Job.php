<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Queue;

use Throwable;

/**
 * @credit <a href="http://www.laravel.com">Laravel - Illuminate\Contracts\Queue\Job</a>
 */
interface Job
{
    /**
     * Récupère l'UUID du travail.
     */
    public function uuid(): ?string;

    /**
     * Récupère l'identifiant du travail.
     */
    public function getJobId(): string;

    /**
     * Récupère le corps décodé du travail.
     */
    public function payload(): array;

    /**
     * Exécute le travail.
     */
    public function fire(): void;

    /**
     * Relâche le travail dans la file d'attente après (n) secondes.
     */
    public function release(int $delay = 0): void;

    /**
     * Détermine si le travail a été relâché dans la file d'attente.
     */
    public function isReleased(): bool;

    /**
     * Supprime le travail de la file d'attente.
     */
    public function delete(): void;

    /**
     * Détermine si le travail a été supprimé.
     */
    public function isDeleted(): bool;

    /**
     * Détermine si le travail a été supprimé ou relâché.
     */
    public function isDeletedOrReleased(): bool;

    /**
     * Récupère le nombre de fois que le travail a été tenté.
     */
    public function attempts(): int;

    /**
     * Détermine si le travail a été marqué comme un échec.
     */
    public function hasFailed(): bool;

    /**
     * Marque le travail comme "échoué".
     */
    public function markAsFailed(): void;

    /**
     * Supprime le travail, appelle la méthode "failed" et déclenche l'événement de travail échoué.
     */
    public function fail(?Throwable $e = null): void;

    /**
     * Récupère le nombre de tentatives pour un travail.
     */
    public function maxTries(): ?int;

    /**
     * Récupère le nombre maximum d'exceptions autorisées, indépendamment des tentatives.
     */
    public function maxExceptions(): ?int;

    /**
     * Récupère le nombre de secondes pendant lesquelles le travail peut s'exécuter.
     */
    public function timeout(): ?int;

    /**
     * Récupère l'horodatage indiquant quand le travail devrait expirer.
     */
    public function retryUntil(): ?int;

    /**
     * Récupère le nom de la classe du travail mis en file d'attente.
     */
    public function getName(): string;

    /**
     * Récupère le nom d'affichage de la classe du travail mis en file d'attente.
     *
     * Résout le nom des travaux "encapsulés" tels que les gestionnaires basés sur des classes.
     */
    public function resolveName(): string;

    /**
     * Récupère la classe du travail mis en file d'attente.
     *
     * Résout la classe des travaux "encapsulés" tels que les gestionnaires basés sur des classes.
     */
    public function resolveQueuedJobClass(): string;

    /**
     * Récupère le nom de la connexion à laquelle appartient le travail.
     */
    public function getConnectionName(): string;

    /**
     * Récupère le nom de la file d'attente à laquelle appartient le travail.
     */
    public function getQueue(): string;

    /**
     * Récupère la chaîne brute du corps du travail.
     */
    public function getRawBody(): string;
}
