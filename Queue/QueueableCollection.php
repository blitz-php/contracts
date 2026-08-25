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

/**
 * Comportement attendu d'une collection pouvant être mise en file d'attente
 *
 * @credit <a href="http://www.laravel.com">Laravel - Illuminate\Contracts\Queue\QueueableCollection</a>
 */
interface QueueableCollection
{
    /**
     * Récupère le type des entités mises en file d'attente.
     */
    public function getQueueableClass(): ?string;

    /**
     * Récupère les identifiants de toutes les entités.
     *
     * @return list<mixed>
     */
    public function getQueueableIds(): array;

    /**
     * Récupère les relations des entités mises en file d'attente.
     *
     * @return list<string>
     */
    public function getQueueableRelations(): array;

    /**
     * Récupère la connexion des entités mises en file d'attente.
     */
    public function getQueueableConnection(): ?string;
}
