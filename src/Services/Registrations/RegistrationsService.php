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
                    'id' => $student['id'],
                    'name' => $student['name'],
                ];
            }
        }

        return $students;
    }

    /**
     * Registra a matrícula de um aluno em uma turma.
     *
     * Processos realizados:
     * 1. Define um retorno padrão de erro (code 333) caso algo falhe.
     * 2. Verifica se os parâmetros obrigatórios `student_id` e `class_id` foram informados.
     * 3. Decodifica os IDs recebidos em Base64 para obter os valores reais.
     * 4. Verifica no repositório se o aluno já está matriculado na turma:
     *    - Se já estiver, retorna um código de aviso (code 222) com a mensagem adequada.
     * 5. Caso não esteja matriculado:
     *    - Chama o repositório para registrar a matrícula.
     *    - Se a operação afetar pelo menos uma linha no banco, retorna sucesso (code 111),
     *      incluindo mensagem de confirmação e redirecionamento para a tela da turma.
     * 6. Retorna o resultado da operação (sucesso, erro ou já registrado).
     *
     * @param array $params Parâmetros recebidos contendo os IDs do aluno e da turma.
     *                      Espera-se que venham codificados em Base64URL.
     * @return array Estrutura com código, mensagem e, em caso de sucesso, URL de redirecionamento.
     */
    public function registerStudent(array $params): array
    {
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao efetuar a matricula.';

        if (isset($params['student_id']) && isset($params['class_id'])) {
            $studentId = base64urlDecode($params['student_id']);
            $classId = base64urlDecode($params['class_id']);


            $alreadyRegistered = $this->registrationsRepository->isStudentRegistered($studentId, $classId);
            
            if ($alreadyRegistered) {
                $result['code'] = '222';
                $result['message'] = 'O aluno já está matriculado nesta turma.';
                return $result;
            }

            // Chama o repositório para registrar a matrícula
            $rowAffected = $this->registrationsRepository->registerStudent($studentId, $classId);

            if ($rowAffected > 0) {
                $result['code'] = '111';
                $result['message'] = 'Matrícula efetuada com sucesso.';
                $result['redirect'] = BASE_URL . '/registrations/' . $params['class_id'];
            }
        }

        return $result;
    }
}