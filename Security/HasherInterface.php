<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Security;

/**
 * Gestionnaire de hashage BlitzPHP
 *
 * Fournit un cryptage unidirectionnel
 *
 * @credit <a href="http://www.laravel.com">Laravel 9 - Illuminate\Contracts\Hashing\Hasher</a>
 */
interface HasherInterface
{
    /**
     * Obtenez des informations sur la valeur hachée donnée.
     */
    public function info(string $hash): array;

    /**
     * Hachez la valeur donnée.
     */
    public function make(string $value, array $options = []): string;

    /**
     * Vérifiez la valeur simple donnée par rapport à un hachage.
     */
    public function check(string $value, string $hash, array $options = []): bool;

    /**
     * Vérifiez si le hachage donné a été haché à l'aide des options données.
     */
    public function needsRehash(string $hashedValue, array $options = []): bool;
}
