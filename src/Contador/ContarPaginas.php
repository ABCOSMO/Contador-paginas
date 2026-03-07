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


   public function __construct(
        PDO $conexaoDB,
        string $caminhoArquivo = '', 
        string $destinoArquivo = '', 
        string $caminhoTemporario = ''
    ) {
        $this->conexaoDB = $conexaoDB;
        $this->caminhoArquivo = $caminhoArquivo;
        $this->destinoArquivo = $destinoArquivo;
        $this->caminhoTemporario = $caminhoTemporario;
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

    public function setCaminhoArquivo(string $caminho): void
    {
        $this->caminhoArquivo = $caminho;
    }

    public function setDestinoArquivo(string $destino): void
    {
        $this->destinoArquivo = $destino;
    }

    public function setCaminhoTemporario(string $temp): void
    {
        $this->caminhoTemporario = $temp;
    }

    /**
     * Atalho para configurar tudo de uma vez no Controller
     */
    public function configurarCaminhos(string $origem, string $destino, string $temp): void
    {
        $this->caminhoArquivo = $origem;
        $this->destinoArquivo = $destino;
        $this->caminhoTemporario = $temp;
    }

    public function setCaminhoENomeDoArquivo (string $caminhoENomeDoArquivo): void
    {
        $this->caminhoENomeDoArquivo = $caminhoENomeDoArquivo;
    }

    public function verificarEExtrairArquivo(): bool
    { 
        
        $this->extractZipFile($this->caminhoENomeDoArquivo, $this->getCaminhoTemporario());

        $this->excluirArquivo($this->caminhoENomeDoArquivo);
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
