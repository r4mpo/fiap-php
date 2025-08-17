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
     * Recupera todas as turmas ativas do sistema e, opcionalmente, uma turma específica pelo seu ID,
     * incluindo a quantidade de alunos ativos matriculados em cada uma.
     *
     * Regras e processos aplicados:
     * - Considera apenas turmas não deletadas (`classes_tbl.deleted_at IS NULL`).
     * - Considera apenas alunos não deletados (`students_tbl.deleted_at IS NULL`).
     * - Se o parâmetro `$classId` for informado, aplica filtro para retornar apenas a turma correspondente.
     * - Seleciona os campos da turma (`id`, `name`, `description`) e contabiliza o número de alunos
     *   relacionados via `COUNT(classes_students_tbl.student_id)` como `qttStudents`.
     * - Relaciona turmas e alunos por meio de dois LEFT JOINs:
     *   - `classes_students_tbl`: liga turmas aos alunos matriculados.
     *   - `students_tbl`: garante que apenas alunos ativos sejam contabilizados.
     * - Agrupa os resultados pelo ID da turma (`GROUPBY classes_tbl.id`) para consolidar a contagem.
     * - Ordena o resultado pelo nome da turma em ordem crescente (`ORDERBY classes_tbl.name ASC`).
     *
     * Por fim, os parâmetros de consulta são enviados para o método `consult()`, que executa a query
     * no banco de dados e retorna os resultados formatados.
     *
     * @param int|null $classId (opcional) ID da turma a ser filtrada
     * @return array Lista de turmas ativas (ou a turma filtrada) com a contagem de alunos matriculados
     */
    public function getClasses($classId = null): array
    {
        $params = [];
        $params['FILTER']['classes_tbl.deleted_at IS NULL'] = NULL;
        $params['FILTER']['students_tbl.deleted_at IS NULL'] = NULL;

        if ($classId != null) {
            $params['FILTER']['classes_tbl.id'] = $classId;
        }

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

    /**
     * Insere ou atualiza um registro na tabela de classes de acordo com os dados fornecidos.
     *
     * Fluxo de execução:
     * 1. Monta o array $params['SET'] contendo os campos que sempre serão
     *    atualizados/armazenados:
     *    - 'name'        → nome da classe.
     *    - 'description' → descrição da classe.
     *    - 'updated_at'  → timestamp da última atualização (definido automaticamente).
     *
     * 2. Verifica se o campo 'id' foi informado em $fields:
     *    - Caso SIM: considera que já existe um registro a ser alterado,
     *      adiciona $params['FILTER']['id'] e executa o método `alter()`,
     *      retornando o número de linhas afetadas.
     *    - Caso NÃO: considera que é um novo registro, chama o método `insert()`
     *      com os dados preparados e retorna o número de linhas inseridas.
     *
     * @param array $fields Dados da classe (ex.: id, name, description).
     * @return int Quantidade de linhas afetadas (1 em caso de sucesso, 0 se nada foi alterado/inserido).
     */
    public function register(array $fields): int
    {
        $params = [];
        $params['SET']['name'] = $fields['name'];
        $params['SET']['description'] = $fields['description'];
        $params['SET']['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($fields['id'])) {
            $params['FILTER']['id'] = $fields['id'];
            return $this->alter($params);
        }

        return $this->insert($params);
    }

    /**
     * Recupera os dados para o primeiro gráfico (Top 5 turmas com mais matrículas).
     *
     * Processos realizados nesta função:
     * 1. Define os campos que serão retornados:
     *    - `class_id`: ID da turma.
     *    - `class_name`: Nome da turma.
     *    - `total_students`: Total de alunos matriculados na turma.
     *
     * 2. Faz um LEFT JOIN com a tabela `classes_students_tbl` para contar os alunos,
     *    considerando apenas os registros que não foram logicamente deletados (`deleted_at IS NULL`).
     *
     * 3. Aplica filtro para considerar apenas turmas ativas (`classes_tbl.deleted_at IS NULL`).
     *
     * 4. Agrupa os resultados por turma (`class_id` e `class_name`) para que a contagem de alunos seja correta.
     *
     * 5. Ordena as turmas pelo total de alunos em ordem decrescente (`ORDER BY total_students DESC`),
     *    para trazer as turmas com mais matrículas no topo.
     *
     * 6. Limita o resultado às 5 primeiras turmas (`LIMIT 5`).
     *
     * 7. Retorna o resultado da consulta chamando o método `consult` com os parâmetros definidos.
     *
     * @return array Lista das 5 turmas com maior número de matrículas, cada item contendo:
     *               - class_id
     *               - class_name
     *               - total_students
     */
    public function getChartData(): array
    {
        $params = [];
        $params['FIELDS'] = 'classes_tbl.id AS class_id, classes_tbl.name AS class_name, COUNT(classes_students_tbl.student_id) AS total_students';

        $params['JOIN'][] = [
            'TYPE' => 'LEFT',
            'TABLE' => 'classes_students_tbl',
            'CONDITIONS' => 'classes_tbl.id = classes_students_tbl.class_id AND classes_students_tbl.deleted_at IS NULL'
        ];

        $params['FILTER']['classes_tbl.deleted_at IS NULL'] = null;
        $params['GROUPBY'] = 'classes_tbl.id, classes_tbl.name';
        $params['ORDERBY'] = 'total_students DESC';
        $params['LIMIT'] = 5;

        return $this->consult($params);
    }
}
