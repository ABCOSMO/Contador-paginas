<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

class ControllerMainPage implements Controller
{
    public function processaRequisicao(): void
    {
        include __DIR__ . '/../../views/mainPage.php';
    }
}