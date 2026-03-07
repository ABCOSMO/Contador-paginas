<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\Plates\Engine;

class ControllerContadorMultiplex implements RequestHandlerInterface
{
    public function __construct(private Engine $templates)
    {
        $this->templates = $templates;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->templates->render('contador-multiplex');
        return new Response(200, body: $html);
    }
}