<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Students\StudentsService;

class StudentsController extends Controller
{
    private StudentsService $studentsService;

    /**
     * Construtor da classe.
     * Inicializa a instância de StudentsService para gerenciar o CRUD de Alunos.
     */
    public function __construct()
    {
        $this->studentsService = new StudentsService();
    }

    /**
     * Exibe a lista de alunos cadastrados no sistema.
     *
     * Esta função é responsável por:
     * 1. Recuperar todos os registros de alunos utilizando o serviço `studentsService`.
     * 2. Passar os dados obtidos para a view `students/index`.
     *
     * O array enviado para a view contém:
     * - 'students': uma lista de alunos com seus respectivos dados.
     *
     * @return void
     */
    public function index(): void
    {
        $data = $this->studentsService->index();
        $this->view('students/index', [
            'students' => $data
        ]);
    }
}
