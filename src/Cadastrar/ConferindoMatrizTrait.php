<?php

namespace Correios\ContadorDePaginas\Cadastrar;
use PDOException;

trait ConferindoMatrizTrait
{
	public function verificaSeExisteMatriz (int $matriz): bool
	{

		$sql = "SELECT * FROM matrizes WHERE matriz = :matriz";
		
		try {
				$stmt = $this->conexaoDB->prepare($sql);

        		$dados = array(
            	":matriz" => $matriz
        		);
        		$stmt->execute($dados);

        		if ($stmt->fetch()) {
        			error_log("Matriz já cadastrada: " . $matriz, 0);
            		return true;
        		}

        		return false;

        } catch (PDOException $e) {
           	error_log("Erro ao conferir matriz: " . $e->getMessage(), 0);
           	return false;
        }
	}
}