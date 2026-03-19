<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Database;

interface RepositoryInterface
{
    /**
     * Récupère un enregistrement par sa clé primaire
	 *
	 * @param array|int|string|null $id
	 *
	 * @return ($id is int|string ? array|object|null : list<array|object>)
     */
    public function find($id = null);

    /**
     * Récupère tous les enregistrements
	 *
	 * @return list<array|object>
     */
    public function findAll(?int $limit = null, int $offset = 0);

    /**
     * Crée un nouvel enregistrement
	 *
	 * @return bool|int|mixed
     */
    public function create(array|object $data, bool $returnId = true);

    /**
     * Met à jour un enregistrement
	 *
	 * @param array|int|string $id
	 *
	 * @return bool|mixed
     */
    public function modify($id, array|object $data);

    /**
     * Supprime un enregistrement
     *
     * @param array|int|string $id
     *
     * @return bool|mixed
     */
    public function remove($id, bool $force = false): bool;

    /**
     * Retourne une instance du Query Builder
     */
    public function query(): BuilderInterface;
}
