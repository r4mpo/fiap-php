<?php

namespace Src\Services\Students;

use Src\Repositories\StudentsRepository;

class StudentsService
{
    /**
     * Repositório responsável por operações de banco de dados da tabela de alunos.
     *
     * @var StudentsRepository
     */
    private StudentsRepository $studentsRepository;

    /**
     * Construtor da classe StudentsService.
     *
     * Inicializa a instância do repositório de alunos para permitir
     * operações de consulta e manipulação de dados.
     */
    public function __construct()
    {
        $this->studentsRepository = new StudentsRepository();
    }

    /**
     * Recupera a lista de todos os alunos ativos e formata os dados para exibição.
     *
     * Processos realizados nesta função:
     * 1. Chama o repositório para obter todos os alunos ativos.
     * 2. Para cada aluno encontrado:
     *    - Codifica o `id` em base64 para segurança ou uso em URLs.
     *    - Mantém o `name` e `email` como estão.
     *    - Converte a `date_of_birth` do formato YYYY-MM-DD para DD/MM/YYYY.
     *    - Formata o CPF utilizando a função `format_cpf()`.
     * 3. Retorna um array com todos os alunos já formatados.
     *
     * @return array Lista de alunos ativos com dados formatados para exibição.
     */
    public function index(): array
    {
        $students = [];
        $data = $this->studentsRepository->getAll();

        if (!empty($data)) {
            foreach($data as $student)
            {
                $students[] = [
                    'id' => base64_encode($student['id']),
                    'name' => $student['name'],
                    'email' => $student['email'],
                    'date_of_birth' => date('d/m/Y', strtotime($student['date_of_birth'])),
                    'document' => format_cpf($student['document']),
                ];
            }
        }

        return $students;
    }
}