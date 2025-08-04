<?php

namespace Correios\ContadorDePaginas\Contador;

trait ManipularArquivosTrait
{
    //Método para excluir arquivo TXT	
	public function excluirTXT(string $caminhoDoArquivo, string $nomeArquivo): void
    {
		unlink($nomeArquivo);
	}

	//Método para criar arquivo TXT
	public function criarTXT(string $procurar, string $caminho): void
    {
		$escrita = @fopen("$caminho","a");
		$cabecalho = "Nome Arquivo"."\t"."Qtde Objetos"."\t"."Qtde Páginas"."\r\n";
		$escrever = fwrite($escrita,$cabecalho);
		fclose($escrita);
	}
	
	//Método extactZipFile para descompactar o arquivo zip
	public function extractZipFile(string $origem, string $destino): void
    { 
		$zipFile = new ZipArchive;
		$openFile = $zipFile->open($origem);
		if ($openFile === TRUE) {
			$zipFile->extractTo($destino);
			$zipFile->close();
			//echo "Arquivos extraídos com sucesso.";
			} else {
			echo "Extração dos arquivos falhou.";
		}
	}
	
	//Método para verificar se a pasta está vazia
	public function pastaVazia($caminho): bool
	{
		if (!is_dir($caminho)) {
			return false; // Retorna false se o caminho não for um diretório válido
		}

		$itens = scandir($caminho);

		// Se o array de itens tiver apenas as entradas '.' e '..', a pasta está vazia
		if (count($itens) <= 2) {
			return true;
		}

		return false;
	}
   
}