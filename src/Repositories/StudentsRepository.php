<?php

namespace Src\Repositories;

use Src\Core\Repository;
use Src\Models\Students;

class StudentsRepository extends Repository
{
    /**
     * Construtor da classe.
     *
     * Define a tabela padrão que será utilizada pelo repositório de alunos.
     */
    public function __construct()
    {
        $studentsModel = new Students();
        $this->setModel($studentsModel);
    }

    /**
     * Recupera todos os alunos ativos do sistema, com possibilidade de filtros adicionais.
     *
     * Esta função monta os parâmetros necessários para consultar a base de dados,
     * retornando apenas os alunos que não foram deletados (`deleted_at IS NULL`).
     * Caso sejam fornecidos filtros adicionais, eles serão aplicados à consulta.
     *
     * Parâmetros da consulta:
     * - FILTER: aplica filtro para selecionar apenas registros ativos e outros filtros opcionais.
     * - FIELDS: define os campos a serem retornados: `id`, `name`, `date_of_birth`, `document` e `email`.
     * - ORDERBY: ordena os resultados pelo campo `name` em ordem crescente.
     *
     * Processos realizados:
     * 1. Define o filtro padrão para alunos ativos.
     * 2. Define os campos a serem retornados.
     * 3. Aplica quaisquer filtros adicionais passados via parâmetro `$filters`.
     * 4. Chama o método `consult()` do repositório para executar a query e obter os resultados.
     *
     * @param array $filters (opcional) Array associativo de filtros adicionais no formato ['campo' => 'valor'].
     * @return array Lista de alunos ativos, cada item contendo os campos especificados.
     */
    public function getAll(array $filters = []): array
    {
        $params = [];
        $params['FILTER']['deleted_at IS NULL'] = NULL;
        $params['FIELDS'] = 'id, name, date_of_birth, document, email';
        $params['ORDERBY'] = 'name ASC';

        // Se filtros adicionais forem passados, adiciona ao array de parâmetros
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $params['FILTER'][$key] = $value;
            }
        }

        // Chama o método consult() do Repository para executar a query
        return $this->consult($params);
    }

    /**
     * Realiza uma exclusão lógica (soft delete) de um registro de aluno.
     *
     * Esta função não remove fisicamente o registro do banco de dados, mas
     * atualiza o campo `deleted_at` com a data e hora atual, indicando que o
     * registro foi "excluído".
     *
     * Passos realizados nesta função:
     * 1. Cria um array `$params` que define os parâmetros para o método `alter`:
     *    - `FILTER` => define qual registro será alterado, usando o ID do aluno.
     *    - `SET`    => define os campos que serão atualizados; neste caso, apenas `deleted_at`.
     * 2. Chama o método `alter($params)` do repositório, que executa o UPDATE no banco.
     * 3. Retorna o resultado da operação, normalmente o número de linhas afetadas.
     *
     * @param string $studentId ID do aluno a ser excluído logicamente
     * @return int Número de linhas afetadas pela operação (0 se nenhum registro foi alterado)
     */
    public function softDelete(string $studentId): int
    {
        $params = [];
        $params['FILTER']['id'] = $studentId;
        $params['SET']['deleted_at'] = date('Y-m-d H:i:s');

        return $this->alter($params);
    }

    /**
     * Registra ou atualiza um aluno no banco de dados.
     *
     * Processos realizados:
     * 1. Monta o array `$params['SET']` com os campos recebidos:
     *    - `name`          => Nome do aluno.
     *    - `date_of_birth` => Data de nascimento.
     *    - `document`      => CPF/documento (somente números).
     *    - `email`         => E-mail do aluno.
     *    - `password`      => Senha (hash, se fornecida).
     *    - `updated_at`    => Timestamp da atualização.
     *
     * 2. Verifica se foi informado um `id` no array `$fields`:
     *    - Se sim, aplica o filtro por `id` e executa `alter()` (atualização).
     *    - Se não, executa `insert()` (novo registro).
     *
     * @param array $fields Dados do aluno (chaves: id, name, date_of_birth, document, email, password).
     * @return int Número de linhas afetadas (insert ou update).
     */
    public function register(array $fields): int
    {
        $params = [];
        $params['SET']['name'] = $fields['name'];
        $params['SET']['date_of_birth'] = $fields['date_of_birth'];
        $params['SET']['document'] = $fields['document'];
        $params['SET']['email'] = $fields['email'];

        if (!empty($fields['password'])) {
            $params['SET']['password'] = $fields['password'];
        }

        $params['SET']['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($fields['id'])) {
            $params['FILTER']['id'] = $fields['id'];
            return $this->alter($params);
        }

        return $this->insert($params);
    }

    /**
     * Recupera a lista de alunos disponíveis para serem vinculados a uma turma.
     *
     * Regras aplicadas:
     * - Seleciona apenas alunos ativos (students_tbl.deleted_at IS NULL).
     * - Exclui da listagem os alunos que já possuem vínculo com a turma informada ($classId).
     *   Isso é feito através de um subselect utilizando NOT IN.
     * - Retorna somente os campos `id` e `name` da tabela de alunos.
     * - Ordena os resultados alfabeticamente pelo nome.
     *
     * @param string $classId ID da turma que deve ser usada como referência
     *                        para filtrar os alunos já vinculados.
     * @return array Lista de alunos disponíveis (id e name).
     */
    public function getAvailableStudents(string $classId): array
    {
        $params = [];
        $params['FILTER']['students_tbl.deleted_at IS NULL'] = null;

        $params['FILTER']['students_tbl.id NOT IN (
        SELECT classes_students_tbl.student_id FROM classes_students_tbl WHERE 
        classes_students_tbl.class_id = ' . $classId . ' AND classes_students_tbl.deleted_at IS NULL
        )'] = null;

        $params['FIELDS'] = 'students_tbl.id, students_tbl.name';
        $params['ORDERBY'] = 'students_tbl.name ASC';

        // Executa a consulta no banco de dados com os parâmetros definidos
        return $this->consult($params);
    }

}