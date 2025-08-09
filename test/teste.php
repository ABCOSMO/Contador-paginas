<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Correios\ContadorDePaginas\Contador\ContarPaginasMultiplex;
use Correios\ContadorDePaginas\Contador\ValidaMultiplexEInsercaoDB;
use Correios\ContadorDePaginas\Contador\ProcessadorDaArquivosMultiplex;
use Correios\ContadorDePaginas\Contador\CriarEExcluirArquivoTXT;
use Correios\ContadorDePaginas\Contador\CriarArquivoExcel;
use Correios\ContadorDePaginas\Contador\ContarObjetosTXT;
use Correios\ContadorDePaginas\Contador\ContarObjetosXML;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$extensaoTXT = "txt";
$extensaoXML = "xml";
$conexao = ConectarBD::getConexao();
$validador = new ValidaMultiplexEInsercaoDB($conexao);
$extensaoArquivoTXT = new ContarObjetosTXT($extensaoTXT);
$extensaoArquivoXML = new ContarObjetosXML($extensaoXML);

$caminhoDoArquivo = "../tmp/ZIP/";
$destinoDoArquivo =  "../tmp/RESULTADO/";
$caminhoTemporarioDoArquivo = "/../tmp/multiplex/";

$arquivoMultiplex = new ContarPaginasMultiplex(
	$caminhoDoArquivo,
	$destinoDoArquivo,
	$caminhoTemporarioDoArquivo,
	$conexao,
	$validador,
	$extensaoArquivoTXT,
    $extensaoArquivoXML
);

$processador = new ProcessadorDaArquivosMultiplex(
    $arquivoMultiplex,
    new CriarEExcluirArquivoTXT($destinoDoArquivo),
    new CriarArquivoExcel($destinoDoArquivo),
    $conexao
);

$resultado = $processador->processarArquivos();

if(is_array($resultado) || is_object($resultado)) {
   foreach ($resultado as $mensagem) {
    echo $mensagem . "<br>";
    }
}
    
