<?php
require_once __DIR__ . '/../../vendor/autoload.php';

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

/*
$conteudo = $extensaoTXT;
file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);


$caminhoDoArquivo = "//Mbs10061036/e/PRODUCAO/CONTAGEM_MULTIPLEX/ZIP/";
$destinoDoArquivo = "//Mbs10061036/e/PRODUCAO/CONTAGEM_MULTIPLEX/RESULTADO/";
$caminhoTemporarioDoArquivo = "/../tmp/multiplex/";
*/

$caminhoDoArquivo = "../../tmp/ZIP/";
$destinoDoArquivo =  "../../tmp/RESULTADO/";
$caminhoTemporarioDoArquivo = "/../../tmp/multiplex/";


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

// Adicione esta linha para ver o conteúdo do array retornado
//file_put_contents(__DIR__ . '/debug.log', print_r($resultado, true));

header('Content-Type: application/json');

// Verifica se o resultado é um array
if (is_array($resultado)) {
    // Retorna a resposta no formato que o JavaScript espera
    if (isset($resultado['status']) && $resultado['status'] === 'sucesso') {
        echo json_encode([
            'success' => true,
            'message' => $resultado['mensagem']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $resultado['mensagem']
        ]);
    }
} else {
    // Em caso de erro inesperado, retorna um JSON de erro
    echo json_encode([
        'success' => false,
        'message' => 'Erro inesperado na aplicação.'
    ]);
}
