<?php

declare(strict_types=1);

use Correios\ContadorDePaginas\Controller\{
    Controller,
    ControllerMainPage,
    ControllerCadastrarMatriz,
    CadastrarMatriz,
    ControllerContadorMultiplex,
    Error404Controller
};

require_once __DIR__ . '/../vendor/autoload.php';

$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
// Substitua a lógica do $pathInfo por esta:
//$pathInfo = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    /** @var Controller $controller */
    $controller = new $controllerClass();    
} else {
    $controller = new Error404Controller();
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

$response = $controller->handle($request);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
?>