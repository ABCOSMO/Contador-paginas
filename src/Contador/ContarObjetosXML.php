<?php

namespace Correios\ContadorDePaginas\Contador;
use Correios\ContadorDePaginas\Contador\ManipuladorDeDiretoriosTrait;
use SplFileObject;
use Exception;

class ContarObjetosXML
{
    private $extensaoDoArquivo;
    use ManipuladorDeDiretoriosTrait;

    public function __construct(string $extensaoDoArquivo)
    {
        $this->extensaoDoArquivo = $extensaoDoArquivo;
    }

    public function getExtensaoDoArquivo(): string
    {
        return $this->extensaoDoArquivo;
    }

    public function contarObjetosXML(string $caminhoTemporario): string
    {
        $info = pathinfo($caminhoTemporario);
        $nomeArquivoSemExtensao = $info['filename'];
        $novaExtensao = 'xml';
        $novoNomeArquivo = $nomeArquivoSemExtensao . "." . $novaExtensao;
        $novoCaminhoArquivo = $info['dirname'] . DIRECTORY_SEPARATOR . $novoNomeArquivo;
        $caminhoParaUsar = $this->normalizarCaminho($novoCaminhoArquivo);

         if(!file_exists($caminhoParaUsar)){
            return 'Erro: Não foi possível encontrar o arquivo XML ' . $caminhoParaUsar . '<br>';
        }

        try {
            $xml = simplexml_load_file($caminhoParaUsar);
            if ($xml === false) {
                return 'Erro ao carregar o arquivo XML. Verifique se ele é válido e não está vazio.';
            }
            $objetosXML = count($xml->xpath('//codigoObjeto'));
            return $objetosXML;
        } catch (\Exception $e) {
            return "Erro ao processar o arquivo: " . $e->getMessage() . "<br>";
        }    
    }
}