<?php

namespace Correios\ContadorDePaginas\Contador;
use Correios\ContadorDePaginas\Contador\ContarPaginas;
use Correios\ContadorDePaginas\Contador\ManipuladorDeArquivosTrait;
use Correios\ContadorDePaginas\Contador\ManipuladorDeDiretoriosTrait;
use Correios\ContadorDePaginas\Contador\ValidaMultiplexEInsercaoDB;
use Correios\ContadorDePaginas\Contador\VerificadorDeMatrizInterface;
use Correios\ContadorDePaginas\Contador\ContarObjetosTXT;
use Correios\ContadorDePaginas\Contador\ContarObjetosXML;
use Smalot\PdfParser\Parser;
use PDO;

class ContarPaginasInsercao extends ContarPaginas implements VerificadorDeMatrizInterface
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
        $numeroLote = $this->receberNumeroDoLote($arquivoNaPastaTmp); 
        $elementosDaMatriz = $this->mutiplexNoBD->verificaSeExisteMatrizInsercaoTXT($matriz);
        if(!empty($elementosDaMatriz)) { 
            foreach ($elementosDaMatriz as $elemento) {           
                $idComplementar = $elemento['idComplementar'];
                $idQtdPaginas = $elemento['idQtdPaginas'];
                $idServico = $elemento['idServico'];
            }

            $qtdObjetos = (int)$this->contarTXT->contarObjetosTXT($arquivoNaPastaTmp);
            $qtdPaginasPDF = (int)$this->contarObjetosPDF($this->caminhoTemporario, $idComplementar, $idQtdPaginas, $numeroLote);

            if ($idComplementar == 3) {
                $qtdPaginasPDF = ($qtdObjetos * $qtdPaginasPDF) / 2;
            }
           
            //echo " O arquivo tem {$qtdObjetos} objeto" . "<br>";
            //echo "Total de páginas em todos os PDFs: {$qtdPaginasPDF}" . "<br>";
            $idServico == 1 ? $totalDePaginas = $qtdObjetos + $qtdPaginasPDF : $totalDePaginas = ($qtdObjetos * 2) + $qtdPaginasPDF;
            //echo "Total de páginas para imprimir são: {$totalDePaginas}" . "<br><br>";
            $this->escreverArquivoInsercaoTXT($arquivoNaPastaTmp, $this->getDestinoArquivo(), $qtdObjetos, $qtdPaginasPDF, $idServico);
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
        $numeroOS = $this->receberNumeroDoLote($arquivoNaPastaTmp);
        $elementosDaMatriz = $this->mutiplexNoBD->verificaSeExisteMatrizInsercaoXML($matriz);
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
            
            //echo " O arquivo tem {$qtdObjetos} objetos" . "<br>";
            //echo "Total de páginas em todos os PDFs: {$qtdPaginasPDF}" . "<br>";
            $idServico == 1 ? $totalDePaginas = $qtdObjetos + $qtdPaginasPDF : $totalDePaginas = ($qtdObjetos * 2) + $qtdPaginasPDF;
            //echo "Total de páginas para imprimir são: {$totalDePaginas}" . "<br><br>";
            $this->escreverArquivoInsercaoXML($arquivoNaPastaTmp, $this->getDestinoArquivo(), $qtdObjetos, $qtdPaginasPDF, $idServico);
            $matrizSemCadastroXML = "S";
        } else {
            $matrizSemCadastroXML = "N";

            if ($matrizSemCadastroXML == "N" && $this->retornarMatrizSemCadastroTXT() == "N") {
                $this->escreverLogInsercao($this->getDestinoArquivo(), $arquivo);
            }
        }  
    }


}
