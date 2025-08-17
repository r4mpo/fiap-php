<?php

namespace Src\DTOs;

/**
 * Data Transfer Object (DTO) para a entidade "Classes".
 *
 * Esta classe é responsável por receber, sanitizar e validar os dados
 * de uma turma antes de serem processados ou persistidos no banco.
 * Ela ajuda a centralizar a validação e garante que os dados estejam
 * corretos e seguros.
 */
class ClassesDTO
{
    /**
     * Nome da turma.
     *
     * @var string|null
     */
    private $name;

    /**
     * Descrição da turma.
     *
     * @var string|null
     */
    private $description;

    /**
     * Construtor da classe.
     *
     * Recebe um array de parâmetros e sanitiza os valores de 'name' e 'description'
     * usando a função `sanitizeString` para evitar HTML e caracteres perigosos.
     *
     * @param array $params Array associativo contendo 'name' e 'description'.
     */
    public function __construct($params)
    {
        $this->name = isset($params['name']) ? sanitizeString($params['name']) : null;
        $this->description = isset($params['description']) ? sanitizeString($params['description']) : null;
    }

    /**
     * Valida os campos da turma.
     *
     * Esta função realiza as seguintes validações:
     * 1. Verifica se o nome está presente.
     * 2. Verifica se a descrição está presente.
     * 3. Verifica o tamanho mínimo e máximo do nome (3 a 20 caracteres).
     * 4. Verifica o tamanho mínimo e máximo da descrição (3 a 100 caracteres).
     *
     * Retorna um array com:
     * - 'invalid' => boolean indicando se há erro.
     * - 'code' => código da validação (ex.: '333' para erro).
     * - 'message' => mensagem explicativa do erro.
     *
     * @return array Resultado da validação contendo 'invalid', 'code' e 'message'.
     */
    public function validate()
    {
        $data['invalid'] = false;

        if (empty($this->name)) {
            $data['code'] = '333';
            $data['message'] = 'Informe um dado válido para o nome da turma.';
            $data['invalid'] = true;
            return $data;
        }

        if (empty($this->description)) {
            $data['code'] = '333';
            $data['message'] = 'Informe um dado válido para a descrição da turma.';
            $data['invalid'] = true;
            return $data;
        }

        if (strlen($this->name) < 3) {
            $data['code'] = '333';
            $data['message'] = 'O nome da turma deve possuir ao menos 3 caracteres.';
            $data['invalid'] = true;
            return $data;
        }

        if (strlen($this->name) > 20) {
            $data['code'] = '333';
            $data['message'] = 'O nome da turma deve possuir no máximo 20 caracteres.';
            $data['invalid'] = true;
            return $data;
        }

        if (strlen($this->description) < 3) {
            $data['code'] = '333';
            $data['message'] = 'A descrição da turma deve possuir ao menos 3 caracteres.';
            $data['invalid'] = true;
            return $data;
        }

        if (strlen($this->description) > 100) {
            $data['code'] = '333';
            $data['message'] = 'A descrição da turma deve possuir no máximo 100 caracteres.';
            $data['invalid'] = true;
            return $data;
        }

        return $data;
    }
}