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
     *    - Formata o CPF utilizando a função `formatCpf()`.
     * 3. Retorna um array com todos os alunos já formatados.
     *
     * @return array Lista de alunos ativos com dados formatados para exibição.
     */
    public function index(): array
    {
        $students = [];
        $data = $this->studentsRepository->getAll();

        if (!empty($data)) {
            foreach ($data as $student) {
                $students[] = [
                    'id' => $student['id'],
                    'name' => $student['name'],
                    'email' => $student['email'],
                    'date_of_birth' => date('d/m/Y', strtotime($student['date_of_birth'])),
                    'document' => formatCpf($student['document']),
                ];
            }
        }

        return $students;
    }

    /**
     * Realiza a exclusão de um aluno utilizando exclusão lógica (soft delete).
     *
     * Esta função é responsável por:
     * 1. Inicializar um array de resultado com um código de erro padrão (`333`) e uma mensagem genérica de falha.
     * 2. Chamar o repositório de alunos (`studentsRepository`) para executar a exclusão lógica do registro informado pelo ID.
     *    - A exclusão lógica normalmente atualiza o campo `deleted_at` com a data/hora atual, sem remover fisicamente o registro.
     * 3. Verificar se alguma linha foi afetada pela operação (`$rowAffected > 0`):
     *    - Caso positivo, atualiza o array de resultado com código de sucesso (`111`) e mensagem de confirmação.
     * 4. Retornar o array `$result` contendo:
     *    - `code`    => código do resultado da operação ('111' = sucesso, '333' = erro)
     *    - `message` => mensagem explicativa do resultado
     *
     * @param string $studentId ID do aluno a ser excluído
     * @return array Array contendo `code` e `message` indicando o resultado da operação
     */
    public function delete(string $studentId): array
    {
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao excluir a informação solicitada.';

        $rowAffected = $this->studentsRepository->softDelete($studentId);

        if ($rowAffected > 0) {
            $result['code'] = '111';
            $result['message'] = 'Informações excluídas com sucesso.';
        }

        return $result;
    }
}
