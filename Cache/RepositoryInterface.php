<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Cache;

use Closure;
use DateInterval;
use DateTimeInterface;
use UnitEnum;

/**
 * @credit <a href="http://www.laravel.com">Laravel - Illuminate\Contracts\Cache\Repository</a>
 */
interface RepositoryInterface extends CacheInterface
{
    /**
     * Récupère un élément du cache et le supprime.
     *
     * @template TCacheValue
     *
     * @param  TCacheValue|(\Closure(): TCacheValue)  $default
     *
     * @return (TCacheValue is null ? mixed : TCacheValue)
     */
    public function pull(UnitEnum|array|string $key, $default = null);

    /**
     * Stocke un élément dans le cache.
     */
    public function put(UnitEnum|string $key, mixed $value, DateTimeInterface|DateInterval|int|null $ttl = null): bool;

    /**
     * Incrémente la valeur d'un élément dans le cache.
     *
     * @return int|bool
     */
    public function increment(UnitEnum|string $key, int $value = 1);

    /**
     * Décrémente la valeur d'un élément dans le cache.
     *
     * @return int|bool
     */
    public function decrement(UnitEnum|string $key, int $value = 1);

    /**
     * Stocke un élément dans le cache indéfiniment.
     */
    public function forever(UnitEnum|string $key, mixed $value): bool;

    /**
     * Récupère un élément du cache, ou exécute la Closure donnée et stocke le résultat.
     *
     * @template TCacheValue
     *
     * @return TCacheValue
     */
    public function remember(UnitEnum|string $key, callable|DateTimeInterface|DateInterval|int|null $ttl, ?callable $callable = null): mixed;

    /**
     * Récupère un élément du cache, ou exécute la Closure donnée et stocke le résultat indéfiniment.
     */
    public function sear(UnitEnum|string $key, Closure $callback): mixed;

    /**
     * Récupère un élément du cache, ou exécute la Closure donnée et stocke le résultat indéfiniment.
     *
     * @template TCacheValue
     *
     * @return TCacheValue
     */
    public function rememberForever(UnitEnum|string $key, Closure $callback): mixed;

    /**
     * Définit la date d'expiration d'un élément mis en cache.
     */
    public function touch(UnitEnum|string $key, DateTimeInterface|DateInterval|int $ttl): bool;

    /**
     * Supprime un élément du cache.
     */
    public function forget(UnitEnum|string $key): bool;

    /**
     * Récupère l'implémentation du magasin de cache.
     */
    public function getStore(): CacheInterface;
}
