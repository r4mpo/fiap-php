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

    /**
     * Retorna todos os usuários cadastrados.
     *
     * Chama o repositório de usuários para buscar todos os registros que não foram deletados.
     *
     * @return array Lista de usuários.
     */
    public function index(): array
    {
        return $this->usersRepository->getUsers();
    }

    /**
     * Retorna os dados de um usuário específico pelo ID.
     *
     * @param int $id ID do usuário desejado.
     * @return array Dados do usuário encontrado ou array vazio se não encontrado.
     */
    public function getUserById(int $id): array
    {
        return $this->usersRepository->getUsers($id);
    }

    /**
     * Cria ou atualiza um usuário no sistema.
     *
     * Processo realizado:
     * 1. Inicializa o array de resultado com código de erro padrão.
     * 2. Valida se o e-mail informado é válido; se não, retorna erro.
     * 3. Verifica se já existe um usuário com o mesmo e-mail (diferente do ID atual); se sim, retorna erro.
     * 4. Sanitiza os dados (nome e e-mail) e faz hash da senha.
     * 5. Chama o repositório para registrar ou atualizar o usuário.
     * 6. Se a operação for bem-sucedida, altera o código e a mensagem de retorno e adiciona URL de redirecionamento.
     *
     * @param array $params Array com dados do usuário: 'id' (opcional), 'name', 'email', 'password'.
     * @return array Resultado da operação, contendo:
     *               - 'code' => código do status ('111' sucesso, '333' erro),
     *               - 'message' => mensagem informativa,
     *               - 'redirect' => URL para redirecionamento (em caso de sucesso).
     */
    public function createOrUpdate(array $params): array
    {
        $id = $params['id'] ?? null;
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao atualizar a informação solicitada.';

        // Validação de e-mail
        if (validateEmail($params['email']) == false) {
            $result['message'] = 'O e-mail informado não é válido.';
            return $result;
        }

        // Verifica se o e-mail já está cadastrado em outro usuário
        $findUser = $this->usersRepository->findUser($params['email']);
        if (!empty($findUser) && $findUser[0]['id'] != $id) {
            $result['message'] = 'Já existe um usuário cadastrado com o e-mail informado.';
            return $result;
        }

        // Sanitiza e prepara os dados para inserção/atualização
        $validate = [
            'id' => $id,
            'name' => sanitizeString($params['name']),
            'email' => sanitizeString($params['email']),
            'password' => password_hash($params['password'], PASSWORD_DEFAULT),
        ];

        // Registra ou atualiza no banco
        $rowAffected = $this->usersRepository->register($validate);

        // Se houver sucesso, ajusta retorno
        if ($rowAffected > 0) {
            $result['code'] = '111';
            $result['message'] = 'Informação atualizada com sucesso.';
            $result['redirect'] = BASE_URL . '/users';
        }

        return $result;
    }
}