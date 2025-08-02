<?php

namespace Correios\ContadorDePaginas\Cadastrar;
use PDO;

abstract class MainMatriz
{
	protected $matriz;
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

	public function setTipoMatriz(string $tipoMatriz): void
	{
		$this->tipoMatriz = $tipoMatriz;
	}

	public function setTipoArquivo(string $tipoArquivo): void
	{
		$this->tipoArquivo = $tipoArquivo;
	}

	public function setQtdPaginas(string $qtdPaginas): void
	{
		$this->qtdPaginas = $qtdPaginas;
	}

	public function setIdComplementar(int $idComplementar): void
	{
		$this->idComplementar = $idComplementar;
	}
    
}