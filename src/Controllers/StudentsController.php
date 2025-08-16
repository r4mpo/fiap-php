<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Students\StudentsService;

class StudentsController extends Controller
{
    private StudentsService $studentsService;

    /**
     * Construtor da classe.
     * Inicializa a instância de StudentsService para gerenciar o CRUD de Alunos.
     */
    public function __construct()
    {
        $this->studentsService = new StudentsService();
    }

    /**
     * Exibe a lista de alunos cadastrados no sistema.
     *
     * Esta função é responsável por:
     * 1. Recuperar todos os registros de alunos utilizando o serviço `studentsService`.
     * 2. Passar os dados obtidos para a view `students/index`.
     *
     * O array enviado para a view contém:
     * - 'students': uma lista de alunos com seus respectivos dados.
     *
     * @return void
     */
    public function index(): void
    {
        $data = $this->studentsService->index();
        $this->view('students/index', [
            'students' => $data
        ]);
    }

    /**
     * Controlador para excluir um aluno específico.
     *
     * Esta função é responsável por:
     * 1. Receber parâmetros da requisição, onde o primeiro elemento ($params[0])
     *    é o ID do aluno codificado em Base64 URL-safe.
     * 2. Decodificar o ID do aluno usando a função `base64urlDecode`.
     * 3. Chamar o serviço de alunos (`studentsService->delete`) para executar
     *    a exclusão lógica (soft delete) do registro.
     * 4. Retornar o resultado da operação em formato JSON para o cliente.
     *    - A resposta normalmente contém:
     *      - `code`    => código do resultado ('111' = sucesso, '333' = erro)
     *      - `message` => mensagem explicativa
     * 5. Interrompe a execução do script imediatamente após enviar a resposta (`exit`).
     *
     * @param array $params Parâmetros recebidos da rota, sendo o primeiro o ID do aluno codificado
     * @return void Retorna resposta JSON diretamente ao cliente
     */
    public function delete($params)
    {
        $studentId = base64urlDecode($params[0]);
        $execute = $this->studentsService->delete($studentId);
        echo json_encode($execute);
        exit;
    }
}
