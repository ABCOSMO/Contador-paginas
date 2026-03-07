<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

ob_start();
require_once __DIR__ . '/../../vendor/autoload.php';

class CadastrarMatriz implements RequestHandlerInterface
{
	private MatrizRepository $cadastrarMatriz;

		public function __construct (MatrizRepository $cadastrarMatriz)
		{
			$this->cadastrarMatriz = $cadastrarMatriz;
		}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
		
		$queryBody = $request->getParsedBody();
		$matriz = isset($queryBody['matriz']) ? filter_var($queryBody['matriz'], FILTER_VALIDATE_INT) : null;
		$tipoServico = filter_var($queryBody['tipoServico'], FILTER_VALIDATE_INT);
		$tipoArquivo = filter_Var($queryBody['tipoArquivo'], FILTER_VALIDATE_INT);
		$tipoMatriz = filter_var($queryBody['tipoMatriz'], FILTER_VALIDATE_INT);
		$complementar = filter_var($queryBody['complementar'], FILTER_VALIDATE_INT);
		$qtdPaginas = filter_var($queryBody['qtdPaginas'], FILTER_VALIDATE_INT);    
		/*
		$conteudo = $matriz . " " . $tipoServico . " " . $tipoArquivo . " " . $tipoMatriz . " " . $complementar . " " . $qtdPaginas;

		file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
		*/

		$this->cadastrarMatriz->setMatriz((int)$matriz);
		$this->cadastrarMatriz->setTipoServico((int)$tipoServico);
		$this->cadastrarMatriz->setTipoMatriz((int)$tipoMatriz);
		$this->cadastrarMatriz->setQtdPaginas((int)$qtdPaginas);
		$this->cadastrarMatriz->setTipoArquivo((int)$tipoArquivo);
		$this->cadastrarMatriz->setIdComplementar((int)$complementar);

		$salvarMatriz = $this->cadastrarMatriz->salvar();
		//file_put_contents(__DIR__ . '/debug.log', print_r($salvarMatriz, true));

		$statusCode = $salvarMatriz['success'] ? 200 : 500;

		return new Response($statusCode, [
			'Content-Type' => 'application/json'
		], body: json_encode([
			'success' => $salvarMatriz['success'],
			'message' => $salvarMatriz['message']
		]));			
    }
}