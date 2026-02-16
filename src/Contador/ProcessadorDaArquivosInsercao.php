<?php

namespace Correios\ContadorDePaginas\Contador;
use PDO;

class ProcessadorDaArquivosInsercao
{
    private ContarPaginasInsercao $contarPaginasInsercao;
    private CriarEExcluirArquivoTXT $criarEExcluirArquivoTXT;
    private CriarArquivoExcel $criarArquivoExcel;
    private PDO $conexaoDB;

    public function __construct
    (
        ContarPaginasInsercao $contarPaginasInsercao,
        CriarEExcluirArquivoTXT $criarEExcluirArquivoTXT,
        CriarArquivoExcel $criarArquivoExcel,
        PDO $conexaoDB
    )
    {
        $this->contarPaginasInsercao= $contarPaginasInsercao;
        $this->criarEExcluirArquivoTXT = $criarEExcluirArquivoTXT;
        $this->criarArquivoExcel = $criarArquivoExcel;
        $this->conexaoDB = $conexaoDB;
    }

    public function processarArquivos(): array
    {
        $arquivos = scandir($this->contarPaginasInsercao->getCaminhoArquivo());

        // Remove "." e ".." do array de arquivos
        $arquivos = array_diff($arquivos, array('.', '..'));

        if (empty($arquivos)) {
            return [
                'status' => 'sucesso',
                'mensagem' => 'A pasta está vazia.'
            ];
        }

        $this->excluirArquivoTXT();
        $this->excluirArquivoExcel();
        $this->excluirLogInsercao();
        $this->criarArquivosTXT();
        $this->criarLogInsercao();

        foreach ($arquivos as $arquivo) {
            $caminhoENomeDoArquivo = $this->contarPaginasInsercao->getCaminhoArquivo() . $arquivo;
            $this->contarPaginasInsercao->setCaminhoENomeDoArquivo($caminhoENomeDoArquivo);
            
            /*
            echo "Processando o arquivo: " . $arquivo . "<br>";
            if ($this->contarPaginasInsercao->verificarEExtrairArquivo()) {                              
                echo "Arquivo " . $arquivo . " encontrado e processado!" . "<br>";
            } else {
                echo "Não foi possível processar o arquivo " . $arquivo . "." . "<br>";
            }
            */

            $this->contarPaginasInsercao->verificarEExtrairArquivo();
            $this->contarPaginasInsercao->VerificarMatrizTXT($this->contarPaginasInsercao->getCaminhoTemporario() . $arquivo);
            $this->contarPaginasInsercao->VerificarMatrizXML($this->contarPaginasInsercao->getCaminhoTemporario() . $arquivo, $arquivo);

            //echo "<br>Processamento do arquivo " . $arquivo . " concluído.<br><br>";
        }
        $arquivosExcel = scandir($this->contarPaginasInsercao->getDestinoArquivo());
        $arquivosExcel = array_diff($arquivosExcel, array('.', '..'));
        foreach ($arquivosExcel as $arquivoExcel) {
            $caminhoArquivoExcel = $this->contarPaginasInsercao->getDestinoArquivo() . $arquivoExcel;
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
        $this->criarEExcluirArquivoTXT->excluirArquivoInsercao($this->contarPaginasInsercao->getDestinoArquivo());
    }

    public function excluirLogInsercao(): void
    {
        $this->criarEExcluirArquivoTXT->excluirLogInsercao($this->contarPaginasInsercao->getDestinoArquivo());
    }

    public function excluirArquivoExcel(): void
    {
        $this->criarEExcluirArquivoTXT->excluirExcelInsercao($this->contarPaginasInsercao->getDestinoArquivo());
    }

    public function criarLogInsercao(): void
    {
        $this->criarEExcluirArquivoTXT->criarLogInsercao($this->contarPaginasInsercao->getDestinoArquivo());
    }

    public function criarArquivosTXT(): void
    {
        $this->criarEExcluirArquivoTXT->criarArquivoInsercao($this->contarPaginasInsercao->getDestinoArquivo());
    }
}