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
            // Auth
            '/login' => 'UsersController@login',
            '/logout' => 'UsersController@logout',
            '/exeLogin' => 'UsersController@exeLogin',
            // Alunos
            '/students' => 'StudentsController@index',
            '/dataStudents' => 'StudentsController@formData',
            '/editStudents/{params}' => 'StudentsController@formEdit',
            '/exeDataStudents' => 'StudentsController@exeData',
            '/deleteStudent/{params}' => 'StudentsController@delete',
            // Turmas
            '/classes' => 'ClassesController@index',
            '/dataClasses' => 'ClassesController@formData',
            '/editClasses/{params}' => 'ClassesController@formEdit',
            '/exeDataClasses' => 'ClassesController@exeData',
            '/deleteClasses/{params}' => 'ClassesController@delete',
            // Matrículas
            '/registrations' => 'RegistrationsController@index',
            '/newRegistration/{params}' => 'RegistrationsController@newRegistration',
            '/exeDataRegistrations' => 'RegistrationsController@exeData',
            '/registrations/{params}' => 'RegistrationsController@search',
            // Relatórios
            '/reports' => 'ReportsController@index',
        ];
    }
}
