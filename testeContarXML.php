<?php

// Nome do seu arquivo XML
$arquivoXml = 'C:\teste\xml\e-Carta_12201_26198_OS_1523034.xml';

// Verifica se o arquivo existe
if (file_exists($arquivoXml)) {
    // Carrega o arquivo XML em um objeto SimpleXMLElement
    $xml = simplexml_load_file($arquivoXml);

    // Usa XPath para contar todas as tags <livro>
    // Se a tag estiver em um nó específico, você pode ajustar o caminho.
    // Exemplo: 'livraria/livro'
    $numLivros = count($xml->xpath('//codigoObjeto'));

    // Exibe o resultado
    echo "Número de objetos encontrados: " . $numLivros;
} else {
    // Se o arquivo não for encontrado, exibe uma mensagem de erro
    exit('Erro: Não foi possível encontrar o arquivo XML ' . $arquivoXml);
}

?>