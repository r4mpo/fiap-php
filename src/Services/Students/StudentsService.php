<?php

namespace Src\Services\Students;

use Src\DTOs\StudentsDTO;
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

    /**
     * Cria ou atualiza um aluno no banco de dados a partir dos parâmetros fornecidos.
     *
     * Fluxo de execução:
     * 1. Inicializa um array padrão de retorno ($result) com código de erro "333"
     *    e mensagem genérica de falha.
     * 2. Instancia um DTO (Data Transfer Object) dos alunos com os parâmetros recebidos.
     * 3. Executa a validação dos dados do DTO:
     *    - Caso inválido, retorna imediatamente os erros de validação.
     * 4. Se os dados forem válidos, delega a persistência ao repositório
     *    chamando o método `register()`, que pode criar ou atualizar o registro.
     * 5. Caso a operação afete pelo menos uma linha no banco, redefine o retorno
     *    com código de sucesso "111" e mensagem de confirmação.
     *
     * @param array $params Parâmetros de entrada para criação/atualização (ex.: id, name, description, etc.).
     * @return array Estrutura de retorno contendo:
     *               - 'code' (string): código de status da operação ("111" para sucesso, "333" para falha).
     *               - 'message' (string): mensagem descritiva do resultado.
     *               - Em caso de falha de validação, pode retornar estrutura customizada do DTO.
     */
    public function createOrUpdate(array $params)
    {
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao atualizar a informação solicitada.';

        $dto = new StudentsDTO($params);
        $validate = $dto->validate();

        var_dump($validate);exit;
        if ($validate['invalid']) {
            return $validate;
        }

        $rowAffected = $this->studentsRepository->register($validate);


        if ($rowAffected > 0) {
            $result['code'] = '111';
            $result['message'] = 'Informação atualizada com sucesso.';
            $result['redirect'] = BASE_URL . '/students';
        }

        return $result;
    }
}
