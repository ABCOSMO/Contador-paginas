<?php

declare(strict_types=1);

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;
use Correios\ContadorDePaginas\Controller\CadastrarMatriz;
use Psr\Container\ContainerInterface;

$builder = new \DI\ContainerBuilder();
// 1. Definimos como obter a conexão do banco de dados
$builder->addDefinitions([
    PDO::class => function () {
        return ConectarBD::getConexao();
    },

// 2. Configuramos o MatrizRepository
    // Se o construtor dele pedir o PDO, o PHP-DI injeta automaticamente
    MatrizRepository::class => \DI\autowire(),

    // 3. Configuramos o Controller
    // O PHP-DI verá que o CadastrarMatriz, ListarMatriz, ExcluirMatriz pede o MatrizRepository e fará a mágica
    CadastrarMatriz::class => \DI\autowire(),
    ListarMatriz::class => \DI\autowire(),
    ExcluirMatriz::class => \DI\autowire(),
]);

/** @var \Psr\Container\ContainerInterface $container */

$container = $builder->build();

return $container;