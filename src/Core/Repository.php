<?php

namespace Src\Core;

use Src\Controllers\ErrorsController;
use PDO;
use PDOException;

class Repository
{
    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;
    private $db_name = DB_NAME;

    public function getConnection(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:dbname=$this->db_name;host=$this->db_host", $this->db_user, $this->db_pass
            );
            return $pdo;
        } catch (PDOException $e) {
            $newController = new ErrorsController();
            $newController->showMessage(
                'Não foi possível se conectar a uma base de dados com as informações fornecidas' . '<br>'
                . 'Servidor: ' . $this->db_host . '<br>'
                . 'Base de Dados: ' . $this->db_name . '<br>'
                . 'Usuário: ' . $this->db_user . '<br>'
                . 'Senha: ' . $this->db_pass . '<br>'
            );
            exit;
        }
    }
}
