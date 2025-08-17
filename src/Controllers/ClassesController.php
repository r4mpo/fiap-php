<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Classes\ClassesService;

class ClassesController extends Controller
{
    private ClassesService $classesService;

    /**
     * Construtor da classe.
     * Inicializa a instância de ClassesService para gerenciar o CRUD de Turmas.
     */
    public function __construct()
    {
        $this->classesService = new ClassesService();
    }

    /**
     * Exibe a lista de turmas cadastradas no sistema.
     *
     * Esta função é responsável por:
     * 1. Recuperar todos os registros de turmas utilizando o serviço `classesService`.
     * 2. Passar os dados obtidos para a view `classes/index`.
     *
     * O array enviado para a view contém:
     * - 'classes': uma lista de turmas com seus respectivos dados.
     *
     * @return void
     */
    public function index(): void
    {
        $data = $this->classesService->index();
        $this->view('classes/index', [
            'classes' => $data
        ]);
    }

    /**
     * Exibe o formulário para criação de uma nova turma.
     *
     * Inicializa o formulário com campos vazios, já que se trata
     * de um novo registro e não de edição.
     *
     * @return void
     */
    public function formData(): void
    {
        $this->form('', '', '');
    }

    /**
     * Executa o processamento de dados de criação ou atualização de uma turma.
     *
     * Esta função realiza os seguintes passos:
     * 1. Obtém os dados enviados pelo formulário através do método `input()`.
     * 2. Chama o serviço `classesService->createOrUpdate()` para cadastrar ou atualizar
     *    a turma com base nos dados fornecidos.
     * 3. Retorna o resultado do processamento em formato JSON, contendo informações
     *    como código de sucesso/erro e mensagens correspondentes.
     * 4. Interrompe a execução do script imediatamente após enviar a resposta.
     *
     * @return void
     */
    public function exeData(): void
    {
        $execute = $this->classesService->createOrUpdate($this->input());
        echo json_encode($execute);
        exit;
    }

    /**
     * Carrega a view do formulário de turmas com os dados fornecidos.
     *
     * Esta função é genérica e pode ser utilizada tanto para criação
     * quanto para edição de turmas. Recebe:
     * - $id: ID da turma (vazio para novo registro)
     * - $name: Nome da turma
     * - $description: Descrição da turma
     *
     * @param string $id          ID da turma
     * @param string $name        Nome da turma
     * @param string $description Descrição da turma
     * @return void
     */
    private function form($id, $name, $description): void
    {
        $this->view('classes/form', [
            'id' => $id,
            'name' => $name,
            'description' => $description,
        ]);
    }

    /**
     * Controlador para excluir uma turma específica.
     *
     * Esta função é responsável por:
     * 1. Receber parâmetros da requisição, onde o primeiro elemento ($params[0])
     *    é o ID da turma codificado em Base64 URL-safe.
     * 2. Decodificar o ID da turma usando a função `base64urlDecode`.
     * 3. Chamar o serviço da turmas (`classesService->delete`) para executar
     *    a exclusão lógica (soft delete) do registro.
     * 4. Retornar o resultado da operação em formato JSON para o cliente.
     *    - A resposta normalmente contém:
     *      - `code`    => código do resultado ('111' = sucesso, '333' = erro)
     *      - `message` => mensagem explicativa
     * 5. Interrompe a execução do script imediatamente após enviar a resposta (`exit`).
     *
     * @param array $params Parâmetros recebidos da rota, sendo o primeiro o ID da turma codificado
     * @return void Retorna resposta JSON diretamente ao cliente
     */
    public function delete($params): void
    {
        $classId = base64urlDecode($params[0]);
        $execute = $this->classesService->delete($classId);
        echo json_encode($execute);
        exit;
    }

    /**
     * Exibe o formulário de edição de uma turma.
     *
     * Processos realizados nesta função:
     * 1. Decodifica o identificador da turma (ID) recebido nos parâmetros da URL usando Base64URL.
     * 2. Busca os dados completos da turma através do método `show`.
     * 3. Chama o método `form` para renderizar o formulário de edição,
     *    já preenchido com os dados da turma (id, nome e descrição).
     *
     * @param array $params Parâmetros recebidos (espera-se que o primeiro elemento seja o ID codificado).
     * @return void
     */
    public function formEdit($params): void
    {
        $classId = base64urlDecode($params[0]);
        $class = $this->show($classId);
        $this->form($class['id'], $class['name'], $class['description']);
    }

    /**
     * Recupera os dados de uma turma específica.
     *
     * Este método é um "atalho" que delega a chamada ao service `classesService`,
     * garantindo que os dados da turma sejam retornados já no formato adequado.
     *
     * @param int|string $classId Identificador único da turma.
     * @return array Dados da turma (id, name, description).
     */
    private function show($classId): array
    {
        return $this->classesService->getById($classId);
    }
}