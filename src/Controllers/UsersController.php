<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Users\LoginService;
use Src\Services\Users\UsersService;

class UsersController extends Controller
{
    private LoginService $loginService;
    private UsersService $usersService;

    /**
     * Construtor da classe.
     * Inicializa a instância de LoginService e UsersServoce para gerenciar a autenticação e crud de usuários.
     */
    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->usersService = new UsersService();
    }

    /**
     * Exibe o formulário de login do usuário.
     * Essa função carrega a view localizada em "users/loginForm".
     *
     * @return void
     */
    public function login(): void
    {
        $this->view('users/loginForm', []);
    }

    /**
     * Executa o processo de login.
     * Recebe os dados enviados pelo usuário (via $this->input()),
     * chama o serviço de autenticação e retorna o resultado em JSON.
     *
     * @return void (imprime JSON e finaliza a execução do script)
     */
    public function exeLogin(): void
    {
        $execute = $this->loginService->login($this->input());
        echo json_encode($execute);
        exit;
    }

    /**
     * Realiza o logout do usuário.
     * Deve destruir a sessão e redirecionar para a página de login
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }

    /**
     * Exibe a lista de todos os usuários.
     *
     * Esta função:
     * 1. Chama o serviço de usuários para obter todos os registros.
     * 2. Renderiza a view 'users/index' passando os dados obtidos.
     */
    public function index(): void
    {
        $users = $this->usersService->index();
        $this->view('users/index', ['users' => $users]);
    }

    /**
     * Exibe o formulário de edição de um usuário específico.
     *
     * Esta função:
     * 1. Recebe os parâmetros (normalmente via URL) e decodifica o ID do usuário.
     * 2. Busca os dados do usuário através da função privada show().
     * 3. Chama a função privada form() passando os dados do usuário para preencher o formulário.
     *
     * @param array $params Parâmetros passados pela rota (o primeiro é o ID codificado do usuário)
     */
    public function formEdit($params): void
    {
        $userId = base64urlDecode($params[0]);
        $user = $this->show($userId);
        $this->form($user[0]['id'], $user[0]['name'], $user[0]['email']);
    }

    /**
     * Retorna os dados de um usuário específico pelo ID.
     *
     * Esta função:
     * 1. Encapsula a chamada ao serviço de usuários.
     * 2. Retorna um array contendo os dados do usuário.
     *
     * @param int $userId ID do usuário
     * @return array Dados do usuário
     */
    private function show($userId): array
    {
        return $this->usersService->getUserById($userId);
    }

    /**
     * Exibe o formulário de usuário preenchido ou vazio.
     *
     * Esta função:
     * 1. Renderiza a view 'users/form' com os dados fornecidos.
     * 2. É utilizada tanto para criação quanto para edição.
     *
     * @param int|string $id ID do usuário
     * @param string $name Nome do usuário
     * @param string $email E-mail do usuário
     */
    private function form($id, $name, $email): void
    {
        $this->view('users/form', [
            'id' => $id,
            'name' => $name,
            'email' => $email,
        ]);
    }

    /**
     * Exibe o formulário de criação de um novo usuário.
     *
     * Esta função:
     * 1. Chama a função privada form() passando valores vazios,
     *    para que o formulário seja exibido em branco.
     */
    public function formData(): void
    {
        $this->form('', '', '');
    }

    /**
     * Processa os dados enviados pelo formulário de usuário.
     *
     * Esta função:
     * 1. Captura os dados enviados (via POST, por exemplo) através da função input().
     * 2. Chama o serviço de usuários para criar ou atualizar o registro.
     * 3. Retorna a resposta em JSON e finaliza a execução do script.
     */
    public function exeData(): void
    {
        $execute = $this->usersService->createOrUpdate($this->input());
        echo json_encode($execute);
        exit;
    }
}