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

    /**
     * Recupera usuários do banco de dados.
     *
     * Esta função:
     * 1. Cria os parâmetros de filtro para apenas usuários não deletados (`deleted_at IS NULL`).
     * 2. Se um ID for fornecido, filtra especificamente pelo usuário com esse ID.
     * 3. Chama a função `consult()` (provavelmente do repositório) para retornar os resultados.
     *
     * @param int|null $id ID do usuário (opcional). Se fornecido, retorna apenas esse usuário.
     * @return array Array contendo os dados dos usuários encontrados.
     */
    public function getUsers($id = null): array
    {
        $params = [];
        $params['FILTER']['deleted_at IS NULL'] = NULL;

        if ($id !== null) {
            $params['FILTER']['id'] = $id;
        }

        return $this->consult($params);
    }

    /**
     * Cria ou atualiza um usuário no banco de dados.
     *
     * Esta função:
     * 1. Prepara os dados do usuário para inserção ou atualização, incluindo `name`, `email`, `password` e `updated_at`.
     * 2. Se o array $fields contiver um `id`, chama a função `alter()` para atualizar o registro existente.
     * 3. Caso contrário, chama a função `insert()` para criar um novo registro.
     *
     * @param array $fields Array associativo contendo os campos do usuário: 'name', 'email', 'password' e opcionalmente 'id'.
     * @return int ID do registro inserido ou número de linhas afetadas na atualização.
     */
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
