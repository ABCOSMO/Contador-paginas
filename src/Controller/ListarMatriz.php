<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

class ListarMatriz implements Controller
{
    public function processaRequisicao(): void
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