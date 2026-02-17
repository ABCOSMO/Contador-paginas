<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

class ControllerListarMatriz implements Controller
{
    public function processaRequisicao(): void
    {
        include __DIR__ . '/../../views/listar-matriz.php';
    }
}