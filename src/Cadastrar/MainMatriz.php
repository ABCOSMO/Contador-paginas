<?php

namespace Correios\ContadorDePaginas\Cadastrar;
use PDO;

abstract class MainMatriz
{
	protected $matriz;
	protected $tipoServico;
	protected $tipoMatriz;
	protected $tipoArquivo;
	protected $qtdPaginas;
	protected $idComplementar;
	protected $conexaoDB;

	public function __construct
	(
		PDO $conexaoDB,
		int $matriz
	)
	{
		$this->conexaoDB = $conexaoDB;
		$this->matriz = $matriz;
	}

	//Métodos Getters
	public function getMatriz(): int
	{
		return $this->matriz;
	}

	public function getTipoServico(): int
	{
		return $this->tipoServico;
	}

	public function getTipoMatriz(): int
	{
		return $this->tipoMatriz;
	}

	public function getTipoArquivo(): int
	{
		return $this->tipoArquivo;
	}

	public function getQtdPaginas(): int
	{
		return $this->qtdPaginas;
	}

	public function getIdComplementar(): int
	{
		return $this->idComplementar;
	}


	//Métodos Setters
	public function setMatriz(int $matriz): void
	{
		$this->matriz = $matriz;
	}

	public function setTipoServico(int $tipoServico): void
	{
		$this->tipoServico = $tipoServico;
	}

	public function setTipoMatriz(int $tipoMatriz): void
	{
		$this->tipoMatriz = $tipoMatriz;
	}

	public function setTipoArquivo(int $tipoArquivo): void
	{
		$this->tipoArquivo = $tipoArquivo;
	}

	public function setQtdPaginas(int $qtdPaginas): void
	{
		$this->qtdPaginas = $qtdPaginas;
	}

	public function setIdComplementar(int $idComplementar): void
	{
		$this->idComplementar = $idComplementar;
	}
    
}
