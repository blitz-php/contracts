<?php

/**
 * This file is part of Blitz PHP framework.
 *
 * (c) 2022 Dimitri Sitchet Tomkeu <devcode.dst@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BlitzPHP\Contracts\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ResponsableInterface
{
    public function getResponse(): ResponseInterface;

    /**
     * Créez une réponse HTTP qui représente l'objet.
     */
    public function toResponse(ServerRequestInterface $request): ResponseInterface;
}
