<?php

declare(strict_types=1);

$pastaCliente = 'barbeariabroklin';


return [
    'GET|/' . $pastaCliente . '/' => \Correios\ContadorDePaginas\Controller\ControllerMainPage::class,
    'GET|/' . $pastaCliente . '/cadastrar-matriz' => \Correios\ContadorDePaginas\Controller\ControllerCadastrarMatriz::class,
    'GET|/' . $pastaCliente . '/contador-multiplex' => \Correios\ContadorDePaginas\Controller\ControllerContadorMultiplex::class,
    'POST|/' . $pastaCliente . '/contador-multiplex' => \Correios\ContadorDePaginas\Controller\ControllerContadorMultiplex::class
];
