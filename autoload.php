<?php

spl_autoload_register(function(string $className) {

    $caminho =  str_replace('Correios\\ContadorDePaginas', 'src', $className) . '.php';
    $caminhoCompleto = str_replace('\\', DIRECTORY_SEPARATOR, $caminho);

    require_once __DIR__ . DIRECTORY_SEPARATOR . $caminhoCompleto;
});