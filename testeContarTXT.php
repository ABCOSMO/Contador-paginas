<?php
$file = new SplFileObject('C:\teste\txt\e-Carta_6541_183201_OS_1507487.txt', 'r');
$file->seek(PHP_INT_MAX);
$linhas = $file->key();
echo "O arquivo tem {$linhas} linhas.";
?>