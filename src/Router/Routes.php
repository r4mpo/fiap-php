<?php

namespace Src\Router;

class Routes
{
    /**
     * Retorna todas as rotas definidas no sistema.
     *
     * O array retornado mapeia caminhos de URL para controladores e métodos.
     *
     * @return array<string, string> Array associativo no formato:
     *                               'rota' => 'Controlador@método'
     */
    public static function all(): array
    {
        return [
            '/' => 'HomeController@index',
            // Usuários
            '/login' => 'UsersController@login',
            '/logout' => 'UsersController@logout',
            '/exeLogin' => 'UsersController@exeLogin',
            // Alunos
            '/students' => 'StudentsController@index',
            '/deleteStudent/{params}' => 'StudentsController@delete',
            // Turmas
            '/classes' => 'ClassesController@index',
            // Matrículas
            '/registrations' => 'RegistrationsController@index',
            '/registrations/{params}' => 'RegistrationsController@search',
        ];
    }
}