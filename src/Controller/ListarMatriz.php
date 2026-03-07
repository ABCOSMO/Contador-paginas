<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListarMatriz implements RequestHandlerInterface
{
    private MatrizRepository $listarMatrizes;

    public function __construct (MatrizRepository $listarMatrizes)
    {
        $this->listarMatrizes = $listarMatrizes;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $resultados = $this->listarMatrizes->buscarMatriz();

        //header('Content-Type: application/json');

        if (is_array($resultados)) {
            $mensagem = [
                'success' => true,
                'message' => 'Matrizes encontradas com sucesso.',
                'data' => $resultados
            ];
            return new Response(200, [
                'Content-Type' => 'application/json'
                ], body: json_encode($mensagem));
        } else {
            $mensagem = [
                'success' => false,
                'message' => 'Erro ao buscar matrizes no banco de dados.'
            ];

            return new Response(500, [
                'Content-Type' => 'application/json'
                ], body: json_encode($mensagem));
        }        
        // Importante encerrar a execução para não vazar lixo na resposta JSON
        //exit;
    }
}