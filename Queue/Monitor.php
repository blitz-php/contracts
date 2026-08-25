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
 * @credit <a href="http://www.laravel.com">Laravel - Illuminate\Contracts\Queue\Job</a>
 */
interface Monitor
{
    /**
     * Enregistre un callback à exécuter lorsqu'une file d'attente démon démarre.
     */
    public function starting(callable $callback): void;

    /**
     * Enregistre un callback à exécuter à chaque itération de la boucle de la file d'attente.
     */
    public function looping(callable $callback): void;

    /**
     * Enregistre un callback à exécuter lorsqu'un travail échoue après le nombre maximum de tentatives.
     */
    public function failing(callable $callback): void;

    /**
     * Enregistre un callback à exécuter lorsqu'une file d'attente démon s'arrête.
     */
    public function stopping(callable $callback): void;
}
