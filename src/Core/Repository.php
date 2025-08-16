<?php

namespace Src\Core;

use Src\Controllers\ErrorsController;
use PDO;
use PDOException;

class Repository
{
    // Credenciais do banco de dados
    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;
    private $db_name = DB_NAME;
    // Nome do modelo utilizado nas operações
    private $model;

    /**
     * Define o nome do modelo que será usada nas operações do repositório.
     *
     * @param string $model Nome do modelo
     * @return void
     */
    protected function setModel(object $model): void
    {
        $this->model = $model;
    }

    /**
     * Estabelece a conexão com o banco de dados usando PDO.
     *
     * Caso não consiga conectar, redireciona para a tela de erro mostrando
     * detalhes do servidor, base de dados, usuário e a mensagem de exceção.
     *
     * @return PDO Instância PDO da conexão
     */
    protected function getConnection(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:dbname=$this->db_name;host=$this->db_host",
                $this->db_user,
                $this->db_pass
            );
            return $pdo;
        } catch (PDOException $e) {
            // Cria uma instância do controller de erros e exibe a mensagem
            $newController = new ErrorsController();
            $newController->showMessage(
                'Não foi possível se conectar a uma base de dados com as informações fornecidas' . '<br>'
                . '<li> Servidor: ' . $this->db_host . '</li>'
                . '<li> Base de Dados: ' . $this->db_name . '</li>'
                . '<li> Usuário: ' . $this->db_user . '</li>'
                . '<li> Senha: ' . $this->db_pass . '</li>'
                . '<li> Mensagem: ' . $e->getMessage() . '</li>'
            );
            exit;
        }
    }

    /**
     * Realiza uma consulta SELECT na tabela definida.
     *
     * O array $params permite definir:
     * - 'FIELDS'  => campos que deseja selecionar (default: '*')
     * - 'FILTER'  => array de filtros no formato ['campo' => 'valor']
     * - ORDERBY   => string contendo o valor de ordenação ['ex.: id DESC ']
     *
     * Observações:
     * - Se FILTER estiver vazio, retorna todos os registros.
     * - Atualmente concatena valores diretamente na query (atenção: SQL Injection!)
     *
     * @param array $params Parâmetros da consulta ['FIELDS' => 'campos', 'FILTER' => ['campo' => 'valor']]
     * @return array Array associativo com os resultados da consulta
     */
    protected function consult($params): array
    {
        // Monta os campos a serem selecionados
        $query = 'SELECT ';
        $query .= !empty($params) && isset($params['FIELDS']) ? $params['FIELDS'] : '*';
        $query .= ' FROM ' . $this->model->getTable();

        // Monta filtros WHERE se existirem
        if (!empty($params) && isset($params['FILTER'])) {
            $query .= ' WHERE ';
            foreach ($params['FILTER'] as $field => $value) {
                $end = end($params['FILTER']) == $value;
                $query .= $field . (!empty($value) ? (' = ' . '"' . $value . '"') : '') . ($end ? '' : ' AND ');
            }
        }

        // Define se haverá alguma ordenação para a query
        $query .= !empty($params) && isset($params['ORDERBY']) ? (' ORDER BY ' . $params['ORDERBY']) : '';

        // Executa a query diretamente
        $stmt = $this->getConnection()->query($query);

        // Retorna os resultados como array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }
}
