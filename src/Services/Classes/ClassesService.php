<?php

namespace Src\Services\Classes;

use Src\DTOs\ClassesDTO;
use Src\Repositories\ClassesRepository;

class ClassesService
{
    /**
     * Repositório responsável por operações de banco de dados da tabela de turmas.
     *
     * @var ClassesRepository
     */
    private ClassesRepository $classesRepository;

    /**
     * Construtor da classe ClassesService.
     *
     * Inicializa a instância do repositório de turmas para permitir
     * operações de consulta e manipulação de dados.
     */
    public function __construct()
    {
        $this->classesRepository = new ClassesRepository();
    }

    /**
     * Recupera a lista de todas as turmas ativas e formata os dados para exibição.
     *
     * Processos realizados nesta função:
     * 1. Chama o repositório para obter todas as turmas ativas (`getAll()`).
     * 2. Para cada turma encontrada:
     *    - Codifica o `id` em base64 para segurança ou uso em URLs.
     *    - Mantém o `name` e `description` (limitando a descrição a 15 caracteres).
     *    - Inclui a quantidade de alunos matriculados (`qttStudents`) retornada pelo repositório.
     * 3. Retorna um array com todas as turmas já formatadas para exibição no front-end.
     *
     * @return array Lista de turmas ativas com dados formatados e quantidade de alunos.
     */
    public function index(): array
    {
        $classes = [];
        $data = $this->classesRepository->getClasses();

        if (!empty($data)) {
            foreach ($data as $class) {
                $classes[] = [
                    'id' => $class['id'],
                    'name' => $class['name'],
                    'description' => limitText($class['description'], 20),
                    'qttStudents' => $class['qttStudents'] ?? 0
                ];
            }
        }

        return $classes;
    }

    /**
     * Realiza a exclusão de uma turma utilizando exclusão lógica (soft delete).
     *
     * Esta função é responsável por:
     * 1. Inicializar um array de resultado com um código de erro padrão (`333`) e uma mensagem genérica de falha.
     * 2. Chamar o repositório de turmas (`classesRepository`) para executar a exclusão lógica do registro informado pelo ID.
     *    - A exclusão lógica normalmente atualiza o campo `deleted_at` com a data/hora atual, sem remover fisicamente o registro.
     * 3. Verificar se alguma linha foi afetada pela operação (`$rowAffected > 0`):
     *    - Caso positivo, atualiza o array de resultado com código de sucesso (`111`) e mensagem de confirmação.
     * 4. Retornar o array `$result` contendo:
     *    - `code`    => código do resultado da operação ('111' = sucesso, '333' = erro)
     *    - `message` => mensagem explicativa do resultado
     *
     * @param string $classId ID do turma a ser excluído
     * @return array Array contendo `code` e `message` indicando o resultado da operação
     */
    public function delete(string $classId): array
    {
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao excluir a informação solicitada.';

        $rowAffected = $this->classesRepository->softDelete($classId);

        if ($rowAffected > 0) {
            $result['code'] = '111';
            $result['message'] = 'Informações excluídas com sucesso.';
        }

        return $result;
    }

    /**
     * Cria ou atualiza uma turma no banco de dados a partir dos parâmetros fornecidos.
     *
     * Fluxo de execução:
     * 1. Inicializa um array padrão de retorno ($result) com código de erro "333"
     *    e mensagem genérica de falha.
     * 2. Instancia um DTO (Data Transfer Object) de turmas com os parâmetros recebidos.
     * 3. Executa a validação dos dados do DTO:
     *    - Caso inválido, retorna imediatamente os erros de validação.
     * 4. Se os dados forem válidos, delega a persistência ao repositório
     *    chamando o método `register()`, que pode criar ou atualizar o registro.
     * 5. Caso a operação afete pelo menos uma linha no banco, redefine o retorno
     *    com código de sucesso "111" e mensagem de confirmação.
     *
     * @param array $params Parâmetros de entrada para criação/atualização (ex.: id, name, description, etc.).
     * @return array Estrutura de retorno contendo:
     *               - 'code' (string): código de status da operação ("111" para sucesso, "333" para falha).
     *               - 'message' (string): mensagem descritiva do resultado.
     *               - Em caso de falha de validação, pode retornar estrutura customizada do DTO.
     */
    public function createOrUpdate(array $params)
    {
        $result = [];
        $result['code'] = '333';
        $result['message'] = 'Houve um erro ao atualizar a informação solicitada.';

        $dto = new ClassesDTO($params);
        $validate = $dto->validate();

        if ($validate['invalid']) {
            return $validate;
        }

        $rowAffected = $this->classesRepository->register($validate);


        if ($rowAffected > 0) {
            $result['code'] = '111';
            $result['message'] = 'Informação atualizada com sucesso.';
            $result['redirect'] = BASE_URL . '/classes';
        }

        return $result;
    }

    /**
     * Recupera uma turma pelo seu identificador.
     *
     * Processos realizados nesta função:
     * 1. Chama o repositório de turmas para buscar os dados da turma com base no ID informado.
     * 2. Codifica o campo `id` em Base64URL para maior segurança e uso em URLs.
     * 3. Retorna os dados formatados em um array associativo contendo:
     *    - id (codificado em Base64URL),
     *    - name (nome da turma),
     *    - description (descrição da turma).
     *
     * @param int|string $classId Identificador da turma (pode ser inteiro ou string, dependendo da origem).
     * @return array Dados da turma formatados e prontos para exibição ou transporte.
     */
    public function getById($classId): array
    {
        $data = $this->classesRepository->getClasses($classId);

        return [
            'id' => base64urlEncode($data[0]['id']),
            'name' => $data[0]['name'],
            'description' => $data[0]['description'],
        ];
    }
}