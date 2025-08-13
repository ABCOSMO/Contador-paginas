<?php
error_reporting(0);
ob_start();
require_once __DIR__ . '/../../vendor/autoload.php';
    
use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$conexao = ConectarBD::getConexao();

$matriz = isset($_POST['matriz']) ? $_POST['matriz'] : null;
$tipoServico = $_POST['tipoServico'];
$tipoArquivo = $_POST['tipoArquivo'];
$tipoMatriz = $_POST['tipoMatriz'];
$complementar = $_POST['complementar'];
$qtdPaginas = $_POST['qtdPaginas'];    
/*
$conteudo = $matriz . " " . $tipoServico . " " . $tipoArquivo . " " . $tipoMatriz . " " . $complementar . " " . $qtdPaginas;

file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
*/
        
$cadastro = new MatrizRepository(
	$conexao,
	$matriz
);		

$cadastro->setTipoServico($tipoServico);
$cadastro->setTipoMatriz($tipoMatriz);
$cadastro->setQtdPaginas($qtdPaginas);
$cadastro->setTipoArquivo($tipoArquivo);
$cadastro->setIdComplementar($complementar);

$salvarMatriz = $cadastro->salvar();
//file_put_contents(__DIR__ . '/debug.log', print_r($salvarMatriz, true));

header('Content-Type: application/json');

if ($salvarMatriz['success']) {
	
	echo json_encode([
		'success' => true,
		'message' => $salvarMatriz['message']
	]);
} else {
	echo json_encode ([
		'success' => false,
		'message' => $salvarMatriz['message']
	]);
}