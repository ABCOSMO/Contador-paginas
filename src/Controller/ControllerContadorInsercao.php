<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Correios\ContadorDePaginas\Helper\HtmlRendererTrait;

class ControllerContadorInsercao implements RequestHandlerInterface
{
    use HtmlRendererTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderTemplate('contador-insercao');
        return new Response(200, [], $html);
    }
}