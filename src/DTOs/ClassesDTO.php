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
     * Id da turma.
     *
     * @var string|null
     */
    private $id;

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
    public function __construct(array $params)
    {
        $this->id = isset($params['id']) ? sanitizeString($params['id']) : null;
        $this->name = isset($params['name']) ? sanitizeString($params['name']) : null;
        $this->description = isset($params['description']) ? sanitizeString($params['description']) : null;
    }

    /**
     * Valida os campos de uma turma e retorna os dados validados.
     *
     * Esta função realiza as seguintes validações:
     * 1. Verifica se o id da turma está presente.
     * 2. Verifica se o nome da turma está presente.
     * 3. Verifica se a descrição da turma está presente.
     * 4. Verifica se o tamanho do nome está entre 3 e 20 caracteres.
     * 5. Verifica se o tamanho da descrição está entre 3 e 100 caracteres.
     *
     * Retorna um array contendo:
     * - 'invalid' => boolean indicando se ocorreu algum erro de validação.
     * - 'code' => código da validação (ex.: '333' para erro; ausente em caso de sucesso).
     * - 'message' => mensagem explicativa do erro (ausente em caso de sucesso).
     * - 'name' => valor do nome da turma (retornado apenas se válido).
     * - 'description' => valor da descrição da turma (retornado apenas se válido).
     *
     * @return array Resultado da validação com informações de erro ou os dados validados.
     */
    public function validate(): array
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

        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['description'] = $this->description;
        return $data;
    }
}