<?php

declare(strict_types=1);

use Correios\ContadorDePaginas\Controller\{
    Controller,
    ControllerMainPage,
    ControllerCadastrarMatriz,
    CadastrarMatriz,
    ControllerContadorMultiplex
};

require_once __DIR__ . '/../vendor/autoload.php';

$routes = require_once __DIR__ . '/../config/routes.php';

//$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
// Substitua a lógica do $pathInfo por esta:
$pathInfo = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    /** @var Controller $controller */
    $controller = new $controllerClass();
    $controller->processaRequisicao();
} else {
    echo "Página não encontrada: " . $key;
}
?>