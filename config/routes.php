<?php

declare(strict_types=1);


return [
    'GET|/' => \Correios\ContadorDePaginas\Controller\ControllerMainPage::class,
    'GET|/cadastrar-matriz' => \Correios\ContadorDePaginas\Controller\ControllerCadastrarMatriz::class,
    'GET|/contador-multiplex' => \Correios\ContadorDePaginas\Controller\ControllerContadorMultiplex::class,
    'POST|/contador-multiplex' => \Correios\ContadorDePaginas\Controller\ControllerContadorMultiplex::class
];
