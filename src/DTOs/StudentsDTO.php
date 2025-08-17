<?php

namespace Src\DTOs;

/**
 * Data Transfer Object (DTO) para a entidade "Students".
 *
 * Esta classe é responsável por receber, sanitizar e validar os dados
 * de um aluno antes de serem processados ou persistidos no banco.
 * Ela ajuda a centralizar a validação e garante que os dados estejam
 * corretos e seguros.
 */
class StudentsDTO
{
    /**
     * Id do aluno.
     *
     * @var string|null
     */
    private $id;

    /**
     * Nome do aluno.
     *
     * @var string|null
     */
    private $name;

    /**
     * Data de Nascimento do aluno.
     *
     * @var string|null
     */
    private $date_of_birth;

    /**
     * CPF do aluno.
     *
     * @var string|null
     */
    private $document;

    /**
     * E-mail do aluno.
     *
     * @var string|null
     */
    private $email;

    /**
     * Senha do aluno.
     *
     * @var string|null
     */
    private $password;

    /**
     * Construtor da classe DTO de Aluno.
     *
     * Esta função inicializa as propriedades do objeto a partir de um array de parâmetros
     * fornecido, aplicando sanitizações específicas em cada campo para garantir segurança
     * e consistência dos dados.
     *
     * Processos realizados para cada campo:
     * - `id`:
     *   - Decodifica o valor do ID caso esteja presente, usando `base64urlDecode`.
     *   - Caso não exista, define como `null`.
     *
     * - `name`:
     *   - Sanitiza a string para conter apenas letras e espaços, usando `sanitizeLettersAndSpaces`.
     *   - Caso não exista, define como `null`.
     *
     * - `date_of_birth`:
     *   - Sanitiza a data como string segura, removendo HTML ou caracteres indesejados com `sanitizeString`.
     *   - Caso não exista, define como `null`.
     *
     * - `document` (CPF ou documento similar):
     *   - Remove tudo que não seja números, usando `sanitizeNumbers`.
     *   - Caso não exista, define como `null`.
     *
     * - `email`:
     *   - Sanitiza a string do e-mail para uso seguro com `sanitizeString`.
     *   - Caso não exista, define como `null`.
     *
     * - `password`:
     *   - Sanitiza a senha como string segura, removendo caracteres indesejados com `sanitizeString`.
     *   - Caso não exista, define como `null`.
     *
     * @param array $params Array associativo contendo os dados do aluno.
     */
    public function __construct(array $params)
    {
        $this->id = isset($params['id']) ? base64urlDecode($params['id']) : null;
        $this->name = isset($params['name']) ? sanitizeLettersAndSpaces($params['name']) : null;
        $this->date_of_birth = isset($params['date_of_birth']) ? sanitizeString($params['date_of_birth']) : null;
        $this->document = isset($params['document']) ? sanitizeNumbers($params['document']) : null;
        $this->email = isset($params['email']) ? sanitizeString($params['email']) : null;
        $this->password = isset($params['password']) ? sanitizeString($params['password']) : null;
    }

