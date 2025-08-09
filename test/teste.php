<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Correios\ContadorDePaginas\Contador\ContarPaginasMultiplex;
use Correios\ContadorDePaginas\Contador\ValidaMultiplexDB;
use Correios\ContadorDePaginas\Contador\ContarObjetosTXT;
use Correios\ContadorDePaginas\Contador\ContarObjetosXML;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$conexao = ConectarBD::getConexao();
$validador = new ValidaMultiplexDB($conexao);
$extensaoTXT = "txt";
$extensaoArquivoTXT = new ContarObjetosTXT($extensaoTXT);
$extensaoXML = "xml";
$extensaoArquivoXML = new ContarObjetosXML($extensaoXML);

$caminhoDoArquivo = "../tmp/ZIP/";
$destinoDoArquivo = "//Mbs10061036/e/PRODUCAO/CONTAGEM_MULTIPLEX/RESULTADO/";
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

$arquivos = scandir($caminhoDoArquivo);

// Remove "." e ".." do array de arquivos
$arquivos = array_diff($arquivos, array('.', '..'));

if (empty($arquivos)) {
    echo "Pasta Vazia." . "<br>";
} else {
    foreach ($arquivos as $arquivo) {
        $caminhoENomeDoArquivo = $caminhoDoArquivo . $arquivo;
        $arquivoMultiplex->setCaminhoENomeDoArquivo($caminhoENomeDoArquivo);
        
        if ($arquivoMultiplex->verificarEExtrairArquivo()) {
            echo "Arquivo " . $arquivo . " encontrado e processado!" . "<br>";
        } else {
            echo "Não foi possível processar o arquivo " . $arquivo . "." . "<br>";
        }
        
		$arquivoMultiplex->VerificarMatrizTXTNoBD($caminhoTemporarioDoArquivo . $arquivo);
		$arquivoMultiplex->VerificarMatrizXMLNoBD($caminhoTemporarioDoArquivo . $arquivo);
    }
}
