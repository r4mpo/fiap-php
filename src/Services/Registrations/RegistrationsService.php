<?php

namespace Src\Services\Registrations;

use Src\Repositories\RegistrationsRepository;
use Src\Repositories\StudentsRepository;

class RegistrationsService
{
    /**
     * Repositório responsável pelas operações de banco de dados relacionadas às matrículas.
     *
     * @var RegistrationsRepository
     */
    private RegistrationsRepository $registrationsRepository;

    /**
     * Repositório responsável pelas operações de banco de dados relacionadas aos alunos.
     *
     * @var StudentsRepository
     */
    private StudentsRepository $studentsRepository;

    /**
     * Construtor da classe RegistrationsService.
     *
     * Inicializa a instância do repositório de matrículas e de alunos, permitindo realizar
     * consultas e manipulações na tabela de matrículas e de alunos.
     */
    public function __construct()
    {
        $this->registrationsRepository = new RegistrationsRepository();
        $this->studentsRepository = new StudentsRepository();
    }

    /**
     * Recupera a lista de todas as turmas disponíveis e formata os dados para exibição.
     *
     * Processos realizados neste método:
     * 1. Obtém todas as turmas a partir do repositório.
     * 2. Para cada turma encontrada:
     *    - Codifica o campo `id` em base64 para maior segurança e uso em URLs.
     *    - Mantém o campo `name` conforme registrado no banco de dados.
     *
     * @return array Lista de turmas formatadas com `id` codificado e `name` original.
     */
    public function getClasses(): array
    {
        $registrations = [];
        $data = $this->registrationsRepository->getAllClasses();

        if (!empty($data)) {
            foreach ($data as $registration) {
                $registrations[] = [
                    'id' => $registration['id'],
                    'name' => $registration['name'],
                ];
            }
        }

        return $registrations;
    }

    /**
     * Retorna a lista de alunos matriculados em uma turma específica,
     * formatando os dados para exibição.
     *
     * Processos realizados neste método:
     * 1. Chama o repositório `RegistrationsRepository::getStudentsByClassId`
     *    para recuperar os registros brutos do banco de dados.
     * 2. Verifica se existem resultados.
     * 3. Para cada registro encontrado, cria um array simplificado contendo:
     *    - **name**: nome do aluno (`student_name`).
     *    - **class**: nome da turma (`class_name`).
     * 4. Retorna a lista formatada de alunos.
     *
     * @param string $classId Identificador da turma (chave primária na tabela `classes_tbl`).
     * @return array Lista de alunos matriculados na turma, contendo nome do aluno e nome da turma.
     */
    public function getStudentsByClassId(string $classId): array
    {
        $registrations = [];
        $data = $this->registrationsRepository->getStudentsByClassId($classId);

        if (!empty($data)) {
            foreach ($data as $registration) {
                $registrations[] = [
                    'name' => $registration['student_name'],
                    'class' => $registration['class_name']
                ];
            }
        }

        return $registrations;
    }

    /**
     * Recupera a lista de alunos disponíveis para matrícula em uma turma específica.
     *
     * Processos realizados neste método:
     * 1. Chama o repositório `getAvailableStudents::getAvailableStudents`
     *    para obter os alunos que ainda não estão matriculados na turma informada.
     * 2. Formata os dados dos alunos, codificando o ID da turma em base64 URL-safe.
     *
     * @param string $classId Identificador da turma (chave primária na tabela `classes_tbl`).
     * @return array Lista de alunos disponíveis para matrícula, com `id` codificado e `name`.
     */
    public function getAvailableStudents(string $classId): array
    {
        $students = [];
        $data = $this->studentsRepository->getAvailableStudents($classId);

        if (!empty($data)) {
            foreach ($data as $student) {
                $students[] = [
                    'id' => base64urlEncode($student['id']),
                    'name' => $student['name'],
                ];
            }
        }

        return $students;
    }
}
