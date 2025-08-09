<?php

namespace Correios\ContadorDePaginas\Contador;
use Correios\ContadorDePaginas\Contador\ManipuladorDeDiretoriosTrait;
use SplFileObject;
use PDOException;

class ContarObjetosTXT
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

    public function contarObjetosTXT(string $caminhoTemporario): string
    {
        $info = pathinfo($caminhoTemporario);
        $nomeArquivoSemExtensao = $info['filename'];
        $novaExtensao = 'txt';
        $novoNomeArquivo = $nomeArquivoSemExtensao . "." . $novaExtensao;
        $novoCaminhoArquivo = $info['dirname'] . DIRECTORY_SEPARATOR . $novoNomeArquivo;
        $caminhoParaUsar = $this->normalizarCaminho($novoCaminhoArquivo);

        if(!file_exists($caminhoParaUsar)){
            return 'Erro: Não foi possível encontrar o arquivo TXT ' . $caminhoParaUsar . '<br>';
        }

        try {
            $file = new SplFileObject($caminhoParaUsar, 'r');
            $file->seek(PHP_INT_MAX);
            $linhas = $file->key();
            return  $linhas;
        } catch (\Exception $e) {
            return "Erro ao processar o arquivo: " . $e->getMessage() . "<br>";
        }        
    }
}