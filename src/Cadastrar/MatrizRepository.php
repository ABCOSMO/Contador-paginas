<?php

namespace Correios\ContadorDePaginas\Cadastrar;
use Correios\ContadorDePaginas\Cadastrar\MainMatriz;
use Correios\ContadorDePaginas\Cadastrar\ConferindoMatrizTrait;
use Correios\ContadorDePaginas\Cadastrar\MatrizRepositoryInterface;
use PDOException;
use PDO;
/**
 * 
 */
class MatrizRepository extends MainMatriz implements MatrizRepositoryInterface
{	
	use ConferindoMatrizTrait;

	public function salvar(): array
    {
    	if ($this->verificaSeExisteMatriz($this->matriz)) {
            return [
                'success' => false,
                'message' => 'A matriz já existe no banco de dados.'
            ];
        }

        $sql = "INSERT INTO matrizes (matriz, id_servico, id_tipo_matriz, id_tipo_arquivo, id_qtd_paginas, id_complementar) 
                VALUES (:matriz, :idTipoServico, :idTipoMatriz, :idTipoArquivo, :idQtdPaginas, :idComplementar)";
        
        try {
            
            $stmt = $this->conexaoDB->prepare($sql);
            $array = [
                ':matriz' => $this->matriz,
                ':idTipoServico' => $this->tipoServico,
                ':idTipoMatriz' => $this->tipoMatriz,
                ':idTipoArquivo' => $this->tipoArquivo,
                ':idQtdPaginas' => $this->qtdPaginas,
                ':idComplementar' => $this->idComplementar
            ];

            $stmt->execute($array);
            return [
                'success' => true, 
                'message' => 'Matriz cadastrada com sucesso.'
            ];

        } catch (PDOException $e) {
            // Em ambiente de produção, você deve logar este erro e não exibi-lo diretamente
            error_log("Erro ao salvar matriz: " . $e->getMessage(), 0);
            return [
                'success' => false, 
                'message' => 'Erro ao conferir matriz no banco de dados. ' . $e->getMessage()
            ];
        }
    }

    public function alterar(): bool
    {
        // Implementar lógica de alteração de matriz
        return true;
    }

    public function excluir(): array
    {
        $sql = "DELETE FROM matrizes WHERE matriz = :matriz";

        try {
            $stmt = $this->conexaoDB->prepare($sql);
            
             $array = [
                ':matriz' => $this->matriz
             ];
            $stmt->execute($array);
             return [
                'success' => true, 
                'message' => 'Matriz excluída com sucesso.'
            ];
             
        }
        catch (PDOException $e) {
            // Em ambiente de produção, você deve logar este erro e não exibi-lo diretamente
            error_log("Erro ao excluir matriz: " . $e->getMessage(), 0);
            return [
                'success' => false, 
                'message' => 'Erro ao excluir matriz no banco de dados. ' . $e->getMessage()
            ];
        }
    }

    public function buscarMatriz(): ?array
    {
        $sql = "SELECT 
            matrizes.*,
            tipo_servico.servico AS nome_servico,
            tipo_matriz.tipo_matriz AS nome_tipo_matriz,
            tipo_arquivo.tipo_arquivo AS nome_tipo_arquivo,
            qtd_paginas.qtd_paginas AS numero_paginas,
            arq_complementar.complementar AS arq_complementar
        FROM 
            matrizes 
        INNER JOIN
            tipo_servico ON tipo_servico.id_servico = matrizes.id_servico
        INNER JOIN
            tipo_matriz ON tipo_matriz.id_tipo_matriz = matrizes.id_tipo_matriz
        INNER JOIN 
            tipo_arquivo ON tipo_arquivo.id_tipo_arquivo = matrizes.id_tipo_arquivo
        INNER JOIN
            qtd_paginas ON qtd_paginas.id_qtd_paginas = matrizes.id_qtd_paginas
        INNER JOIN 
            arq_complementar ON arq_complementar.id_complementar = matrizes.id_complementar
        ORDER BY matrizes.matriz ASC";
        
        try {
            $stmt = $this->conexaoDB->prepare($sql);           
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = [];
                    foreach($resultados as $value) {
                        $response[] = [
							'matriz' => $value['matriz'],
                            'idMatriz' => $value['id_matriz'],
							'idTipoServico' => $value['nome_servico'],
							'idTipoMatriz' => $value['nome_tipo_matriz'],
							'idTipoArquivo' => $value['nome_tipo_arquivo'],
							'idQtdPaginas' => $value['numero_paginas'],
							'idComplementar' => $value['arq_complementar']
                        ];
                    }
            return $response;
        } catch (PDOException $e) {
            error_log("Erro ao buscar matriz: " . $e->getMessage(), 0);
            return [
                'success' => false,
                'message' => "Erro ao buscar matriz: " . $e->getMessage()
            ];
        }
    }
}