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
 * Representation d'un evenement
 *
 * Ceci est une copie de l'ancienne interface des evenements PSR-14
 * L'EventManager a été remplacé par l'EventDispatcher mais BlitzPHP continue d'utiliser l'ancienne spécification va savoir pourquoi 😅
 */
interface EventInterface
{
    public const PRIORITY_LOW    = -10;
    public const PRIORITY_NORMAL = 0;
    public const PRIORITY_HIGH   = 10;

    /**
     * Récupère le nom de l'événement
     *
     * @return string Le nom de l'événement
     */
    public function getName(): string;

    /**
     * Définit le nom de l'événement
     *
     * @param string $name Le nom de l'événement
     */
    public function setName(string $name): self;

    /**
     * Récupère la cible/context de l'événement
     *
     * @return object|string|null La cible de l'événement
     */
    public function getTarget();

    /**
     * Définit la cible/context de l'événement
     *
     * @param object|string $target La cible de l'événement
     */
    public function setTarget(object|string $target): self;

    /**
     * Récupère tous les paramètres de l'événement
     *
     * @return array Les paramètres de l'événement
     */
    public function getParams(): array;

    /**
     * Récupère un paramètre spécifique par son nom
     *
     * @param string $name   Le nom du paramètre
     * @param mixed $default Valeur par defaut
	 *
     * @return mixed La valeur du paramètre ou null si non trouvé
     */
	public function getParam(string $name, mixed $default = null): mixed;

    /**
     * Définit tous les paramètres de l'événement
     *
     * @param array $params Les paramètres de l'événement
     */
    public function setParams(array $params): self;

    /**
     * Vérifie si la propagation de l'événement a été arrêtée
     *
     * @return bool True si la propagation est arrêtée, false sinon
     */
    public function isPropagationStopped(): bool;

    /**
     * Arrête ou redémarre la propagation de l'événement
     *
     * @param bool $flag True pour arrêter, false pour redémarrer
     */
    public function stopPropagation(bool $flag = true): void;
}
