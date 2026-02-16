<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Controller;

interface Controller
{
    public function processaRequisicao(): void;
}