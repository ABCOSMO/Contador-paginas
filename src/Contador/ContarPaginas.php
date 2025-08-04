<?php

namespace Correios\ContadorDePaginas\Contador;
use Correios\ContadorDePaginas\Contador\ManipularArquivosTrait;

class ContarPaginas
{
    use ManipularArquivosTrait;

    private $caminhoArquivo;
    private $nomeArquivo;

    public function __construct(string $caminhoArquivo, string $nomeArquivo)
    {
        $this->caminhoArquivo = $caminhoArquivo;
        $this->nomeArquivo = $nomeArquivo;
    }

    public function contarObjetosXML(): int
    {
        if (file_exists($this->caminhoArquivo)) {
            $xml = simplexml_load_file($this->caminhoArquivo);
            return count($xml->xpath('//codigoObjeto'));
        } else {
            exit('Erro: Não foi possível encontrar o arquivo XML ' . $this->caminhoArquivo);
        }
    }

}