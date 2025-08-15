<?php

namespace Src\Controllers;

use Src\Core\Controller;

class ErrorsController extends Controller
{
    /**
     * Exibe a view de erro para rotas não encontradas.
     *
     * @param string $route Caminho requisitado que não foi encontrado.
     *
     * @return void
     */
    public function notFoundRoute($route): void
    {
        $this->view('errors/notFoundRoute', [
            'route' => $route
        ]);
    }
}