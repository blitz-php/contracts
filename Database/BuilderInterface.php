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

use Closure;
use PDO;

/**
 * Interface BuilderInterface
 *
 * Définit les méthodes fondamentales du Query Builder.
 */
interface BuilderInterface
{
    /**
     * Constructor
     */
    public function __construct(ConnectionInterface $db);

    /**
     * Renvoie la connexion actuelle à la base de données
     */
    public function db(): ConnectionInterface;

    /**
     * Définit un statut de mode de test.
     */
    public function testMode(bool $mode = true): static;

    /**
     * Spécifie que le builder est dans un état d'attente et qu'on ne doit pas l'exécuter
     */
    public function pending(bool $state = true): static;

    /**
     * Recupere le nom de la table principale.
     */
    public function getTable(): string;

    /**
     * Génère la partie FROM de la requête
     *
     * @param list<string>|string|null $from
     */
    public function from($from, bool $overwrite = false): static;

    /**
     * Alias de from()
     */
    public function table($from): static;

    /**
     * Définit la table dans laquelle les données seront insérées
     */
    public function into(string $table): static;

    /**
     * Ajoute une sous-requête dans la clause FROM
     */
    public function fromSubquery(self $builder, string $alias = ''): static;

    /**
     * Génère la partie JOIN de la requête
     *
     * @param string                $table Table à joindre
     * @param array|string|Closure  $first Champs à joindre, condition, ou callback
     * @param string|null           $operator Opérateur de comparaison
     * @param string|null           $second Deuxième colonne pour la condition
     * @param string                $type Type de jointure (INNER, LEFT, RIGHT, etc.)
     */
    public function join(string $table, array|string|Closure $first, ?string $operator = null, $second = null, string $type = 'INNER'): static;

    /**
     * Ajoute une requête UNION
     */
    public function union(Closure|self $query, bool $all = false): static;

    /**
     * Ajoute une clause WHERE
     *
     * @param array|Closure|string $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @param string $boolean
     */
    public function where($column, $operator = null, $value = null, string $boolean = 'and'): static;

    /**
     * Ajoute une clause HAVING
     */
    public function having($column, $operator = null, $value = null, string $boolean = 'and'): static;

    /**
     * Ajoute des champs pour les tri
     *
     * @param array|string $column
     */
    public function orderBy($column, string $direction = 'ASC'): static;

    /**
     * Ajoute des champs à regrouper.
     *
     * @param array|string $column
     */
    public function groupBy($column): static;

    /**
     * Ajoute une clause LIMIT
     */
    public function limit(int $limit, ?int $offset = null): static;

    /**
     * Ajoute une clause OFFSET
     */
    public function offset(int $offset, ?int $limit = null): static;

    /**
     * Définit les colonnes à sélectionner
     *
     * @param array|string $columns
     */
    public function select($columns = '*'): static;

    /**
     * Ajoute une clause DISTINCT
     */
    public function distinct(bool $value = true): static;

    /**
     * Ajoute une sous requete a la selection
     */
    public function selectSubquery(self $subquery, string $as): static;

    /**
     * Définit les valeurs pour INSERT/UPDATE
     *
     * @param array|object|string $key
     * @param mixed $value
     */
    public function set($key, $value = ''): static;

    /**
     * Construit une requête d'insertion.
     *
     * @return bool|static|string
     */
    public function insert(array|object $data = []);

    /**
     * UPSERT (INSERT ... ON DUPLICATE KEY UPDATE)
     *
     * @return int|string
     */
    public function upsert(array $values, array $uniqueBy, ?array $update = null);

    /**
     * Construit une requête de mise à jour.
     *
     * @return int|static|string
     */
    public function update(array|object $data = []);

    /**
     * Construit une requête de remplacement.
     *
     * @return int|static|string
     */
    public function replace(array|object $data = []);

    /**
     * Construit une requête de suppression.
     *
     * @return int|self|string
     */
    public function delete(?array $where = null, ?int $limit = null);

    /**
     * Exécute une requête TRUNCATE
     *
     * @return bool|string
     */
    public function truncate(?string $table = null);

    /**
     * Exécute la requête construite
     *
     * @return ResultInterface|bool|self
     */
    public function execute();

    /**
     * Exécute une requête SQL directe
     *
     * @return bool|ResultInterface
     */
    public function query(string $sql, array $params = []);

    /**
     * Obtient la valeur minimale d'un champ spécifié.
     *
     * @return float|string
     */
    public function min(string $column);

    /**
     * Obtient la valeur maximale d'un champ spécifié.
     *
     * @return float|string
     */
    public function max(string $column);

    /**
     * Obtient la somme des valeurs d'un champ spécifié.
     *
     * @return float|string
     */
    public function sum(string $column);

    /**
     * Obtient la valeur moyenne pour un champ spécifié.
     *
     * @return float|string
     */
    public function avg(string $column);

    /**
     * Obtient le nombre d'enregistrements pour une table.
     *
     * @return int|string
     */
    public function count(string $column = '*');

    /**
     * Récupère plusieurs lignes des resultats de la requete select.
     */
    public function result(int|string $type = PDO::FETCH_OBJ): array;

    /**
     * Récupère la premiere ligne des resultats de la requete select.
     */
    public function first(int|string $type = PDO::FETCH_OBJ): mixed;

    /**
     * Récupère une ligne spécifique
     */
    public function row(int $index, int|string $type = PDO::FETCH_OBJ): mixed;

    /**
     * Récupère la valeur d'un ou de plusieurs champs.
     *
     * @param list<string>|string $name
     *
     * @return list<mixed>|mixed
     */
    public function value(array|string $name);

    /**
     * Récupère les valeurs d'un ou de plusieurs champs.
     *
     * @param list<string>|string $name
     *
     * @return list<mixed>
     */
    public function values(array|string $name): array;

    /**
     * Vérifie si des enregistrements existent
     */
    public function exists(): bool;

    /**
     * Récupère le SQL sans l'exécuter
     */
    public function toSql(): string;

    /**
     * Récupère le SQL avec les bindings échappés
     */
    public function toRawSql(): string;
}
