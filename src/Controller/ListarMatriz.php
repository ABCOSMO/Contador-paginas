<?php
require_once __DIR__ . '/../../vendor/autoload.php';
    
use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$conexao = ConectarBD::getConexao();

$matriz = null;

/*
$conteudo = $matriz . " " . $tipoServico . " " . $tipoArquivo . " " . $tipoMatriz . " " . $complementar . " " . $qtdPaginas;
file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
*/
        
$listarMatrizes = new MatrizRepository(
	$conexao,
	$matriz
);		


$resultados = $listarMatrizes->buscarMatriz();
//file_put_contents(__DIR__ . '/debug.log', print_r($resultados, true));


header('Content-Type: application/json');

// Verifica se o método retornou um array com sucesso
if (is_array($resultados)) {
    // Se for um array, significa que a busca foi bem-sucedida.
    // Retorna a resposta no formato JSON desejado.
    echo json_encode([
        'success' => true,
        'message' => 'Matrizes encontradas com sucesso.',
        'data' => $resultados
    ]);
} else {
    // Se o método retornou null, significa que houve um erro.
    // Retorna um JSON de erro.
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao buscar matrizes no banco de dados.'
    ]);
}