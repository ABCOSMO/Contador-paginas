<?php

namespace Correios\ContadorDePaginas\Cadastrar;
use Correios\ContadorDePaginas\Cadastrar\MainMatriz;
use Correios\ContadorDePaginas\Cadastrar\ConferindoMatrizTrait;
use Correios\ContadorDePaginas\Cadastrar\MatrizRepositoryInterface;
use PDOException;
/**
 * 
 */
class MatrizRepository extends MainMatriz implements MatrizRepositoryInterface
{	
	use ConferindoMatrizTrait;

	public function salvar(): bool
    {
    	if ($this->verificaSeExisteMatriz($this->matriz)) {
            return false; // Se a matriz já existe, o método da trait retorna false e paramos aqui.
        }

        $sql = "INSERT INTO matrizes (matriz, id_tipo_matriz, id_tipo_arquivo, id_qtd_paginas, id_complementar) 
                VALUES (:matriz, :idTipoMatriz, :idTipoArquivo, :idQtdPaginas, :idComplementar)";
        
        try {
            
            $stmt = $this->conexaoDB->prepare($sql);
            $array = [
                ':matriz' => $this->matriz,
                ':idTipoMatriz' => $this->tipoMatriz,
                ':idTipoArquivo' => $this->tipoArquivo,
                ':idQtdPaginas' => $this->qtdPaginas,
                ':idComplementar' => $this->idComplementar
            ];

            $stmt->execute($array);
            $this->responderJSON(true, 'Matriz cadastrada com sucesso.');
            return true;

        } catch (PDOException $e) {
            // Em ambiente de produção, você deve logar este erro e não exibi-lo diretamente
            error_log("Erro ao salvar matriz: " . $e->getMessage(), 0);
            responderJSON(false, 'Erro ao conferir matriz no banco de dados.', $e->getMessage());
            return false;
        }
    }

    public function alterar(): bool
    {
        // Implementar lógica de alteração de matriz
        return true;
    }

    public function excluir(): bool
    {
        // Implementar lógica de exclusão de matriz
        return true;
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM matrizes WHERE id = :id";
        
        try {
            $stmt = $this->conexaoDB->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar matriz por ID: " . $e->getMessage(), 0);
            return null;
        }
    }
}