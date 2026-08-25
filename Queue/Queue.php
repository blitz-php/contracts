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

use DateInterval;
use DateTimeInterface;

/**
 * @credit <a href="http://www.laravel.com">Laravel - Illuminate\Contracts\Queue\Queue</a>
 */
interface Queue
{
    /**
     * Récupère la taille de la file d'attente.
     */
    public function size(?string $queue = null): int;

    /**
     * Récupère le nombre de travaux en attente.
     */
    public function pendingSize(?string $queue = null): int;

    /**
     * Récupère le nombre de travaux différés.
     */
    public function delayedSize(?string $queue = null): int;

    /**
     * Récupère le nombre de travaux réservés.
     */
    public function reservedSize(?string $queue = null): int;

    /**
     * Récupère l'horodatage de création du plus ancien travail en attente, à l'exclusion des travaux différés.
     */
    public function creationTimeOfOldestPendingJob(?string $queue = null): ?int;

    /**
     * Ajoute un nouveau travail dans la file d'attente.
     */
    public function push(string|Job $job, mixed $data = '', ?string $queue = null): mixed;

    /**
     * Ajoute un nouveau travail dans une file d'attente spécifique.
     */
    public function pushOn(string $queue, string|Job $job, mixed $data = ''): mixed;

    /**
     * Ajoute une charge utile brute dans la file d'attente.
     */
    public function pushRaw(string $payload, ?string $queue = null, array $options = []): mixed;

    /**
     * Ajoute un nouveau travail dans la file d'attente après (n) secondes.
     */
    public function later(DateTimeInterface|DateInterval|int $delay, string|Job $job, mixed $data = '', ?string $queue = null): mixed;

    /**
     * Ajoute un nouveau travail dans une file d'attente spécifique après (n) secondes.
     */
    public function laterOn(string $queue, DateTimeInterface|DateInterval|int $delay, string|Job $job, mixed $data = ''): mixed;

    /**
     * Ajoute un tableau de travaux dans la file d'attente.
     *
     * @param array<string|Job> $jobs
     *
     * @return mixed
     */
    public function bulk(array $jobs, mixed $data = '', ?string $queue = null);

    /**
     * Extrait le prochain travail de la file d'attente.
     */
    public function pop(?string $queue = null): ?Job;

    /**
     * Supprime tous les travaux de la file d'attente.
     *
     * @return bool|int
     */
    public function clear(string $queue);

    /**
     * Récupère le nom de la connexion pour la file d'attente.
     */
    public function getConnectionName(): string;

    /**
     * Définit le nom de la connexion pour la file d'attente.
     */
    public function setConnectionName(string $name): self;
}
