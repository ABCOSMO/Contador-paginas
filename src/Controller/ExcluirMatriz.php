<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$conexao = ConectarBD::getConexao();

$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson, true);

header('Content-Type: application/json');

if (json_last_error() === JSON_ERROR_NONE && is_array($dados) && !empty($dados) && isset($dados['matriz'])) {
    // Os dados são válidos e podem ser processados
    $matriz = $dados['matriz'];

    $ExcluirMatriz = new MatrizRepository(
        $conexao,
        $matriz
    );

    $resultado = $ExcluirMatriz->excluir();

    echo json_encode([
        'success' => $resultado['success'],
        'message' => $resultado['message']
    ]);
    exit;
} else {
    // Tratar erros de decodificação ou dados inválidos
    http_response_code(400); // Define o código de status HTTP para Bad Request
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao processar os dados: ' . json_last_error_msg()
    ]);
    exit;
}