    /**
     * Valida os dados de um aluno antes de cadastro ou atualização.
     *
     * Esta função realiza múltiplas validações em sequência, retornando imediatamente caso algum campo não esteja válido:
     *
     * 1. **Nome do aluno**:
     *    - Obrigatório.
     *    - Deve possuir entre 3 e 50 caracteres.
     *
     * 2. **Data de nascimento**:
     *    - Obrigatória.
     *    - O aluno deve ter entre 18 e 80 anos.
     *
     * 3. **CPF**:
     *    - Obrigatório.
     *    - Deve conter exatamente 11 dígitos.
     *    - Validação formal do CPF através da função `validateCpf()`.
     *
     * 4. **E-mail**:
     *    - Obrigatório.
     *    - Deve ser um e-mail válido conforme a função `validateEmail()`.
     *
     * 5. **Senha**:
     *    - Obrigatória.
     *    - Deve atender aos critérios de senha forte (mínimo 8 caracteres, letras maiúsculas e minúsculas, números e símbolos) usando `validateStrongPassword()`.
     *
     * Caso todas as validações sejam bem-sucedidas, a função retorna um array contendo:
     * - 'invalid' => false
     * - 'id', 'name', 'date_of_birth', 'document', 'email'
     * - 'password' => hash seguro da senha usando password_hash()
     *
     * Para qualquer falha, retorna:
     * - 'invalid' => true
     * - 'code' => código de erro ('333')
     * - 'message' => mensagem explicativa da falha.
     *
     * @return array Resultado da validação com dados sanitizados e/ou mensagens de erro.
     */
    public function validate(): array
    {
        $data['invalid'] = false;

        // Validação do nome
        if (empty($this->name)) {
            $data['code'] = '333';
            $data['message'] = 'Informe um dado válido para o nome da aluno.';
            $data['invalid'] = true;
            return $data;
        }

        if (strlen($this->name) < 3) {
            $data['code'] = '333';
            $data['message'] = 'O nome da aluno deve possuir ao menos 3 caracteres.';
            $data['invalid'] = true;
            return $data;
        }

        if (strlen($this->name) > 50) {
            $data['code'] = '333';
            $data['message'] = 'O nome da aluno deve possuir no máximo 50 caracteres.';
            $data['invalid'] = true;
            return $data;
        }


        // Validação da data de nascimento
        if (empty($this->date_of_birth)) {
            $data['code'] = '333';
            $data['message'] = 'Informe uma data de nascimento válida.';
            $data['invalid'] = true;
            return $data;
        }

        $dateMax = date('Y-m-d', strtotime(date("Y-m-d") . "-18 years"));
        $dateMin = date('Y-m-d', strtotime(date("Y-m-d") . "-80 years"));

        if ($this->date_of_birth > $dateMax || $this->date_of_birth < $dateMin) {
            $data['code'] = '333';
            $data['message'] = 'A data de nascimento deve estar entre ' . date('d/m/Y', strtotime($dateMin)) . ' e ' . date('d/m/Y', strtotime($dateMax)) . '.';
            $data['invalid'] = true;
            return $data;
        }

        // Validação do CPF
        if (empty($this->document)) {
            $data['code'] = '333';
            $data['message'] = 'Informe um CPF válido.';
            $data['invalid'] = true;
            return $data;
        }

        if (strlen($this->document) < 11 || strlen($this->document) > 11) {
            $data['code'] = '333';
            $data['message'] = 'O CPF deve possuir exatamente 11 dígitos.';
            $data['invalid'] = true;
            return $data;
        }


        if (validateCpf($this->document) === false) {
            $data['code'] = '333';
            $data['message'] = 'O CPF informado não atende os critérios de validação.';
            $data['invalid'] = true;
            return $data;
        }


        // Validação do e-mail
        if (empty($this->email)) {
            $data['code'] = '333';
            $data['message'] = 'Informe um e-mail válido.';
            $data['invalid'] = true;
            return $data;
        }

        if (validateEmail($this->email) === false) {
            $data['code'] = '333';
            $data['message'] = 'O e-mail informado não atende os critérios de validação.';
            $data['invalid'] = true;
            return $data;
        }

        // Validação da senha
        if (empty($this->password)) {
            $data['code'] = '333';
            $data['message'] = 'Informe uma senha válida.';
            $data['invalid'] = true;
            return $data;
        }

        if (validateStrongPassword($this->password) === false) {
            $data['code'] = '333';
            $data['message'] = 'A senha informada não atende os critérios de validação.';
            $data['invalid'] = true;
            return $data;
        }

        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['date_of_birth'] = $this->date_of_birth;
        $data['document'] = $this->document;
        $data['email'] = $this->email;
        $data['password'] = password_hash($this->password, PASSWORD_DEFAULT);

        return $data;
    }
}