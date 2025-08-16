<?php

namespace Src\Repositories;

use Src\Core\Repository;
use Src\Models\Registrations;

class RegistrationsRepository extends Repository
{
    /**
     * Construtor da classe RegistrationsRepository.
     *
     * Inicializa o modelo padrão (`Registrations`) que será utilizado
     * para as operações de banco de dados relacionadas às matrículas.
     */
    public function __construct()
    {
        $registrationsModel = new Registrations();
        $this->setModel($registrationsModel);
    }

    /**
     * Recupera todas as turmas ativas cadastradas no sistema.
     *
     * Processos realizados neste método:
     * 1. Define os parâmetros da consulta ao banco de dados:
     *    - **FILTER**: retorna apenas registros onde `classes_students_tbl.deleted_at IS NULL` e 
     *      classes_tbl.deleted_at IS NULL (ou seja, exclui turmas/alunos removidos).
     *    - **FIELDS**: seleciona os campos `classes_tbl.id` e `classes_tbl.name`.
     *    - **JOIN**: realiza um `LEFT JOIN` com a tabela `classes_tbl`,
     *      relacionando as turmas com seus alunos.
     *    - **GROUPBY**: agrupa os resultados por `classes_tbl.id`,
     *      garantindo consistência em agregações.
     *    - **ORDERBY**: ordena os resultados alfabeticamente pelo campo `name`.
     *
     * 2. Executa a query utilizando o método `consult()` herdado de `Repository`.
     *
     * @return array Lista de turmas ativas formatadas, incluindo informações básicas
     *               (id e nome) e agrupadas conforme os critérios definidos.
     */
    public function getAllClasses(): array
    {
        $params = [];
        $params['FILTER']['classes_students_tbl.deleted_at IS NULL'] = null;
        $params['FILTER']['classes_tbl.deleted_at IS NULL'] = null;
        $params['FIELDS'] = 'classes_tbl.id, classes_tbl.name';
        $params['GROUPBY'] = 'classes_tbl.id';
        $params['ORDERBY'] = 'classes_tbl.name ASC';

        $params['JOIN'][] = [
            'TYPE' => 'LEFT',
            'TABLE' => 'classes_tbl',
            'CONDITIONS' => 'classes_tbl.id = classes_students_tbl.class_id'
        ];

        // Executa a consulta no banco de dados com os parâmetros definidos
        return $this->consult($params);
    }

    /**
     * Recupera todos os alunos matriculados em uma turma específica.
     *
     * Processos realizados neste método:
     * 1. Define os parâmetros da consulta ao banco de dados:
     *    - **FILTER**:
     *        - `classes_students_tbl.class_id`: filtra apenas os registros vinculados
     *          à turma informada.
     *        - `classes_students_tbl.deleted_at IS NULL`: garante que apenas
     *          matrículas ativas sejam consideradas.
     *    - **FIELDS**: seleciona os campos da turma (`class_id`, `class_name`)
     *      e dos alunos (`student_id`, `student_name`).
     *    - **ORDERBY**: ordena a lista de alunos em ordem alfabética pelo nome.
     *    - **JOIN**:
     *        - `classes_tbl`: associa cada matrícula à turma correspondente,
     *          filtrando turmas não deletadas.
     *        - `students_tbl`: associa cada matrícula ao aluno correspondente,
     *          filtrando alunos não deletados.
     *
     * 2. Executa a consulta utilizando o método `consult()` herdado de `Repository`.
     *
     * @param string $classId Identificador da turma (chave primária na tabela `classes_tbl`).
     * @return array Lista de alunos matriculados na turma informada,
     *               incluindo dados da turma e do aluno.
     */
    public function getStudentsByClassId(string $classId)
    {
        $params = [];
        $params['FILTER']['classes_students_tbl.class_id'] = $classId;
        $params['FILTER']['classes_students_tbl.deleted_at IS NULL'] = null;
        $params['FIELDS'] = 'classes_tbl.id AS class_id, classes_tbl.name AS class_name, students_tbl.id AS student_id, students_tbl.name AS student_name';
        $params['ORDERBY'] = 'students_tbl.name ASC';

        $params['JOIN'][] = [
            'TYPE' => 'LEFT',
            'TABLE' => 'classes_tbl',
            'CONDITIONS' => 'classes_tbl.id = classes_students_tbl.class_id AND classes_tbl.deleted_at IS NULL'
        ];

        $params['JOIN'][] = [
            'TYPE' => 'LEFT',
            'TABLE' => 'students_tbl',
            'CONDITIONS' => 'students_tbl.id = classes_students_tbl.student_id AND students_tbl.deleted_at IS NULL'
        ];

        // Executa a consulta no banco de dados com os parâmetros definidos
        return $this->consult($params);
    }
}
