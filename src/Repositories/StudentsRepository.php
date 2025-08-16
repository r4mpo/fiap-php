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
     * Recupera todos os alunos ativos do sistema.
     *
     * Esta função constrói os parâmetros necessários para consultar a base de dados
     * e retorna apenas os alunos que não foram deletados (`deleted_at IS NULL`).
     *
     * Parâmetros utilizados na consulta:
     * - FILTER: filtra registros onde `deleted_at` é nulo (somente ativos).
     * - FIELDS: seleciona os campos `id`, `name`, `date_of_birth`, `document` e `email`.
     * - ORDERBY: ordena os resultados pelo campo `name` em ordem crescente.
     *
     * Em seguida, chama o método `consult()` do repositório para executar a query.
     *
     * @return array Lista de alunos ativos com os campos especificados.
     */
    public function getAll(): array
    {
        $params = [];
        $params['FILTER']['deleted_at IS NULL'] = NULL;
        $params['FIELDS'] = 'id, name, date_of_birth, document, email';
        $params['ORDERBY'] = 'name ASC';

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
}
