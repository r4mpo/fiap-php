<?php

namespace Test;

// Carrega o arquivo de funções que será utilizado no projeto
require __DIR__ . '/../config/functions.php';

use PHPUnit\Framework\TestCase;
use Src\Services\Students\StudentsService;

class StudentsServiceTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();

        if (!defined('BASE_URL'))
            define('BASE_URL', 'http://localhost/fiap-php');
        if (!defined('DB_HOST'))
            define('DB_HOST', 'localhost');
        if (!defined('DB_USER'))
            define('DB_USER', 'root');
        if (!defined('DB_PASS'))
            define('DB_PASS', '');
        if (!defined('DB_NAME'))
            define('DB_NAME', 'fiap_php_db');
    }

    public function testCreateStudentSucess()
    {
        $params = [
            'name' => 'Aluno Teste',
            'date_of_birth' => '2000-01-01',
            'document' => '19017533013',
            'email' => 'alunotest@gmail.com',
            'password' => 'Aa123#_!'
        ];

        $service = new StudentsService();
        $actual = $service->createOrUpdate($params);

        $expected = [
            'code' => '111',
            'message' => 'Informação atualizada com sucesso.',
            'redirect' => BASE_URL . '/students',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testCreateStudentWithEmptyName()
    {
        $params = [
            'name' => '',
            'date_of_birth' => '2000-01-01',
            'document' => '19017533013',
            'email' => 'teste@teste.com',
            'password' => 'Aa123#_!',
        ];

        $service = new StudentsService();
        $actual = $service->createOrUpdate($params);

        $expected = [
            'code' => '333',
            'message' => 'Informe um dado válido para o nome da aluno.',
            'invalid' => true,
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testCreateStudentWithShortName()
    {
        $params = [
            'name' => 'A',
            'date_of_birth' => '2000-01-01',
            'document' => '19017533013',
            'email' => 'teste@teste.com',
            'password' => 'Aa123#_!',
        ];

        $service = new StudentsService();
        $actual = $service->createOrUpdate($params);

        $expected = [
            'code' => '333',
            'message' => 'O nome da aluno deve possuir ao menos 3 caracteres.',
            'invalid' => true,
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testCreateStudentWithInvalidCpf()
    {
        $params = [
            'name' => 'Aluno Teste',
            'date_of_birth' => '2000-01-01',
            'document' => '123', // CPF inválido
            'email' => 'teste@teste.com',
            'password' => 'Aa123#_!',
        ];

        $service = new StudentsService();
        $actual = $service->createOrUpdate($params);

        $expected = [
            'code' => '333',
            'message' => 'O CPF deve possuir exatamente 11 dígitos.',
            'invalid' => true,
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testCreateStudentWithInvalidEmail()
    {
        $params = [
            'name' => 'Aluno Teste',
            'date_of_birth' => '2000-01-01',
            'document' => '19017533013',
            'email' => 'email_invalido',
            'password' => 'Aa123#_!',
        ];

        $service = new StudentsService();
        $actual = $service->createOrUpdate($params);

        $expected = [
            'code' => '333',
            'message' => 'O e-mail informado não atende os critérios de validação.',
            'invalid' => true,
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testCreateStudentWithWeakPassword()
    {
        $params = [
            'name' => 'Aluno Teste',
            'date_of_birth' => '2000-01-01',
            'document' => '19017533013',
            'email' => 'teste@teste.com',
            'password' => '123456', // senha fraca
        ];

        $service = new StudentsService();
        $actual = $service->createOrUpdate($params);

        $expected = [
            'code' => '333',
            'message' => 'A senha informada não atende os critérios de validação.',
            'invalid' => true,
        ];

        $this->assertEquals($expected, $actual);
    }
}