<?php

declare(strict_types=1);

namespace Correios\ContadorDePaginas\Helper;

trait HtmlRendererTrait
{
    private function renderTemplate (string $templateName, array $context = []): string
    {
        $templatePath = __DIR__ . '/../../views/';
        extract($context);

        ob_start();
        require_once $templatePath . $templateName . '.php';
        $html = ob_get_clean();
        return $html;
    }
}