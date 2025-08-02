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
        			$this->responderJSON(false, 'Matriz já cadastrada.');
            		return true;
        		}

        		return false;

        } catch (PDOException $e) {
           	error_log("Erro ao conferir matriz: " . $e->getMessage(), 0);
			responderJSON(false, 'Erro ao conferir matriz no banco de dados.', $e->getMessage());
           	return false;
        }
	}

	public function responderJSON($success, $message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
    }
}