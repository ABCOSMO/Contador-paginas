<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Correios\ContadorDePaginas\Contador\ProcessadorDaArquivosInsercao;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerMatrizInsercao implements RequestHandlerInterface
{
    private ProcessadorDaArquivosInsercao $processador;

    public function __construct(ProcessadorDaArquivosInsercao $processador)
    {
        $this->processador = $processador;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /*
        $conteudo = $extensaoTXT;
        file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
        */

        // Pega o caminho absoluto até a pasta FAP
        $basePath = dirname(__DIR__, 2); 

        // 1. Definição correta das variáveis vinda do $_ENV
        $caminhoDoArquivo = $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $_ENV['PATH_ZIP_FILE']);
        $destinoDoArquivo = $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $_ENV['PATH_RESULTADO']);
        $caminhoTemporarioDoArquivo = $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $_ENV['PATH_INSERCAO']);

        $this->processador->getContador()->
        configurarCaminhos($caminhoDoArquivo, $destinoDoArquivo, $caminhoTemporarioDoArquivo);

        $resultado = $this->processador->processarArquivos();

        // Adicione esta linha para ver o conteúdo do array retornado
        //file_put_contents(__DIR__ . '/debug.log', print_r($resultado, true));

        // 4. Tratamento da Resposta
        if (is_array($resultado) && isset($resultado['status']) && $resultado['status'] === 'sucesso') {
            return new Response(200, ['Content-Type' => 'application/json'], json_encode([
                'success' => true,
                'message' => $resultado['mensagem']
            ]));
        }

        // Resposta de erro genérica
        $msgErro = $resultado['mensagem'] ?? 'Erro inesperado na aplicação.';
        return new Response(500, ['Content-Type' => 'application/json'], json_encode([
            'success' => false,
            'message' => $msgErro
        ]));
    }
}
