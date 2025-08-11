<?php

namespace Correios\ContadorDePaginas\Contador;
use Correios\ContadorDePaginas\Contador\ManipuladorDeDiretoriosTrait;
use SplFileObject;
use PDOException;

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
            throw new \Exception0 ('Erro: Não foi possível encontrar o arquivo XML ' . $caminhoParaUsar);
        }

        try {
            $xml = simplexml_load_file($caminhoParaUsar);
            if ($xml === false) {
                throw new \Exception ('Erro ao carregar o arquivo XML. Verifique se ele é válido e não está vazio.');
            }
            $objetosXML = count($xml->xpath('//codigoObjeto'));
            return $objetosXML;
        } catch (\Exception $e) {
            throw new \Exception ("Erro ao processar o arquivo: " . $e->getMessage(), 0, $e);
        }    
    }
}