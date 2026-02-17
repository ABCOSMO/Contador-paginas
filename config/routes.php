<?php

declare(strict_types=1);


return [
    'GET|/' => \Correios\ContadorDePaginas\Controller\ControllerMainPage::class,
    'GET|/cadastrar-matriz' => \Correios\ContadorDePaginas\Controller\ControllerCadastrarMatriz::class,
    'GET|/contador-multiplex' => \Correios\ContadorDePaginas\Controller\ControllerContadorMultiplex::class,
    'POST|/contador-multiplex' => \Correios\ContadorDePaginas\Controller\ControllerContadorMultiplex::class,
    'POST|/cadastrar-nova-matriz' => \Correios\ContadorDePaginas\Controller\CadastrarMatriz::class,
    'GET|/listar-matriz' => \Correios\ContadorDePaginas\Controller\ControllerListarMatriz::class,
    'GET|/visualizar-matrizes' => \Correios\ContadorDePaginas\Controller\ListarMatriz::class,
    'POST|/excluir-matriz' => \Correios\ContadorDePaginas\Controller\ExcluirMatriz::class
];
