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

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerMatrizMultiplex implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
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

        // Verifica se o resultado é um array
        if (is_array($resultado)) {
            // Retorna a resposta no formato que o JavaScript espera
            if (isset($resultado['status']) && $resultado['status'] === 'sucesso') {
                $mensagem = [
                    'success' => true,
                    'message' => $resultado['mensagem']
                ];
                return new Response(200, [
                    'Content-Type' => 'application/json'
                    ], body: json_encode($mensagem));
            } else {
                $mensagem = [
                    'success' => false,
                    'message' => $resultado['mensagem']
                ];
                return new Response(500, [
                    'Content-Type'=> 'application/json'
                    ], body: json_encode($mensagem));
            }
        } else {
            // Em caso de erro inesperado, retorna um JSON de erro
            $mensagem = [
                'success' => false,
                'message' => 'Erro inesperado na aplicação.'
            ];
            return new Response(500, [
                'Content-Type' => 'application/json'
                ], body: json_encode($mensagem));
        }
        exit();
    }

}