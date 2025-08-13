<?php

namespace Correios\ContadorDePaginas\Contador;

class CriarEExcluirArquivoTXT
{
    private $destinoDoArquivo;

    public function __construct (string $destinoDoArquivo) 
    {
        $this->destinoDoArquivo = $destinoDoArquivo;
    }

    public function getDestinoDoArquivo (): string
    {
        return $this->destinoDoArquivo;
    }

    //Método para criar arquivo Multiplex
	public function criarArquivoMultiplex (string $destinoDoArquivo): void
    {
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Multiplex_{$dataAtual}.txt";
		$salvarArquivo = $destinoDoArquivo . $nomeArquivo;
		$escrita = @fopen("$salvarArquivo","a");
		$cabecalho = "Nome Arquivo"."\t"."Qtde Objetos"."\t"."Qtde Páginas"."\r\n";
		$escrever = fwrite($escrita,$cabecalho);
		fclose($escrita);
	}

    //Método para criar arquivo Inserção
	public function criarArquivoInsercao (string $destinoDoArquivo): void
    {
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Insercao_{$dataAtual}.txt";
		$salvarArquivo = $destinoDoArquivo . $nomeArquivo;
		$escrita = @fopen("$salvarArquivo","a");
		$cabecalho = "Nome Arquivo"."\t"."Qtde Objetos"."\t"."Qtde Páginas"."\r\n";
		$escrever = fwrite($escrita,$cabecalho);
		fclose($escrita);
	}

     //Método para excluir arquivo TXT	
	public function excluirArquivoMultiplex (string $destinoDoArquivo): void
    {
        $dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Multiplex_{$dataAtual}.txt";
		$excluirArquivo = $destinoDoArquivo . $nomeArquivo;
		if (file_exists($excluirArquivo)) {
			unlink($excluirArquivo);
		}
	}

    //Método para excluir arquivo TXT	
	public function excluirArquivoInsercao (string $destinoDoArquivo): void
    {
        $dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Insercao_{$dataAtual}.txt";
		$excluirArquivo = $destinoDoArquivo . $nomeArquivo;
		if (file_exists($excluirArquivo)) {
			unlink($excluirArquivo);
		}
	}


    //Método para criar arquivo LOG Multiplex
	public function criarLogMultiplex (string $destinoDoArquivo): void
    {
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Log_Multiplex_{$dataAtual}.txt";
		$salvarArquivo = $destinoDoArquivo . $nomeArquivo;
		$escrita = @fopen("$salvarArquivo","a");
		fclose($escrita);
	}

    //Método para criar arquivo LOG Inserção
	public function criarLogInsercao (string $destinoDoArquivo): void
    {
		$dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Log_Insercao_{$dataAtual}.txt";
		$salvarArquivo = $destinoDoArquivo . $nomeArquivo;
		$escrita = @fopen("$salvarArquivo","a");
		fclose($escrita);
	}

     //Método para excluir arquivo LOG Multiplex TXT	
	public function excluirLogMultiplex (string $destinoDoArquivo): void
    {
        $dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Log_Multiplex_{$dataAtual}.txt";
		$excluirArquivo = $destinoDoArquivo . $nomeArquivo;
		if (file_exists($excluirArquivo)) {
			unlink($excluirArquivo);
		}		
	}

    //Método para excluir arquivo LOG Inserção TXT	
	public function excluirLogInsercao (string $destinoDoArquivo): void
    {
        $dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Log_Insercao_{$dataAtual}.txt";
		$excluirArquivo = $destinoDoArquivo . $nomeArquivo;
		if (file_exists($excluirArquivo)) {
			unlink($excluirArquivo);
		}		
	}

	//Método para excluir arquivo Excel Multiplex
	public function excluirExcelMultiplex (string $destinoDoArquivo): void
    {
        $dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Multiplex_{$dataAtual}.xlsx";
		$excluirArquivo = $destinoDoArquivo . $nomeArquivo;
		if (file_exists($excluirArquivo)) {
			unlink($excluirArquivo);
		}		
	}

	//Método para excluir arquivo Excel Inserção
	public function excluirExcelInsercao (string $destinoDoArquivo): void
    {
        $dataAtual = date('d_m_Y'); 
		$nomeArquivo = "Arquivos_Insercao_{$dataAtual}.xlsx";
		$excluirArquivo = $destinoDoArquivo . $nomeArquivo;
		if (file_exists($excluirArquivo)) {
			unlink($excluirArquivo);
		}		
	}
}