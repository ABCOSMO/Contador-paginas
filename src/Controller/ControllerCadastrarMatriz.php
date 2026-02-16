<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

class ControllerCadastrarMatriz implements Controller
{
    public function processaRequisicao(): void
    {
        include __DIR__ . '/../../views/cadastrar-matriz.php';
    }
}