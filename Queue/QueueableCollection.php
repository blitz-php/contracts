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
     * Get the type of the entities being queued.
     */
    public function getQueueableClass(): ?string;

    /**
     * Get the identifiers for all of the entities.
     *
     * @return mixed[]
     */
    public function getQueueableIds(): array;

    /**
     * Get the relationships of the entities being queued.
     *
     * @return string[]
     */
    public function getQueueableRelations(): array;

    /**
     * Get the connection of the entities being queued.
     */
    public function getQueueableConnection(): ?string;
}
