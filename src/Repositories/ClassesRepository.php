<?php

namespace Src\Repositories;

use Src\Core\Repository;
use Src\Models\Classes;

class ClassesRepository extends Repository
{
    /**
     * Construtor da classe.
     *
     * Define a tabela padrão que será utilizada pelo repositório de turmas.
     */
    public function __construct()
    {
        $studentsModel = new Classes();
        $this->setModel($studentsModel);
    }

    /**
     * Recupera todas as turmas ativas do sistema, incluindo a quantidade de alunos matriculados.
     *
     * Esta função constrói os parâmetros necessários para consultar a base de dados,
     * retornando apenas turmas que não foram deletadas (`deleted_at IS NULL`).
     * Ela também realiza um LEFT JOIN com a tabela `classes_students_tbl` para contar
     * quantos alunos estão associados a cada turma.
     *
     * Parâmetros utilizados na consulta:
     * - FILTER: filtra registros onde `classes_tbl.deleted_at` é nulo (somente turmas ativas).
     * - FIELDS: seleciona os campos `id`, `name`, `description` e adiciona a contagem de alunos como `qttStudents`.
     * - JOIN: realiza LEFT JOIN com `classes_students_tbl` para contar os alunos por turma.
     * - GROUPBY: agrupa os resultados por `classes_tbl.id` para que a contagem funcione corretamente.
     * - ORDERBY: ordena os resultados pelo campo `name` em ordem crescente.
     *
     * Em seguida, chama o método `consult()` do repositório para executar a query.
     *
     * @return array Lista de turmas ativas com a quantidade de alunos matriculados.
     */
    public function getAll(): array
    {
        $params = [];
        $params['FILTER']['classes_tbl.deleted_at IS NULL'] = NULL;
        $params['FIELDS'] = 'classes_tbl.id, classes_tbl.name, classes_tbl.description, COUNT(classes_students_tbl.student_id) AS qttStudents';
        $params['GROUPBY'] = 'classes_tbl.id';
        $params['ORDERBY'] = 'classes_tbl.name ASC';

        $params['JOIN'][] = [
            'TYPE' => 'LEFT',
            'TABLE' => 'classes_students_tbl',
            'CONDITIONS' => 'classes_students_tbl.class_id = classes_tbl.id'
        ];

        // Chama o método consult() do Repository para executar a query
        return $this->consult($params);
    }

        /**
     * Realiza uma exclusão lógica (soft delete) de um registro de turma.
     *
     * Esta função não remove fisicamente o registro do banco de dados, mas
     * atualiza o campo `deleted_at` com a data e hora atual, indicando que o
     * registro foi "excluído".
     *
     * Passos realizados nesta função:
     * 1. Cria um array `$params` que define os parâmetros para o método `alter`:
     *    - `FILTER` => define qual registro será alterado, usando o ID da turma.
     *    - `SET`    => define os campos que serão atualizados; neste caso, apenas `deleted_at`.
     * 2. Chama o método `alter($params)` do repositório, que executa o UPDATE no banco.
     * 3. Retorna o resultado da operação, normalmente o número de linhas afetadas.
     *
     * @param string $classesId ID do turma a ser excluído logicamente
     * @return int Número de linhas afetadas pela operação (0 se nenhum registro foi alterado)
     */
    public function softDelete(string $classesId): int
    {
        $params = [];
        $params['FILTER']['id'] = $classesId;
        $params['SET']['deleted_at'] = date('Y-m-d H:i:s');

        return $this->alter($params);
    }
}