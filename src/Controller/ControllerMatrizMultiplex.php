<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Correios\ContadorDePaginas\Contador\ProcessadorDaArquivosMultiplex;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerMatrizMultiplex implements RequestHandlerInterface
{
    private ProcessadorDaArquivosMultiplex $processador;

    public function __construct(ProcessadorDaArquivosMultiplex $processador)
    {
        $this->processador = $processador;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
       
        // Pega o caminho absoluto até a pasta FAP
        $basePath = dirname(__DIR__, 2); 

        $caminhoDoArquivo = $basePath . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'ZIP' . DIRECTORY_SEPARATOR;
        $destinoDoArquivo = $basePath . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'RESULTADO' . DIRECTORY_SEPARATOR;
        $caminhoTemporarioDoArquivo = $basePath . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'multiplex' . DIRECTORY_SEPARATOR;


        $contador = $this->processador->getContador();
        $contador->setCaminhoArquivo($caminhoDoArquivo);
        $contador->setDestinoArquivo($destinoDoArquivo);
        $contador->setCaminhoTemporario($caminhoTemporarioDoArquivo);

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