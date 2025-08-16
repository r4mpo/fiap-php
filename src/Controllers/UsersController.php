<?php

namespace Src\Controllers;

use Src\Core\Controller;

class UsersController extends Controller
{
    public function login(): void
    {
        $this->view('users/loginForm', []);
    }

    public function logout() {
        // 
    }
}
