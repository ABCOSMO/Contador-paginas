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
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $conexao = ConectarBD::getConexao();
        $matriz = null;

        $listarMatrizes = new MatrizRepository(
            $conexao,
            $matriz
        );

        $resultados = $listarMatrizes->buscarMatriz();

        header('Content-Type: application/json');

        if (is_array($resultados)) {
            echo json_encode([
                'success' => true,
                'message' => 'Matrizes encontradas com sucesso.',
                'data' => $resultados
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao buscar matrizes no banco de dados.'
            ]);
        }
        
        // Importante encerrar a execução para não vazar lixo na resposta JSON
        exit;
    }
}