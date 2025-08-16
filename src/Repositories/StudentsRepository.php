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
}
