<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Correios\ContadorDePaginas\Contador\{
    ContarPaginasMultiplex,
    ValidaMultiplexEInsercaoDB,
    ProcessadorDaArquivosMultiplex,
    CriarEExcluirArquivoTXT,
    CriarArquivoExcel,
    ContarObjetosTXT,
    ContarObjetosXML
};

use Correios\ContadorDePaginas\Conectar\ConectarBD;

class ControllerMatrizMultiplex implements Controller
{
    public function processaRequisicao(): void
    {
        $extensaoTXT = "txt";
        $extensaoXML = "xml";
        $conexao = ConectarBD::getConexao();
        $validador = new ValidaMultiplexEInsercaoDB($conexao);
        $extensaoArquivoTXT = new ContarObjetosTXT($extensaoTXT);
        $extensaoArquivoXML = new ContarObjetosXML($extensaoXML);

        // Pega o caminho absoluto até a pasta FAP
        $basePath = dirname(__DIR__, 2); 

        $caminhoDoArquivo = $basePath . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'ZIP' . DIRECTORY_SEPARATOR;
        $destinoDoArquivo = $basePath . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'RESULTADO' . DIRECTORY_SEPARATOR;
        $caminhoTemporarioDoArquivo = $basePath . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'multiplex' . DIRECTORY_SEPARATOR;


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

        exit();
    }

}