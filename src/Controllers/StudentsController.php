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

    public function index()
    {
        $data = $this->studentsService->index();
        $this->view('students/index', [
            'students' => $data
        ]);
    }
}
