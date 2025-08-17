<?php

namespace Src\Repositories;

use Src\Core\Repository;
use Src\Models\Students;

class StudentsRepository extends Repository
{
    /**
     * Construtor da classe.
     *
     * Define a tabela padrão que será utilizada pelo repositório de alunos.
     */
    public function __construct()
    {
        $studentsModel = new Students();
        $this->setModel($studentsModel);
    }

    /**
     * Recupera todos os alunos ativos do sistema, com possibilidade de filtros adicionais.
     *
     * Esta função monta os parâmetros necessários para consultar a base de dados,
     * retornando apenas os alunos que não foram deletados (`deleted_at IS NULL`).
     * Caso sejam fornecidos filtros adicionais, eles serão aplicados à consulta.
     *
     * Parâmetros da consulta:
     * - FILTER: aplica filtro para selecionar apenas registros ativos e outros filtros opcionais.
     * - FIELDS: define os campos a serem retornados: `id`, `name`, `date_of_birth`, `document` e `email`.
     * - ORDERBY: ordena os resultados pelo campo `name` em ordem crescente.
     *
     * Processos realizados:
     * 1. Define o filtro padrão para alunos ativos.
     * 2. Define os campos a serem retornados.
     * 3. Aplica quaisquer filtros adicionais passados via parâmetro `$filters`.
     * 4. Chama o método `consult()` do repositório para executar a query e obter os resultados.
     *
     * @param array $filters (opcional) Array associativo de filtros adicionais no formato ['campo' => 'valor'].
     * @return array Lista de alunos ativos, cada item contendo os campos especificados.
     */
    public function getAll(array $filters = []): array
    {
        $params = [];
        $params['FILTER']['deleted_at IS NULL'] = NULL;
        $params['FIELDS'] = 'id, name, date_of_birth, document, email';
        $params['ORDERBY'] = 'name ASC';

        // Se filtros adicionais forem passados, adiciona ao array de parâmetros
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $params['FILTER'][$key] = $value;
            }
        }

        // Chama o método consult() do Repository para executar a query
        return $this->consult($params);
    }

    /**
     * Realiza uma exclusão lógica (soft delete) de um registro de aluno.
     *
     * Esta função não remove fisicamente o registro do banco de dados, mas
     * atualiza o campo `deleted_at` com a data e hora atual, indicando que o
     * registro foi "excluído".
     *
     * Passos realizados nesta função:
     * 1. Cria um array `$params` que define os parâmetros para o método `alter`:
     *    - `FILTER` => define qual registro será alterado, usando o ID do aluno.
     *    - `SET`    => define os campos que serão atualizados; neste caso, apenas `deleted_at`.
     * 2. Chama o método `alter($params)` do repositório, que executa o UPDATE no banco.
     * 3. Retorna o resultado da operação, normalmente o número de linhas afetadas.
     *
     * @param string $studentId ID do aluno a ser excluído logicamente
     * @return int Número de linhas afetadas pela operação (0 se nenhum registro foi alterado)
     */
    public function softDelete(string $studentId): int
    {
        $params = [];
        $params['FILTER']['id'] = $studentId;
        $params['SET']['deleted_at'] = date('Y-m-d H:i:s');

        return $this->alter($params);
    }

    /**
     * Registra ou atualiza um aluno no banco de dados.
     *
     * Esta função recebe um array de campos contendo os dados do aluno e decide se deve
     * criar um novo registro ou atualizar um existente, com base na presença do campo 'id'.
     *
     * Processos realizados:
     * 1. Monta o array `$params['SET']` com os campos a serem inseridos/atualizados:
     *    - `name`          => Nome do aluno.
     *    - `date_of_birth` => Data de nascimento do aluno.
     *    - `document`      => CPF ou documento do aluno (apenas números).
     *    - `email`         => E-mail do aluno.
     *    - `password`      => Senha do aluno (hash já gerado anteriormente).
     *    - `updated_at`    => Data e hora da atualização (atual timestamp).
     *
     * 2. Verifica se existe o campo 'id' no array `$fields`:
     *    - Se existir, monta `$params['FILTER']['id']` e chama o método `alter()` para atualizar o registro existente.
     *    - Se não existir, chama o método `insert()` para criar um novo registro no banco de dados.
     *
     * @param array $fields Array associativo contendo os dados do aluno.
     * @return int Número de linhas afetadas pelo insert ou update.
     */
    public function register(array $fields): int
    {
        $params = [];
        $params['SET']['name'] = $fields['name'];
        $params['SET']['date_of_birth'] = $fields['date_of_birth'];
        $params['SET']['document'] = $fields['document'];
        $params['SET']['email'] = $fields['email'];
        $params['SET']['password'] = $fields['password'];
        $params['SET']['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($fields['id'])) {
            $params['FILTER']['id'] = $fields['id'];
            return $this->alter($params);
        }

        return $this->insert($params);
    }
}