<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Classes\ClassesService;

class ClassesController extends Controller
{
    private ClassesService $classesService;

    /**
     * Construtor da classe.
     * Inicializa a instância de ClassesService para gerenciar o CRUD de Turmas.
     */
    public function __construct()
    {
        $this->classesService = new ClassesService();
    }

    /**
     * Exibe a lista de turmas cadastradas no sistema.
     *
     * Esta função é responsável por:
     * 1. Recuperar todos os registros de turmas utilizando o serviço `classesService`.
     * 2. Passar os dados obtidos para a view `classes/index`.
     *
     * O array enviado para a view contém:
     * - 'classes': uma lista de turmas com seus respectivos dados.
     *
     * @return void
     */
    public function index(): void
    {
        $data = $this->classesService->index();
        $this->view('classes/index', [
            'classes' => $data
        ]);
    }
}