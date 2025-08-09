<?php

namespace Correios\ContadorDePaginas\Contador;
use Correios\ContadorDePaginas\Contador\ContarPaginas;
use Correios\ContadorDePaginas\Contador\ManipuladorDeArquivosTrait;
use Correios\ContadorDePaginas\Contador\ManipuladorDeDiretoriosTrait;
use Correios\ContadorDePaginas\Contador\ValidaMultiplexEInsercaoDB;
use Correios\ContadorDePaginas\Contador\ContarObjetosTXT;
use Correios\ContadorDePaginas\Contador\ContarObjetosXML;
use Smalot\PdfParser\Parser;
use PDO;

class ContarPaginasMultiplex extends ContarPaginas
{
    private ValidaMultiplexEInsercaoDB $mutiplexNoBD;
    private ContarObjetosTXT $contarTXT;
    private ContarObjetosXML $contarXML;    
    use ManipuladorDeArquivosTrait;

    public function __construct 
    (
        string $caminhoArquivo, 
        string $destinoArquivo, 
        string $caminhoTemporario,
        PDO $conexaoDB,
        ValidaMultiplexEInsercaoDB $mutiplexNoBD,
        ContarObjetosTXT $contarTXT,
        ContarObjetosXML $contarXML,
    )
    {
        parent::__construct($caminhoArquivo, $destinoArquivo, $caminhoTemporario, $conexaoDB);
        $this->mutiplexNoBD = $mutiplexNoBD;
        $this->contarTXT = $contarTXT;
        $this->contarXML = $contarXML;
    }

    public function VerificarMatrizTXT (string $arquivoNaPastaTmp): void
    {        
        $matriz = $this->receberNumeroDaMatriz($arquivoNaPastaTmp); 
        $numeroOS = $this->receberNumeroDaOS($arquivoNaPastaTmp); 
        $elementosDaMatriz = $this->mutiplexNoBD->verificaSeExisteMatrizMultiplexTXT($matriz);
        if(!empty($elementosDaMatriz)) { 
            foreach ($elementosDaMatriz as $elemento) {           
                $idComplementar = $elemento['idComplementar'];
                $idQtdPaginas = $elemento['idQtdPaginas'];
                $idServico = $elemento['idServico'];
            }

            $qtdObjetos = (int)$this->contarTXT->contarObjetosTXT($arquivoNaPastaTmp);
            $qtdPaginasPDF = (int)$this->contarObjetosPDF($this->caminhoTemporario, $idComplementar, $idQtdPaginas, $numeroOS);

            if ($idComplementar == 3) {
                $qtdPaginasPDF = ($qtdObjetos * $qtdPaginasPDF) / 2;
            }
           
            echo " O arquivo tem {$qtdObjetos} objeto" . "<br>";
            echo "Total de páginas em todos os PDFs: {$qtdPaginasPDF}" . "<br>";
            $idServico == 1 ? $totalDePaginas = $qtdObjetos + $qtdPaginasPDF : $totalDePaginas = ($qtdObjetos * 2) + $qtdPaginasPDF;
            echo "Total de páginas para imprimir são: {$totalDePaginas}" . "<br><br>";
            $this->escreverArquivoMultiplexTXT($arquivoNaPastaTmp, $this->getDestinoArquivo(), $qtdObjetos, $qtdPaginasPDF, $idServico);
            $matrizSemCadastro =  "S";
            $this->matrizSemCadastro($matrizSemCadastro);
        } else {
            $matrizSemCadastro =  "N";
            $this->matrizSemCadastro($matrizSemCadastro);
        }
    }

    public function VerificarMatrizXML (string $arquivoNaPastaTmp, string $arquivo): void
    {
        $matriz = $this->receberNumeroDaMatriz($arquivoNaPastaTmp); 
        $numeroOS = $this->receberNumeroDaOS($arquivoNaPastaTmp);
        $elementosDaMatriz = $this->mutiplexNoBD->verificaSeExisteMatrizMultiplexXML($matriz);
        if(!empty($elementosDaMatriz)) { 
            foreach ($elementosDaMatriz as $elemento) {           
                $idComplementar = $elemento['idComplementar'];
                $idQtdPaginas = $elemento['idQtdPaginas'];
                $idServico = $elemento['idServico'];
            }

            $qtdObjetos = (int)$this->contarXML->contarObjetosXML($arquivoNaPastaTmp);
            $qtdPaginasPDF = (int)$this->contarObjetosPDF($this->caminhoTemporario, $idComplementar, $idQtdPaginas, $numeroOS);

             if ($idComplementar == 3) {
                $qtdPaginasPDF = ($qtdObjetos * $qtdPaginasPDF) / 2;
            }
            
            echo " O arquivo tem {$qtdObjetos} objetos" . "<br>";
            echo "Total de páginas em todos os PDFs: {$qtdPaginasPDF}" . "<br>";
            $idServico == 1 ? $totalDePaginas = $qtdObjetos + $qtdPaginasPDF : $totalDePaginas = ($qtdObjetos * 2) + $qtdPaginasPDF;
            echo "Total de páginas para imprimir são: {$totalDePaginas}" . "<br><br>";
            $this->escreverArquivoMultiplexXML($arquivoNaPastaTmp, $this->getDestinoArquivo(), $qtdObjetos, $qtdPaginasPDF, $idServico);
            $matrizSemCadastroXML = "S";
        } else {
            echo "Matriz não tem arquivo XML" . "<br><br>";
            $matrizSemCadastroXML = "N";

            if ($matrizSemCadastroXML == "N" && $this->retornarMatrizSemCadastroTXT() == "N") {
                $this->escreverLogMultiplex($this->getDestinoArquivo(), $arquivo);
            }
        }  
    }


}
