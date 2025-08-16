<?php

namespace Src\Services\Users;

use Src\Repositories\UsersRepository;

class LoginService
{
    private UsersRepository $usersRepository;

    /**
     * Construtor da classe.
     * Inicializa a instância do repositório de usuários (UsersRepository),
     * que será utilizada para consultar os dados de autenticação no banco.
     */
    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
    }

    /**
     * Realiza o processo de login do usuário.
     *
     * Recebe os dados do formulário (email e senha) e verifica se o usuário existe
     * e se a senha está correta. Caso a autenticação seja bem-sucedida, armazena
     * os dados do usuário na sessão.
     *
     * @param array $params Array com os dados do formulário:
     *                      - 'email' (string): email do usuário
     *                      - 'password' (string): senha do usuário
     * @return array Retorna um array associativo com:
     *   - code (int): código de status da autenticação (111 = sucesso, 333 = erro)
     *   - message (string): mensagem informando o resultado da operação
     */
    public function login(array $params): array
    {
        // Estrutura de retorno padrão (caso não encontre o usuário).
        $result = [];
        $result['code'] = 333;
        $result['message'] = 'Usuário não encontrado em nossos registros.';

        // Consulta no banco de dados com email.
        $data = $this->usersRepository->findUser($params['email']);

        // Se o usuário for encontrado, retorna sucesso e registra a sessão.
        if (!empty($data) && is_array($data)) {
            $result['message'] = 'E-mail ou senha de acesso incorreto(s).';
            $user = $data[0];
            if (password_verify($params['password'], $user['password'])) {
                $result['code'] = 111;
                $result['message'] = 'Autenticação efetuada com sucesso.';
                $_SESSION['authenticated'] = $user;  // Armazena os dados do usuário na sessão.
            }
        }

        return $result;
    }
}