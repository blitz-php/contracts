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

use PDO;

/**
 * ConnectionInterface
 */
interface ConnectionInterface
{
    /**
     * Initialise la connexion/les paramètres de la base de données.
     *
     * @return mixed
     */
    public function initialize();

    /**
     * Connexion à la base de données.
     *
     * @return PDO|false
     */
    public function connect(bool $persistent = false): mixed;

    /**
     * Conservez ou établissez la connexion si aucune requête n'a été envoyée pendant une durée supérieure au délai d'inactivité du serveur.
     *
     * @return mixed
     */
    public function reconnect();

    /**
     * Fermeture d'une connection
     */
    public function close(): void;

    /**
     * Renvoie l'objet de connexion réel.
     */
    public function getConnection(): PDO;

    /**
     * Sélectionnez une table de base de données spécifique à utiliser.
     *
     * @return mixed
     */
    public function setDatabase(string $databaseName);

    /**
     * Renvoie le nom de la base de données en cours d'utilisation.
     */
    public function getDatabase(): string;

    /**
     * Renvoie la dernière erreur rencontrée par cette connexion.
     * Doit retourner ce format : ['code' => string|int, 'message' => string]
     * intval(code) === 0 signifie "pas d'erreur".
     *
     * @return array<string, int|string>
     */
    public function error(): array;

    /**
     * Le nom du pilote de base de données utilisé (mysql, pgsql, sqlite, etc)
     */
    public function getDriver(): string;

    /**
     * Le nom de la plateforme utilisée (MySQLi, mssql, etc)
     */
    public function getPlatform(): string;

    /**
     * Renvoie une chaîne contenant la version de la base de données utilisée.
     */
    public function getVersion(): string;

    /**
     * Orchestre une requête sur la base de données.
     * Les requêtes doivent utiliser des objets Database\Statement pour stocker la requête et la construire.
     * Cette méthode fonctionne avec le cache.
     *
     * Doit gérer automatiquement différentes connexions pour les requêtes de lecture/écriture si nécessaire.
     */
    public function query(string $sql, array $bindings = []): ResultInterface;

    /**
     * Effectue une requête de base sur la base de données.
     * Aucune liaison ou mise en cache n'est effectuée, et les transactions ne sont pas traitées.
     * Prend simplement une chaîne de requête brute et renvoie l'ID de résultat spécifique à la base de données.
     *
     * @return mixed
     */
    public function simpleQuery(string $sql);

    /**
     * Renvoie une instance du générateur de requêtes pour cette connexion.
     *
     * @param list<string>|string $tableName
     */
    public function table(array|string $tableName): BuilderInterface;

    /**
     * Renvoie l'objet d'instruction de la dernière requête.
     *
     * @return mixed
     */
    public function getLastQuery();

    /**
     * Escapade "intelligente"
     *
     * Échappe les données en fonction du type.
     * Définit les types booléens et nuls.
     *
     * @param mixed $str
     *
     * @return mixed
     */
    public function escape($str);
}
