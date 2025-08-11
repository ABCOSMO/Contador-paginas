<?php

namespace Correios\ContadorDePaginas\Contador;
use ZipArchive;

trait ManipuladorDeDiretoriosTrait
{
    //Método extactZipFile para descompactar o arquivo zip
	public function extractZipFile(string $origem, string $destino): void
    { 
		$zipFile = new ZipArchive;
		$openFile = $zipFile->open($origem);
		if ($openFile === TRUE) {
			$zipFile->extractTo($destino);
			$zipFile->close();
			//echo "Arquivos descompactado com sucesso." . "<br>";
			} else {
			//echo "Descompactação do arquivo falhou." . "<br>";
		}
	}
	
	//Método para verificar se a pasta está vazia
	public function pastaVazia(): bool
	{
		if (!is_dir($this->getCaminhoArquivo())) {
			return false; // Retorna false se o caminho não for um diretório válido
		}

		$itens = scandir($this->getCaminhoArquivo());

		// Se o array de itens tiver apenas as entradas '.' e '..', a pasta está vazia
		if (count($itens) <= 2) {
			return true;
		}

		return false;
	}  
	
	public function normalizarCaminho(string $caminho): string
    {
        // Substitui todas as barras invertidas por barras normais
        $caminhoNormalizado = str_replace('\\', '/', $caminho);
        
        // Remove barras duplas se houver
        $caminhoNormalizado = str_replace('//', '/', $caminhoNormalizado);

        return $caminhoNormalizado;
    }
    
}