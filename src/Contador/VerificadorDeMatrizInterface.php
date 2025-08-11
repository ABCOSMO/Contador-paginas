<?php

namespace Correios\ContadorDePaginas\Contador;

interface VerificadorDeMatrizInterface
{
    public function VerificarMatrizTXT(string $arquivoNaPastaTmp): void;
    public function VerificarMatrizXML(string $arquivoNaPastaTmp, string $arquivo): void;
}