<?php

namespace Correios\ContadorDePaginas\Contador;
use PDO;

class ProcessadorDaArquivosMultiplex
{
    private ContarPaginasMultiplex $contarPaginasMultiplex;
    private CriarEExcluirArquivoTXT $criarEExcluirArquivoTXT;
    private CriarArquivoExcel $criarArquivoExcel;
    private PDO $conexaoDB;

    public function __construct
    (
        ContarPaginasMultiplex $contarPaginasMultiplex,
        CriarEExcluirArquivoTXT $criarEExcluirArquivoTXT,
        CriarArquivoExcel $criarArquivoExcel,
        PDO $conexaoDB
    )
    {
        $this->contarPaginasMultiplex = $contarPaginasMultiplex;
        $this->criarEExcluirArquivoTXT = $criarEExcluirArquivoTXT;
        $this->criarArquivoExcel = $criarArquivoExcel;
        $this->conexaoDB = $conexaoDB;
    }

    public function processarArquivos(): array
    {
        $this->excluirArquivoTXT();
        $this->excluirArquivoExcel();
        $this->excluirLogMultiplex();
        $this->criarArquivosTXT();
        $this->criarLogMultiplex();

        $arquivos = scandir($this->contarPaginasMultiplex->getCaminhoArquivo());

        // Remove "." e ".." do array de arquivos
        $arquivos = array_diff($arquivos, array('.', '..'));

        if (empty($arquivos)) {
            return [
                'status' => 'sucesso',
                'mensagem' => 'A pasta está vazia.'
            ];
        }

        
        foreach ($arquivos as $arquivo) {
            $caminhoENomeDoArquivo = $this->contarPaginasMultiplex->getCaminhoArquivo() . $arquivo;
            $this->contarPaginasMultiplex->setCaminhoENomeDoArquivo($caminhoENomeDoArquivo);
            
            /*
            echo "Processando o arquivo: " . $arquivo . "<br>";
            if ($this->contarPaginasMultiplex->verificarEExtrairArquivo()) {                              
                echo "Arquivo " . $arquivo . " encontrado e processado!" . "<br>";
            } else {
                echo "Não foi possível processar o arquivo " . $arquivo . "." . "<br>";
            }
            */

            $this->contarPaginasMultiplex->verificarEExtrairArquivo();
            $this->contarPaginasMultiplex->VerificarMatrizTXT($this->contarPaginasMultiplex->getCaminhoTemporario() . $arquivo);
            $this->contarPaginasMultiplex->VerificarMatrizXML($this->contarPaginasMultiplex->getCaminhoTemporario() . $arquivo, $arquivo);

            //echo "<br>Processamento do arquivo " . $arquivo . " concluído.<br><br>";
        }
        $arquivosExcel = scandir($this->contarPaginasMultiplex->getDestinoArquivo());
        $arquivosExcel = array_diff($arquivosExcel, array('.', '..'));
        foreach ($arquivosExcel as $arquivoExcel) {
            $caminhoArquivoExcel = $this->contarPaginasMultiplex->getDestinoArquivo() . $arquivoExcel;
            $this->criarArquivoExcel->criarExcelDeTXT($caminhoArquivoExcel);
            break; // Apenas processa o primeiro arquivo Excel encontrado
        }
         return [
                'status' => 'sucesso',
                'mensagem' => 'Arquivos processados com sucesso.'
            ];
    }
    
    public function excluirArquivoTXT(): void
    {
        $this->criarEExcluirArquivoTXT->excluirArquivoMultiplex($this->contarPaginasMultiplex->getDestinoArquivo());
    }

    public function excluirLogMultiplex(): void
    {
        $this->criarEExcluirArquivoTXT->excluirLogMultiplex($this->contarPaginasMultiplex->getDestinoArquivo());
    }

    public function excluirArquivoExcel(): void
    {
        $this->criarEExcluirArquivoTXT->excluirExcelMultiplex($this->contarPaginasMultiplex->getDestinoArquivo());
    }

    public function criarLogMultiplex(): void
    {
        $this->criarEExcluirArquivoTXT->criarLogMultiplex($this->contarPaginasMultiplex->getDestinoArquivo());
    }

    public function criarArquivosTXT(): void
    {
        $this->criarEExcluirArquivoTXT->criarArquivoMultiplex($this->contarPaginasMultiplex->getDestinoArquivo());
    }
}