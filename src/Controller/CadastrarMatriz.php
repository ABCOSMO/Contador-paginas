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
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

		$conexao = ConectarBD::getConexao();

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
				
		$cadastro = new MatrizRepository(
			$conexao,
			$matriz
		);		

		$cadastro->setTipoServico($tipoServico);
		$cadastro->setTipoMatriz($tipoMatriz);
		$cadastro->setQtdPaginas($qtdPaginas);
		$cadastro->setTipoArquivo($tipoArquivo);
		$cadastro->setIdComplementar($complementar);

		$salvarMatriz = $cadastro->salvar();
		//file_put_contents(__DIR__ . '/debug.log', print_r($salvarMatriz, true));

		header('Content-Type: application/json');

		if ($salvarMatriz['success']) {
			$mensagem = [
				'success' => true,
				'message' => $salvarMatriz['message']
			];
			return new Response(200, [
				'Content-Type' => 'application/json'
				], body: json_encode($mensagem));
		} else {
			$mensagem = [
				'success' => false,
				'message' => $salvarMatriz['message']
			];
			return new Response(500, [
				'Content-Type' => 'application/json'
				], body: json_encode($mensagem));
		}
		exit;
    }
}