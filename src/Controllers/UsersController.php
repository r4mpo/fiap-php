<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Users\LoginService;

class UsersController extends Controller
{
    private LoginService $loginService;

    /**
     * Construtor da classe.
     * Inicializa a instância de LoginService para gerenciar a autenticação de usuários.
     */
    public function __construct()
    {
        $this->loginService = new LoginService();
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
     * Deve encerrar a sessão e redirecionar para a página de login
     * (ainda não implementado).
     *
     * @return void
     */
    public function logout(): void
    {
        // Implementar lógica de logout (ex: destruir sessão e redirecionar)
    }
}