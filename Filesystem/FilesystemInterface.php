<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Filesystem;

/**
 * L'interface de manipulation du systeme de fichier de BlitzPHP
 */
interface FilesystemInterface
{
    /**
     * Visibilité publique.
     *
     * @var string
     */
    public const VISIBILITY_PUBLIC = 'public';

    /**
     * Visibilité privée.
     *
     * @var string
     */
    public const VISIBILITY_PRIVATE = 'private';

    /**
     * Déterminer si un fichier existe.
     */
    public function exists(string $path): bool;

    /**
     * Obtenir le contenu d'un fichier.
     */
    public function get(string $path): ?string;

    /**
     * Obtenir une ressource pour lire le fichier.
     *
     * @return resource|null The path resource or null on failure.
     */
    public function readStream(string $path);

    /**
     * Écrire le contenu d'un fichier.
     *
     * @param resource|string $contents
     *
     * @return bool
     */
    public function put(string $path, $contents, mixed $options = []);

    /**
     * Écriture d'un nouveau fichier à l'aide d'un flux.
     *
     * @param resource $resource
     *
     * @return bool
     */
    public function writeStream(string $path, $resource, array $options = []);

    /**
     * Obtenir la visibilité du chemin donné.
     */
    public function getVisibility(string $path): string;

    /**
     * Définir la visibilité du chemin donné.
     */
    public function setVisibility(string $path, string $visibility): bool;

    /**
     * Ajouter un contenu textuel au debut d'un fichier.
     */
    public function prepend(string $path, string $data): bool;

    /**
     * Ajouter un contenu textuel à la fin d'un fichier.
     */
    public function append(string $path, string $data): bool;

    /**
     * Supprime le fichier situé à un emplacement donné.
     */
    public function delete(array|string $paths): bool;

    /**
     * Copier un fichier vers un nouvel emplacement.
     */
    public function copy(string $from, string $to): bool;

    /**
     * Déplacer un fichier vers un nouvel emplacement.
     */
    public function move(string $from, string $to): bool;

    /**
     * Obtenir la taille d'un fichier donné.
     */
    public function size(string $path): int;

    /**
     * Obtenir l'heure de la dernière modification du fichier.
     */
    public function lastModified(string $path): int;

    /**
     * Obtenir un tableau de tous les fichiers d'un répertoire.
     */
    public function files(?string $directory = null, bool $recursive = false): array;

    /**
     * Récupère tous les fichiers du répertoire donné (récursif).
     */
    public function allFiles(?string $directory = null): array;

    /**
     * Obtenir tous les répertoires d'un répertoire donné.
     */
    public function directories(?string $directory = null, bool $recursive = false): array;

    /**
     * Obtenir tous les répertoires (récursifs) d'un répertoire donné.
     */
    public function allDirectories(?string $directory = null): array;

    /**
     * Créer un répertoire.
     */
    public function makeDirectory(string $path): bool;

    /**
     * Supprimer un répertoire de manière récursive.
     */
    public function deleteDirectory(string $directory): bool;
}
