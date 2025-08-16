<?php

namespace Src\Repositories;

use Src\Core\Repository;
use Src\Models\Users;

class UsersRepository extends Repository
{
    /**
     * Construtor da classe.
     *
     * Define a tabela padrão que será utilizada pelo repositório de usuários.
     */
    public function __construct()
    {
        $usersModel = new Users();
        $this->setModel($usersModel);
    }

    /**
     * Busca um usuário pelo e-mail e senha fornecidos.
     *
     * Cria os parâmetros de filtro para consulta, incluindo:
     * - email
     * - deleted_at IS NULL (usuários não deletados)
     *
     * @param string $email E-mail do usuário
     * @return array Array associativo com os dados do usuário, ou vazio se não encontrado
     */
    public function findUser(string $email): array
    {
        $params = [];
        $params['FILTER']['email'] = $email;
        $params['FILTER']['deleted_at IS NULL'] = NULL;

        // Chama o método consult() do Repository para executar a query
        return $this->consult($params);
    }
}
