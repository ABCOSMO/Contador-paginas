<?php
function pastaVazia($caminho) {
    if (!is_dir($caminho)) {
        return false; // Retorna false se o caminho não for um diretório válido
    }

    $itens = scandir($caminho);

    // Se o array de itens tiver apenas as entradas '.' e '..', a pasta está vazia
    if (count($itens) <= 2) {
        return true;
    }

    return false;
}

// Exemplo de uso:
$caminho_da_pasta = "'C:\teste\xml\'";

if (pastaVazia($caminho_da_pasta)) {
    echo "A pasta está vazia.";
} else {
    echo "A pasta não está vazia.";
}