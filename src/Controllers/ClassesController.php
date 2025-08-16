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
    public function delete($params)
    {
        $studentId = base64urlDecode($params[0]);
        $execute = $this->classesService->delete($studentId);
        echo json_encode($execute);
        exit;
    }
}