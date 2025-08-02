<?php
require_once __DIR__ . '/vendor/autoload.php';

use Correios\ContadorDePaginas\Cadastrar\MatrizRepository;
use Correios\ContadorDePaginas\Conectar\ConectarBD;

$conexao = ConectarBD::getConexao();

$cadastro = new MatrizRepository(
	$conexao,
	32222
);

$cadastro->setTipoMatriz("Multiplex");
$cadastro->setQtdPaginas("Variável");
$cadastro->setTipoArquivo("TXT");
$cadastro->setIdComplementar("2");

if ($cadastro->salvar()) {
	echo "Matriz cadastrada com sucesso!" . "<br>";
} else {
	echo "Erro ao cadastrar matriz." . "<br>";
}

echo "\nDados da Matriz Cadastrada:\n";
echo "Matriz: " . $cadastro->getMatriz() . "\n";
echo "Tipo de Matriz: " . $cadastro->getTipoMatriz() . "\n";
echo "Quantidade de Páginas: " . $cadastro->getQtdPaginas() . "\n";