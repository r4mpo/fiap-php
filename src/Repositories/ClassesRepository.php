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
     * Recupera todas as turmas ativas do sistema junto com a quantidade de alunos matriculados em cada uma.
     *
     * Esta função constrói os parâmetros necessários para a consulta no banco de dados:
     * - Retorna apenas turmas que não foram deletadas (`classes_tbl.deleted_at IS NULL`).
     * - Considera apenas alunos ativos (`students_tbl.deleted_at IS NULL`).
     * - Realiza LEFT JOIN com a tabela `classes_students_tbl` para relacionar turmas com alunos.
     * - Realiza LEFT JOIN com a tabela `students_tbl` para garantir que apenas alunos ativos sejam contabilizados.
     *
     * Parâmetros da consulta:
     * - FILTER: aplica filtros para turmas e alunos ativos.
     * - FIELDS: seleciona os campos `id`, `name`, `description` da turma e a contagem de alunos como `qttStudents`.
     * - JOIN: realiza os LEFT JOINs necessários para relacionar turmas e alunos.
     * - GROUPBY: agrupa os resultados pelo `id` da turma, permitindo contar corretamente os alunos.
     * - ORDERBY: ordena as turmas pelo campo `name` em ordem crescente.
     *
     * Ao final, chama o método `consult()` do repositório, que executa a query e retorna os resultados.
     *
     * @return array Lista de turmas ativas com a contagem de alunos matriculados em cada uma
     */
    public function getAll(): array
    {
        $params = [];
        $params['FILTER']['classes_tbl.deleted_at IS NULL'] = NULL;
        $params['FILTER']['students_tbl.deleted_at IS NULL'] = NULL;
        $params['FIELDS'] = 'classes_tbl.id, classes_tbl.name, classes_tbl.description, COUNT(classes_students_tbl.student_id) AS qttStudents';
        $params['GROUPBY'] = 'classes_tbl.id';
        $params['ORDERBY'] = 'classes_tbl.name ASC';

        $params['JOIN'][] = [
            'TYPE' => 'LEFT',
            'TABLE' => 'classes_students_tbl',
            'CONDITIONS' => 'classes_students_tbl.class_id = classes_tbl.id'
        ];

        $params['JOIN'][] = [
            'TYPE' => 'LEFT',
            'TABLE' => 'students_tbl',
            'CONDITIONS' => 'classes_students_tbl.student_id = students_tbl.id'
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
