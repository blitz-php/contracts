<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Event;

/**
 * Interface pour les gestionnaires d'événements.
 *
 * Ceci est une copie de l'ancienne interface des evenements PSR-14
 * L'EventManager a été remplacé par l'EventDispatcher mais BlitzPHP continue d'utiliser l'ancienne spécification va savoir pourquoi 😅
 */
interface EventManagerInterface
{
    /**
     * Ajoute un écouteur d'événement
     *
     * @param string   $event    Nom de l'événement à écouter
     * @param callable $callback Callback à exécuter
     * @param int      $priority Priorité d'exécution (plus bas = exécuté en premier)
     *
     * @return bool True si l'écouteur a été ajouté avec succès
     */
    public function on(string $event, callable $callback, int $priority = 0): bool;

    /**
     * Supprime un écouteur d'événement
     *
     * @param string   $event    Nom de l'événement
     * @param callable $callback Callback à supprimer
     *
     * @return bool True si l'écouteur a été supprimé avec succès
     */
    public function off(string $event, callable $callback): bool;

    /**
     * Déclenche un événement
     *
     * @param EventInterface|string $event  Objet événement ou nom de l'événement
     * @param object|string         $target Cible/context de l'événement
     * @param array|object          $argv   Paramètres supplémentaires
     *
     * @return mixed Résultat de l'exécution des écouteurs
     */
    public function emit($event, $target = null, $argv = []);

    /**
     * Récupère tous les écouteurs ou ceux d'un événement spécifique
     *
     * @param string|null $event Nom de l'événement (null pour tous)
     *
     * @return array Liste des écouteurs
     */
    public function getListeners(?string $event = null): array;

    /**
     * Supprime tous les écouteurs ou ceux d'un événement spécifique
     *
     * @param string|null $event Nom de l'événement (null pour tous)
     */
    public function clearListeners(?string $event = null): void;
}
