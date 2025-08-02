<?php
require_once __DIR__ . '/../../vendor/autoload.php';
    
use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$conexao = ConectarBD::getConexao();

$matriz = $_POST['matriz'];
$tipoArquivo = $_POST['tipoArquivo'];
$tipoMatriz = $_POST['tipoMatriz'];
$complementar = $_POST['complementar'];
$qtdPaginas = $_POST['qtdPaginas'];    
/*
$conteudo = $matriz . " " . $tipoArquivo . " " . $tipoMatriz . " " . $complementar . " " . $qtdPaginas;

file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
*/
        
$cadastro = new MatrizRepository(
	$conexao,
	$matriz
);		
       
$cadastro->setTipoMatriz($tipoMatriz);
$cadastro->setQtdPaginas($qtdPaginas);
$cadastro->setTipoArquivo($tipoArquivo);
$cadastro->setIdComplementar($complementar);

$cadastro->salvar();