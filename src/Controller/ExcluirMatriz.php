<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;
use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExcluirMatriz implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $conexao = ConectarBD::getConexao();

        $dadosJson = $request->getBody()->getContents();
        $dados = json_decode($dadosJson, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($dados) && !empty($dados) && isset($dados['matriz'])) {
            // Os dados são válidos e podem ser processados
            $matriz = intval($dados['matriz']);

            $ExcluirMatriz = new MatrizRepository(
                $conexao,
                $matriz
            );

            $resultado = $ExcluirMatriz->excluir();
            $mensagem = [
                'success' => $resultado['success'],
                'message' => $resultado['message']
            ];

            return new Response(200, [
                'Content-Type' => 'application/json',
                ], body: json_encode($mensagem));
            exit;
            
        } else {

            $mensagem = [
                'success' => false,
                'message' => 'Erro ao processar os dados: ' . json_last_error_msg()
            ];

            return new Response(500, [
                'Content-Type' => 'application/json'
                ], body: json_encode($mensagem));
            exit;
        }
    }
}