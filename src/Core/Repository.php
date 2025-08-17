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
     * - GROUPBY   => string contendo preferência de agrupamento ['ex.: model.id']
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

        // Monta agfrupamentos JOIN se existirem
        if (!empty($params) && isset($params['JOIN'])) {
            $query .= count($params['JOIN']) == 1 ? ' ' : '';
            foreach ($params['JOIN'] as $value) {
                $end = end($params['JOIN']) == $value;
                $query .= ($end ? '' : ' ') . $value['TYPE'] . ' JOIN ' . $value['TABLE'] . ' ON ' . $value['CONDITIONS'] . ($end ? '' : ' ');
            }
        }

        // Monta filtros WHERE se existirem
        if (!empty($params) && isset($params['FILTER'])) {
            $query .= ' WHERE ';
            foreach ($params['FILTER'] as $field => $value) {
                $end = array_key_last($params['FILTER']) == $field;
                $query .= $field . (!empty($value) ? (' = ' . '"' . $value . '"') : '') . ($end ? '' : ' AND ');
            }
        }

        // Define se haverá algum agrupamento para a query
        $query .= !empty($params) && isset($params['GROUPBY']) ? (' GROUP BY ' . $params['GROUPBY']) : '';

        // Define se haverá alguma ordenação para a query
        $query .= !empty($params) && isset($params['ORDERBY']) ? (' ORDER BY ' . $params['ORDERBY']) : '';

        // Define se haverá alguma limitação para a query
        $query .= !empty($params) && isset($params['LIMIT']) ? (' LIMIT ' . $params['LIMIT']) : '';

        // Executa query
        return $this->select($query);
    }

    /**
     * Atualiza registros na tabela do modelo utilizando parâmetros genéricos.
     *
     * Esta função é responsável por construir e executar uma query UPDATE baseada
     * nos arrays de parâmetros fornecidos:
     * - 'SET'    => campos e valores que serão atualizados
     * - 'FILTER' => condições para definir quais registros serão alterados (WHERE)
     *
     * Passos realizados:
     * 1. Monta a cláusula SET com os campos e valores fornecidos.
     * 2. Monta a cláusula WHERE com os filtros fornecidos.
     * 3. Chama o método `insertOrAlter()` para executar a query e retorna o número de linhas afetadas.
     *
     * Atenção: atualmente concatena valores diretamente na query (atenção com SQL Injection!).
     *
     * @param array $params Array com chaves 'SET' e 'FILTER'
     * @return int Número de linhas afetadas pela atualização
     */
    protected function alter(array $params)
    {
        $query = 'UPDATE ' . $this->model->getTable();

        // Monta os campos a serem atualizados
        if (!empty($params) && isset($params['SET'])) {
            $query .= ' SET ';
            foreach ($params['SET'] as $field => $value) {
                $end = end($params['SET']) == $value;
                $query .= $field . (!empty($value) ? (' = ' . '"' . $value . '"') : '') . ($end ? '' : ', ');
            }
        }

        // Monta filtros WHERE se existirem
        if (!empty($params) && isset($params['FILTER'])) {
            $query .= ' WHERE ';
            foreach ($params['FILTER'] as $field => $value) {
                $end = array_key_last($params['FILTER']) == $field;
                $query .= $field . (!empty($value) ? (' = ' . '"' . $value . '"') : '') . ($end ? '' : ' AND ');
            }
        }

        // Executa a query e retorna o número de linhas afetadas
        return $this->insertOrAlter($query);
    }

    /**
     * Monta e executa dinamicamente uma query de inserção (INSERT) na tabela definida pelo model.
     *
     * Funcionamento:
     * 1. Define a query base no formato: INSERT INTO {nome_tabela}.
     * 2. Caso existam dados em $params['SET']:
     *    - Extrai as chaves do array como nomes das colunas.
     *    - Monta a lista de valores, escapando cada valor com `addslashes()` e colocando entre aspas simples.
     *    - Concatena colunas e valores ao comando SQL.
     *
     * 3. Caso existam filtros em $params['FILTER']:
     *    - Adiciona uma cláusula WHERE (apesar de incomum em um INSERT),
     *      permitindo inserir condicionado a algum critério adicional.
     *    - Monta cada condição no formato `{coluna} = "valor"` unidas por AND.
     *
     * 4. Por fim, executa a query completa através do método `insertOrAlter()`
     *    e retorna a quantidade de linhas afetadas no banco.
     *
     * @param array $params Estrutura de dados contendo:
     *   - 'SET'    => [coluna => valor]  (campos a inserir).
     *   - 'FILTER' => [coluna => valor]  (condições opcionais).
     * @return int Número de linhas afetadas pela operação.
     */
    protected function insert(array $params)
    {
        $query = 'INSERT INTO ' . $this->model->getTable();

        // Monta os campos a serem cadastrados
        if (!empty($params) && isset($params['SET'])) {
            // Colunas
            $columns = array_keys($params['SET']);
            $query .= '(' . implode(',', $columns) . ')';

            // Valores (cada valor entre aspas simples e escapado)
            $values = array_map(function ($value) {
                return "'" . addslashes($value) . "'";
            }, $params['SET']);

            $query .= ' VALUES (' . implode(',', $values) . ')';
        }

        // Monta filtros WHERE se existirem
        if (!empty($params) && isset($params['FILTER'])) {
            $query .= ' WHERE ';
            foreach ($params['FILTER'] as $field => $value) {
                $end = array_key_last($params['FILTER']) == $field;
                $query .= $field . (!empty($value) ? (' = ' . '"' . $value . '"') : '') . ($end ? '' : ' AND ');
            }
        }

        // Executa a query e retorna o número de linhas afetadas
        return $this->insertOrAlter($query);
    }


    /**
     * Executa uma query SELECT e retorna os resultados como array associativo.
     *
     * Esta função é usada para consultas que retornam dados, como SELECT.
     * Ela utiliza PDO para executar a query e `fetchAll(PDO::FETCH_ASSOC)` para
     * retornar os resultados em formato de array associativo.
     *
     * @param string $query SQL SELECT a ser executada
     * @return array Array associativo com os resultados da consulta
     */
    private function select($query): array
    {
        $stmt = $this->getConnection()->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    /**
     * Executa uma query de INSERT ou UPDATE e retorna o número de linhas afetadas.
     *
     * Esta função é utilizada para operações que não retornam dados, mas modificam
     * registros na tabela (INSERT, UPDATE ou DELETE).
     * Retorna a quantidade de registros alterados, permitindo verificar o sucesso da operação.
     *
     * @param string $query SQL a ser executada (INSERT, UPDATE ou DELETE)
     * @return int Número de linhas afetadas pela query
     */
    private function insertOrAlter($query): int
    {
        $stmt = $this->getConnection()->query($query);
        return $stmt->rowCount();
    }
}
