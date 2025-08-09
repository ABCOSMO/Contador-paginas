<?php
require 'vendor/autoload.php';

// Certifique-se de que o caminho para o arquivo PDF está correto
$pdfFile = '//mbs10065305/xampp_8_2/htdocs/FAP/e-Carta_12201_26322_746180_1_complementar.pdf';

try {
    $parser = new \Smalot\PdfParser\Parser();
    $pdf = $parser->parseFile($pdfFile);
    
    $totalPages = count($pdf->getPages());
    
    echo "O PDF tem " . $totalPages . " páginas.";
} catch (\Exception $e) {
    echo "Erro ao processar o PDF: " . $e->getMessage();
}
?>