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

use UnitEnum;

/**
 * @credit <a href="http://www.laravel.com">Laravel - Illuminate\Contracts\Queue\Factory</a>
 */
interface Factory
{
    /**
     * Résout une instance de connexion de file d'attente.
     */
    public function connection(UnitEnum|string|null $name = null): Queue;
}
