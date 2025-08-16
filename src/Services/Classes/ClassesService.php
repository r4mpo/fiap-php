<?php

namespace Src\Services\Classes;

use Src\Repositories\ClassesRepository;

class ClassesService
{
    /**
     * Repositório responsável por operações de banco de dados da tabela de turmas.
     *
     * @var ClassesRepository
     */
    private ClassesRepository $classesRepository;

    /**
     * Construtor da classe ClassesService.
     *
     * Inicializa a instância do repositório de turmas para permitir
     * operações de consulta e manipulação de dados.
     */
    public function __construct()
    {
        $this->classesRepository = new ClassesRepository();
    }

    /**
     * Recupera a lista de todas as turmas ativas e formata os dados para exibição.
     *
     * Processos realizados nesta função:
     * 1. Chama o repositório para obter todas as turmas ativas (`getAll()`).
     * 2. Para cada turma encontrada:
     *    - Codifica o `id` em base64 para segurança ou uso em URLs.
     *    - Mantém o `name` e `description` (limitando a descrição a 15 caracteres).
     *    - Inclui a quantidade de alunos matriculados (`qttStudents`) retornada pelo repositório.
     * 3. Retorna um array com todas as turmas já formatadas para exibição no front-end.
     *
     * @return array Lista de turmas ativas com dados formatados e quantidade de alunos.
     */
    public function index(): array
    {
        $classes = [];
        $data = $this->classesRepository->getAll();

        if (!empty($data)) {
            foreach ($data as $class) {
                $classes[] = [
                    'id' => $class['id'],
                    'name' => $class['name'],
                    'description' => limitText($class['description'], 20),
                    'qttStudents' => $class['qttStudents'] ?? 0
                ];
            }
        }

        return $classes;
    }

        /**
     * Realiza a exclusão de uma turma utilizando exclusão lógica (soft delete).
     *
     * Esta função é responsável por:
     * 1. Inicializar um array de resultado com um código de erro padrão (`333`) e uma mensagem genérica de falha.
     * 2. Chamar o repositório de turmas (`classesRepository`) para executar a exclusão lógica do registro informado pelo ID.
     *    - A exclusão lógica normalmente atualiza o campo `deleted_at` com a data/hora atual, sem remover fisicamente o registro.
     * 3. Verificar se alguma linha foi afetada pela operação (`$rowAffected > 0`):
     *    - Caso positivo, atualiza o array de resultado com código de sucesso (`111`) e mensagem de confirmação.
     * 4. Retornar o array `$result` contendo:
     *    - `code`    => código do resultado da operação ('111' = sucesso, '333' = erro)
     *    - `message` => mensagem explicativa do resultado
     *
     * @param string $studentId ID do turma a ser excluído
     * @return array Array contendo `code` e `message` indicando o resultado da operação
     */
    public function delete(string $studentId): array
    {
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao excluir a informação solicitada.';

        $rowAffected = $this->classesRepository->softDelete($studentId);

        if ($rowAffected > 0) {
            $result['code'] = '111';
            $result['message'] = 'Informações excluídas com sucesso.';
        }

        return $result;
    }

}
