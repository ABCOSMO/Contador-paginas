<?php

namespace Correios\ContadorDePaginas\Contador;
use ZipArchive;

trait ManipuladorDeArquivosTrait
{
	//Método para ler arquivo
	public function receberNumeroDaMatriz (string $caminhoDoArquivo): int
	{
		$matriz = explode('_', $caminhoDoArquivo);
		if (isset($matriz)){
			return (int) $matriz[1];
		}

		return 0;
	}

	public function receberNumeroDaOS (string $caminhoDoArquivo): int
	{
		$numeroOS = explode('_', $caminhoDoArquivo);
		if (isset($numeroOS[2])){
			return (int) $numeroOS[2];
		}

		return 0;
	}

	public function matrizSemCadastro (string $matrizSemCadastro): void
	{
		$this->retornarMatrizSemCadastroTXT = $matrizSemCadastro;
	}

	public function retornarMatrizSemCadastroTXT (): string
	{
		return $this->retornarMatrizSemCadastroTXT;
	}

    //Método para excluir arquivo TXT	
	public function excluirArquivo (string $caminhoENomeDoArquivo): void
    {
		unlink($caminhoENomeDoArquivo);
		//echo "Arquivo excluído com sucesso" . "<br>";
	}

	public function excluirTodosArquivos (string $caminhoDoArquivo): void
	{
		$arquivos = scandir($caminhoDoArquivo);
		$arquivos = array_diff($arquivos, array('.', '..'));
		foreach ($arquivos as $arquivo) {
			$caminhoENomeDoArquivo = $caminhoDoArquivo . $arquivo;
			unlink($caminhoENomeDoArquivo);			
		}
		echo "Arquivo excluído com sucesso" . "<br><br>";
	}
	
	//Método para escrever no arquivo Multiplex
	public function escreverArquivoMultiplexTXT (string $arquivoNaPastaTmp, string $destinoDoArquivo, int $qtdObjetos, int $qtdPaginasPDF, int $idServico): void
	{
		$info = pathinfo($arquivoNaPastaTmp);
        $nomeArquivoSemExtensao = $info['filename'];
        $novaExtensao = 'txt';
        $novoNomeArquivo = $nomeArquivoSemExtensao . "." . $novaExtensao;
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Multiplex_{$dataAtual}.txt";
		$escreverArquivo = $destinoDoArquivo . $nomeArquivo;

		$idServico == 1 ? $totalDePaginas = $qtdObjetos + $qtdPaginasPDF : $totalDePaginas = ($qtdObjetos * 2) + $qtdPaginasPDF;
		
		$escrita = @fopen("$escreverArquivo","a");
		$corpo = $novoNomeArquivo . "\t" . $qtdObjetos . "\t" . $totalDePaginas . "\r\n";
		$escrever = fwrite($escrita,$corpo);
		fclose($escrita);
	}

	//Método para escrever no arquivo Multiplex
	public function escreverArquivoMultiplexXML (string $arquivoNaPastaTmp, string $destinoDoArquivo, int $qtdObjetos, int $qtdPaginasPDF, int $idServico): void
	{
		$info = pathinfo($arquivoNaPastaTmp);
        $nomeArquivoSemExtensao = $info['filename'];
        $novaExtensao = 'xml';
        $novoNomeArquivo = $nomeArquivoSemExtensao . "." . $novaExtensao;
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Multiplex_{$dataAtual}.txt";
		$escreverArquivo = $destinoDoArquivo . $nomeArquivo;

		$idServico == 1 ? $totalDePaginas = $qtdObjetos + $qtdPaginasPDF : $totalDePaginas = ($qtdObjetos * 2) + $qtdPaginasPDF;
		
		$escrita = @fopen("$escreverArquivo","a");
		$corpo = $novoNomeArquivo . "\t" . $qtdObjetos . "\t" . $totalDePaginas . "\r\n";
		$escrever = fwrite($escrita,$corpo);
		fclose($escrita);
	}

	//Método para escrever no LOG Multiplex
	public function escreverLogMultiplex (string $destinoDoArquivo, string $arquivo): void
	{
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Log_Multiplex_{$dataAtual}.txt";
		$escreverArquivo = $destinoDoArquivo . $nomeArquivo;
				
		$escrita = @fopen("$escreverArquivo","a");
		$corpo = "Arquivo: {$arquivo} não é multiplex ou sem cadastrado no sistema" . "\r\n";
		$escrever = fwrite($escrita,$corpo);
		fclose($escrita);
	}

	//Método para escrever no LOG Inserção
	public function escreverLogInsercao (string $destinoDoArquivo, string $arquivo): void
	{
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Log_Insercao_{$dataAtual}.txt";
		$escreverArquivo = $destinoDoArquivo . $nomeArquivo;
				
		$escrita = @fopen("$escreverArquivo","a");
		$corpo = "Arquivo: {$arquivo} não é inserção ou sem cadastrado no sistema" . "\r\n";
		$escrever = fwrite($escrita,$corpo);
		fclose($escrita);
	}
}