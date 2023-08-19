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

interface ConnectionResolverInterface
{
    /**
     * Get a database connection instance.
     */
    public function connection(?string $name = null): ConnectionInterface;

	/**
	* Ouvre une connexion a la base de donnees
	*
	* @param array|ConnectionInterface|string|null $group  Nom du groupe de connexion à utiliser, ou un tableau de paramètres de configuration.
	* @param bool                                  $shared Doit-on retourner une instance partagée
	*/
   public function connect($group = null, bool $shared = true): ConnectionInterface;

   /**
   * Recupere les informations a utiliser pour la connexion a la base de données
   *
   * @return array [group, configuration]
   */
  public function connectionInfo(array|string|null $group = null): array;

    /**
     * Get the default connection name.
     */
    public function getDefaultConnection(): string;

    /**
     * Set the default connection name.
     */
    public function setDefaultConnection(string $name): void;
}
