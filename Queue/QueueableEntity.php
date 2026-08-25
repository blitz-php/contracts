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
 * Comportement attendu d'une entité pouvant être mise en file d'attente
 *
 * @credit <a href="http://www.laravel.com">Laravel - Illuminate\Contracts\Queue\QueueableEntity</a>
 */
interface QueueableEntity
{
    /**
     * Récupère l'identité de l'entité pouvant être mise en file d'attente.
     */
    public function getQueueableId(): mixed;

    /**
     * Récupère les relations de l'entité.
     */
    public function getQueueableRelations(): array;

    /**
     * Récupère la connexion de l'entité.
     */
    public function getQueueableConnection(): ?string;
}
