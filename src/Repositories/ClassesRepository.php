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
}
