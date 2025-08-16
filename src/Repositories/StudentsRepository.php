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

    public function getAll()
    {
        $params = [];
        $params['FILTER']['deleted_at IS NULL'] = NULL;
        $params['FIELDS'] = 'id, name, date_of_birth, document, email';
        $params['ORDERBY'] = 'name ASC';

        // Chama o método consult() do Repository para executar a query
        return $this->consult($params);
    }
}
