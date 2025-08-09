<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Correios\ContadorDePaginas\Contador\ContarPaginasMultiplex;
use Correios\ContadorDePaginas\Contador\ValidaMultiplexEInsercaoDB;
use Correios\ContadorDePaginas\Contador\CriarEExcluirArquivoTXT;
use Correios\ContadorDePaginas\Contador\ContarObjetosTXT;
use Correios\ContadorDePaginas\Contador\ContarObjetosXML;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$conexao = ConectarBD::getConexao();
$validador = new ValidaMultiplexEInsercaoDB($conexao);
$extensaoTXT = "txt";
$extensaoArquivoTXT = new ContarObjetosTXT($extensaoTXT);
$extensaoXML = "xml";
$extensaoArquivoXML = new ContarObjetosXML($extensaoXML);

$caminhoDoArquivo = "//Mbs10061036/e/PRODUCAO/CONTAGEM_MULTIPLEX/ZIP/";
$destinoDoArquivo = "//Mbs10061036/e/PRODUCAO/CONTAGEM_MULTIPLEX/RESULTADO/";
$caminhoTemporarioDoArquivo = "/../tmp/multiplex/";

$criarEExcluirArquivoTXT = new CriarEExcluirArquivoTXT($destinoDoArquivo);

$dataAtual = date('d_m_Y'); 
$nomeArquivo = "Arquivos_Multiplex_{$dataAtual}.txt";
$caminhoExcluirArquivo = $destinoDoArquivo . $nomeArquivo;

if (file_exists($caminhoExcluirArquivo)) {
    $criarEExcluirArquivoTXT->excluirArquivoMultiplex($destinoDoArquivo);
}

$criarEExcluirArquivoTXT->criarArquivoMultiplex($destinoDoArquivo);

$logArquivo = "Log_Multiplex_{$dataAtual}.txt";
$caminhoExcluirLog = $destinoDoArquivo . $logArquivo;

if (file_exists($caminhoExcluirLog)) {
    $criarEExcluirArquivoTXT->excluirLogMultiplex($destinoDoArquivo);
}

$criarEExcluirArquivoTXT->criarLogMultiplex($destinoDoArquivo);

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
        
		$arquivoMultiplex->VerificarMatrizTXT($caminhoTemporarioDoArquivo . $arquivo);
		$arquivoMultiplex->VerificarMatrizXML($caminhoTemporarioDoArquivo . $arquivo, $arquivo);
    }
}
