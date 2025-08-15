<?php

namespace Src\Core;

use Src\Utils\RenderView;

class Controller
{
    /**
     * Renderiza uma view específica, passando variáveis para ela.
     *
     * @param string               $view Nome da view (sem extensão .php)
     * @param array<string, mixed> $args Variáveis a serem passadas para a view
     *
     * @return void
     */
    protected function view(string $view, array $args): void
    {
        $renderView = new RenderView();
        $renderView->loadView($view, $args);
    }
}