<?php

declare(strict_types=1);

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;
use Correios\ContadorDePaginas\Controller\{
    CadastrarMatriz,
    ListarMatriz,
    ExcluirMatriz
};
use Correios\ContadorDePaginas\Contador\{
    ContarPaginasMultiplex,
    ContarPaginasInsercao,
    ValidaMultiplexEInsercaoDB,
    ProcessadorDaArquivosMultiplex,
    ProcessadorDaArquivosInsercao,
    ContarObjetosTXT,
    ContarObjetosXML,
    CriarEExcluirArquivoTXT,
    CriarArquivoExcel
};

use \DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use \League\Plates\Engine;

$builder = new \DI\ContainerBuilder();
// 1. Definimos como obter a conexão do banco de dados
$builder->addDefinitions([
    PDO::class => function (): PDO {
        return ConectarBD::getConexao();
    },

    Engine::class => function (): Engine {
        $templatePath = __DIR__ . '/../views';
        return new Engine($templatePath, 'php');
    },

    // Garanta que as classes que usam strings sejam instanciadas corretamente
    CriarEExcluirArquivoTXT::class => \DI\autowire(),
    CriarArquivoExcel::class => \DI\autowire(),
    ContarObjetosTXT::class => \DI\autowire()->constructorParameter('extensaoDoArquivo', '.txt'),
    ContarObjetosXML::class => \DI\autowire()->constructorParameter('extensaoDoArquivo', '.xml'),

    MatrizRepository::class => \DI\autowire(),
    CadastrarMatriz::class => \DI\autowire(),
    ListarMatriz::class => \DI\autowire(),
    ExcluirMatriz::class => \DI\autowire(),
    
    ValidaMultiplexEInsercaoDB::class => \DI\autowire(),
    ContarPaginasMultiplex::class => \DI\autowire(),
    ContarPaginasInsercao::class => \DI\autowire(),
    ContarPaginasMultiplex::class => \DI\autowire(),
    ProcessadorDaArquivosInsercao::class => \DI\autowire(),
    ProcessadorDaArquivosMultiplex::class => \DI\autowire(),

]);

/** @var \Psr\Container\ContainerInterface $container */

$container = $builder->build();

return $container;