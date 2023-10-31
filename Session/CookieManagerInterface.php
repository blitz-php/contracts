<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Session;

interface CookieManagerInterface
{
    /**
     * Créez une nouvelle instance de cookie.
     */
    public function make(string $name, array|string $value, int $minutes = 0, array $options = []): CookieInterface;

    /**
     * Créez un cookie qui dure « pour toujours » (cinq ans).
     */
    public function forever(string $name, array|string $value, array $options = []): CookieInterface;

    /**
     * Faire expirer le cookie donné.
     */
    public function forget(string $name, array $options = []): CookieInterface;

    /**
     * Recupere la valeur d'un cookie et cree une intance de Cookie avec
     * Si aucun cookie avec ce nom n'existe renvoie null
     */
    public function get(string $name, array $options = []): ?CookieInterface;

    /**
     * Verifie si un cookie existe
     */
    public function has(string $name): bool;
}
