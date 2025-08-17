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

    public function index(): void
    {
        $users = $this->usersService->index();
        $this->view('users/index', ['users' => $users]);
    }

    public function formEdit($params): void
    {
        $userId = base64urlDecode($params[0]);
        $user = $this->show($userId);
        $this->form($user[0]['id'], $user[0]['name'], $user[0]['email']);
    }

    private function show($userId): array
    {
        return $this->usersService->getUserById($userId);
    }

    private function form($id, $name, $email): void
    {
        $this->view('users/form', [
            'id' => $id,
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function formData(): void
    {
        $this->form('', '', '');
    }

    public function exeData(): void
    {
        $execute = $this->usersService->createOrUpdate($this->input());
        echo json_encode($execute);
        exit;
    }
}