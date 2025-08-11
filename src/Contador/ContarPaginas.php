<?php

namespace Correios\ContadorDePaginas\Contador;
use Correios\ContadorDePaginas\Contador\ManipuladorDeDiretoriosTrait;
use Smalot\PdfParser\Parser;
use PDO;
use PDOException;

abstract class ContarPaginas
{
    use ManipuladorDeDiretoriosTrait;

    protected $caminhoArquivo;
    protected $destinoArquivo;
    protected $caminhoTemporario;
    protected $caminhoENomeDoArquivo;
    protected $conexaoDB;


    public function __construct
    (
        string $caminhoArquivo, 
        string $destinoArquivo, 
        string $caminhoTemporario,
        PDO $conexaoDB
    )
    {
        $this->caminhoArquivo = $caminhoArquivo;
        $this->destinoArquivo = $destinoArquivo;
        $this->caminhoTemporario = $caminhoTemporario;
        $this->conexaoDB = $conexaoDB;
    }

    public function getCaminhoArquivo (): string
    {
        return $this->caminhoArquivo;
    }

    public function getDestinoArquivo (): string
    {
        return $this->destinoArquivo;
    }

    public function getCaminhoTemporario (): string
    {
        return $this->caminhoTemporario;
    }

    public function setCaminhoENomeDoArquivo (string $caminhoENomeDoArquivo): void
    {
        $this->CaminhoENomeDoArquivo = $caminhoENomeDoArquivo;
    }

    public function verificarEExtrairArquivo(): bool
    { 
        
        $this->extractZipFile($this->CaminhoENomeDoArquivo, $this->getCaminhoTemporario());

        $this->excluirArquivo($this->CaminhoENomeDoArquivo);
        return true;
    }

    public function contarObjetosPDF(string $caminhoTemporario, int $idComplementar, int $idQtdPaginas, int $numeroLote): int
    {
        if ($idComplementar < 3) {
            $arquivos = array_diff(scandir($caminhoTemporario), ['.', '..']);
            $totalPaginas = 0;
            $mensagens = [];

            foreach ($arquivos as $arquivo) {
                $caminhoCompleto = $caminhoTemporario . DIRECTORY_SEPARATOR . $arquivo;

                $extrairLote = explode('_', $arquivo);
                $novoNumeroLote = $extrairLote[2];

                if (is_numeric($novoNumeroLote) && (int)$novoNumeroLote === $numeroLote) {

                    // Verifica se é um arquivo PDF
                    if (strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)) === 'pdf') {
                        if (!file_exists($caminhoCompleto)) {
                            $mensagens[] = "Arquivo não encontrado: $caminhoCompleto";
                            continue;
                        }

                        try {
                            $parser = new Parser();
                            $pdf = $parser->parseFile($caminhoCompleto);
                            $numPaginas = count($pdf->getPages());
                            $totalPaginas += $numPaginas;
                            //$mensagens[] = "$arquivo tem $numPaginas páginas.";
                        } catch (\Exception $e) {
                            $mensagens[] = "Erro ao processar $arquivo: " . $e->getMessage();
                        }
                    }

                }
            }

            $mensagens[] = $totalPaginas;
            return $totalPaginas;
        }

        if ($idComplementar == 3) {
            return $idQtdPaginas;
        }

        return "ID complementar inválido.";
    }
}
