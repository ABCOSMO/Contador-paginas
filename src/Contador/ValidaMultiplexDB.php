<?php

namespace Correios\ContadorDePaginas\Contador;
use PDO;
use PDOException;

class ValidaMultiplexDB
{
    private $conexaoDB;

    public function __construct (PDO $conexaoDB) 
    {
        $this->conexaoDB = $conexaoDB;
    }

    //Método para verificar se existe Matriz Multiplex
	public function verificaSeExisteMatrizMultiplexTXT ($matriz): array
	{
		$idTipoMatriz = 1;
		$IdTipoArquivo = 1;
		$sql = "SELECT * FROM matrizes 
				WHERE 
					matriz = :matriz 
				AND 
					id_tipo_matriz = :id_tipo_matriz 
				AND 
					id_tipo_arquivo = :id_tipo_arquivo";
		
		
		try {
				$stmt = $this->conexaoDB->prepare($sql);

        		$dados = array(
            	":matriz" => $matriz,
				":id_tipo_matriz" => $idTipoMatriz,
				":id_tipo_arquivo" => $IdTipoArquivo
        		);
				
				$stmt->execute($dados);

				$resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

				if ($resultado) {
					error_log("Matriz já cadastrada: " . $matriz, 0);

					$response = [];
					foreach ($resultado as $value) {
						$response[] = [							
							'idComplementar' => $value->id_complementar,
                    		'idQtdPaginas' => $value->id_qtd_paginas
						];
					}
					return $response;
				}

				return [];				

        } catch (PDOException $e) {
           	error_log("Erro ao conferir matriz: " . $e->getMessage(), 0);
			return [];
        }
	}

	//Método para verificar se existe Matriz Multiplex
	public function verificaSeExisteMatrizMultiplexXML (int $matriz): array
	{
		$idTipoMatriz = 1;
		$IdTipoArquivo = 2;
		$sql = "SELECT * FROM matrizes 
			WHERE 
				matriz = :matriz 
			AND 
				id_tipo_matriz = :id_tipo_matriz 
			AND 
				id_tipo_arquivo = :id_tipo_arquivo";
		
		try {
				$stmt = $this->conexaoDB->prepare($sql);

        		$dados = array(
            	":matriz" => $matriz,
				":id_tipo_matriz" => $idTipoMatriz,
				":id_tipo_arquivo" => $IdTipoArquivo
        		);
        		$stmt->execute($dados);
				
				$resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

				if ($resultado) {
					error_log("Matriz já cadastrada: " . $matriz, 0);
					
					$response = [];
					foreach ($resultado as $value) {
						$response [] = [
							'idComplementar' => $value->id_complementar,
                    		'idQtdPaginas' => $value->id_qtd_paginas
						];
					}
					return $response;
				}

				return [];
        		
        } catch (PDOException $e) {
           	error_log("Erro ao conferir matriz: " . $e->getMessage(), 0);
           	return [];
        }
	}

	//Método para responder via JSON
	public function responderJSON($success, $message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
    }
}