<?php

namespace Src\Services\Users;

use Src\Repositories\UsersRepository;

class UsersService
{
    private UsersRepository $usersRepository;

    /**
     * Construtor da classe.
     * Inicializa a instância do repositório de usuários (UsersRepository),
     * que será utilizada para operar o CRUD no banco.
     */
    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
    }

    public function index(): array
    {
        return $this->usersRepository->getUsers();
    }

    public function getUserById(int $id): array
    {
        return $this->usersRepository->getUsers($id);
    }

    public function createOrUpdate(array $params)
    {
        $id = $params['id'] ?? null;
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao atualizar a informação solicitada.';


        if(validateEmail($params['email']) == false) {
            $result['message'] = 'O e-mail informado não é válido.';
            return $result;
        }

        $findUser = $this->usersRepository->findUser($params['email']);

        if (!empty($findUser) && $findUser[0]['id'] != $id) {
            $result['message'] = 'Já existe um usuário cadastrado com o e-mail informado.';
            return $result;
        }

        $validate = [
            'id' => $id,
            'name' => sanitizeString($params['name']),
            'email' => sanitizeString($params['email']),
            'password' => password_hash($params['password'], PASSWORD_DEFAULT),
        ];

        $rowAffected = $this->usersRepository->register($validate);


        if ($rowAffected > 0) {
            $result['code'] = '111';
            $result['message'] = 'Informação atualizada com sucesso.';
            $result['redirect'] = BASE_URL . '/users';
        }

        return $result;
    }
}