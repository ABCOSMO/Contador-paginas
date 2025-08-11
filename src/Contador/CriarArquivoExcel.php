<?php

namespace Correios\ContadorDePaginas\Contador;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class CriarArquivoExcel
{
    private $destinoDoArquivo;

    public function __construct(string $destinoDoArquivo)
    {
        $this->destinoDoArquivo = $destinoDoArquivo;
    }

    public function getDestinoDoArquivo(): string
    {
        return $this->destinoDoArquivo;
    }
    
    /**
     * Cria um arquivo Excel a partir de um arquivo TXT.
     *
     * @param string $caminhoArquivo Caminho do arquivo TXT a ser lido.
     * @return void
     */
    public function criarExcelDeTXT(string $caminhoArquivo): void
    {
        if (!file_exists($caminhoArquivo)) {
            throw new \Exception("Arquivo não encontrado: " . $caminhoArquivo);
        }

        // Lê o conteúdo do arquivo TXT e cria o Excel
        $this->gerarExcel($caminhoArquivo);
    }

    private function gerarExcel(string $caminhoArquivo): void
    {
        // 1. Ler o arquivo TXT
        $info = pathinfo($caminhoArquivo);
        $arquivoExcel = $info['filename'] . ".xlsx";
        $caminho = dirname($caminhoArquivo) . DIRECTORY_SEPARATOR;         
        $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($linhas === false) {
           throw new \Exception('Erro ao ler o arquivo TXT.');
        }

        // 2. Criar uma nova planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

       // Adicionar os dados à planilha
        $row = 1;
        foreach ($linhas as $linha) {
            // Quebrar a linha em colunas, usando o tab (\t) como delimitador
            $dados = explode("\t", $linha);

            // Escrever os dados na planilha
            $coluna = 1;
            foreach ($dados as $celula) {
                // Converter o número da coluna (1, 2, 3...) para a letra ('A', 'B', 'C'...)
                $columnLetter = Coordinate::stringFromColumnIndex($coluna);
                
                // Montar a coordenada da célula (ex: 'A1', 'B1', 'A2')
                $coordinate = $columnLetter . $row;
                
                // Definir o valor da célula
                $sheet->setCellValue($coordinate, $celula);
                
                $coluna++;
            }
            $row++;
        }

        // 3. Salvar o arquivo Excel
        $escrever = new Xlsx($spreadsheet);
        $escrever->save($caminho . $arquivoExcel);

        //echo "Arquivo {$arquivoExcel} criado com sucesso!";        
    }
}