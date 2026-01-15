<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Event;

/**
 * Interface pour les classes d'écouteurs d'événements
 */
interface EventListenerInterface
{
    /**
     * Enregistre les écouteurs d'événements
     *
     * @param EventManagerInterface $manager Le gestionnaire d'événements
     */
    public function listen(EventManagerInterface $manager): void;
}
