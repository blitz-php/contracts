<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Container;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    /**
     * Détermine si le type abstrait donné a été lié.
     */
    public function bound(string $abstract): bool;

    /**
     * Résoudre le type donné à partir du conteneur.
     *
     * @template T
     * @param string|class-string<T> $absstract
     * @param array $parameters
     */
    public function make(string $abstract, array $parameters = []): mixed;

    /**
     * Appeler la Closure / class::method donnée et injecter ses dépendances.
     */
    public function call(callable|string $callback, array $parameters = []): mixed;
}
