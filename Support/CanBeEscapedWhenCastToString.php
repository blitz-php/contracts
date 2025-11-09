<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Support;

/**
 * @credit <a href="https://laravel.com">Laravel - Illuminate\Contracts\Support\CanBeEscapedWhenCastToString</a>
 */
interface CanBeEscapedWhenCastToString
{
    /**
     * Indiquez que la représentation sous forme de chaîne de l'objet doit être échappée lorsque __toString est invoqué.
     */
    public function escapeWhenCastingToString(bool $escape = true): self;
}
