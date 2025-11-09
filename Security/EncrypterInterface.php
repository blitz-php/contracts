<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Security;

/**
 * Gestionnaire de chiffrement BlitzPHP
 *
 * Fournit un cryptage à clé bidirectionnel
 *
 * @credit <a href="http://www.codeigniter.com">CodeIgniter 4.4 - CodeIgniter\Encryption\EncrypterInterface</a>
 */
interface EncrypterInterface
{
    /**
     * Chiffrer - convertir le texte brut en texte chiffré
     *
     * @param array|string|null $params Paramètres remplacés, en particulier la clé
     */
    public function encrypt(string $data, array|string|null $params = null): string;

    /**
     * Décrypter - convertir le texte chiffré en texte brut
     *
     * @param array|string|null $params Paramètres remplacés, en particulier la clé
     */
    public function decrypt(string $data, array|string|null $params = null): string;

    /**
     * Obtenir la clé de chiffrement que le chiffreur utilise actuellement.
     */
    public function getKey(): string;
}
