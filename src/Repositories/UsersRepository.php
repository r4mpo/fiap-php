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

    public function getUsers($id = null): array
    {
        $params = [];
        $params['FILTER']['deleted_at IS NULL'] = NULL;

        if ($id !== null) {
            $params['FILTER']['id'] = $id;
        }

        return $this->consult($params);
    }

    public function register(array $fields): int
    {
        $params = [];
        $params['SET']['name'] = $fields['name'];
        $params['SET']['email'] = $fields['email'];
        $params['SET']['password'] = $fields['password'];
        $params['SET']['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($fields['id'])) {
            $params['FILTER']['id'] = $fields['id'];
            return $this->alter($params);
        }

        return $this->insert($params);
    }
}
