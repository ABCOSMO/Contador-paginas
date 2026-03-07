<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExcluirMatriz implements RequestHandlerInterface
{
    private MatrizRepository $excluirMatriz;

    public function __construct(MatrizRepository $excluirMatriz)
    {
        // Renomeado para $excluirMatriz para clareza (o papel da classe é ExcluirMatriz)
        $this->excluirMatriz = $excluirMatriz;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $corpo = $request->getBody()->getContents();
        $dados = json_decode($corpo, true);

        // 1. Validação do JSON e dados obrigatórios
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->jsonResponse(400, false, 'JSON inválido: ' . json_last_error_msg());
        }

        if (!isset($dados['matriz']) || empty($dados['matriz'])) {
            return $this->jsonResponse(400, false, 'O campo "matriz" é obrigatório.');
        }

        // 2. Processamento
        $this->excluirMatriz->setMatriz((int) $dados['matriz']);
        $resultado = $this->excluirMatriz->excluir();

        // 3. Resposta Final
        $status = $resultado['success'] ? 200 : 500;
        return $this->jsonResponse($status, $resultado['success'], $resultado['message']);
    }

    /**
     * Método auxiliar para evitar repetição de criação de Response
     */
    private function jsonResponse(int $status, bool $success, string $message): ResponseInterface
    {
        return new Response($status, ['Content-Type' => 'application/json'], json_encode([
            'success' => $success,
            'message' => $message
        ]));
    }
}