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
     * Exibe o formulário para criação de um novo aluno.
     *
     * Inicializa o formulário com campos vazios, já que se trata
     * de um novo registro e não de edição.
     *
     * @return void
     */
    public function formData(): void
    {
        $this->form('', '', '', '', '');
    }

    /**
     * Carrega a view do formulário de alunos com os dados fornecidos.
     *
     * Esta função é genérica e pode ser utilizada tanto para criação
     * quanto para edição de alunos. Recebe:
     * - $id: ID do aluno (vazio para novo registro)
     * - $name: Nome do aluno
     * - $document: CPF do aluno
     * - $email: E-mail do aluno
     * - $dateOfBirth: Data de Nascimento do aluno
     *
     * @param string $id          ID do aluno
     * @param string $name        Nome do aluno
     * @param string $document CPF do aluno
     * @param string $email E-mail do aluno
     * @param string $dateOfBirth Data de Nascimento do aluno

     * @return void
     */
    private function form($id, $name, $document, $email, $dateOfBirth): void
    {
        $this->view('students/form', [
            'id' => $id,
            'name' => $name,
            'document' => $document,
            'email' => $email,
            'dateOfBirth' => $dateOfBirth,
            'dateMax' => date('Y-m-d', strtotime(date("Y-m-d") . "-18 years")),
            'dateMin' => date('Y-m-d', strtotime(date("Y-m-d") . "-80 years")),

        ]);
    }

    /**
     * Executa o processamento de dados de criação ou atualização de um aluno.
     *
     * Esta função realiza os seguintes passos:
     * 1. Obtém os dados enviados pelo formulário através do método `input()`.
     * 2. Chama o serviço `studentsService->createOrUpdate()` para cadastrar ou atualizar
     *    o aluno com base nos dados fornecidos.
     * 3. Retorna o resultado do processamento em formato JSON, contendo informações
     *    como código de sucesso/erro e mensagens correspondentes.
     * 4. Interrompe a execução do script imediatamente após enviar a resposta.
     *
     * @return void
     */
    public function exeData(): void
    {
        $execute = $this->studentsService->createOrUpdate($this->input());
        echo json_encode($execute);
        exit;
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
    public function delete($params): void
    {
        $studentId = base64urlDecode($params[0]);
        $execute = $this->studentsService->delete($studentId);
        echo json_encode($execute);
        exit;
    }

    /**
     * Prepara e exibe o formulário de edição de um aluno existente.
     *
     * Esta função realiza os seguintes passos:
     * 1. Decodifica o ID do aluno recebido como parâmetro (base64url).
     * 2. Recupera os dados completos do aluno chamando o método `show()`.
     * 3. Chama o método `form()` passando os dados do aluno para preencher os campos do formulário.
     *
     * @param array $params Array contendo o ID do aluno codificado em base64 no índice 0.
     * @return void
     */
    public function formEdit($params): void
    {
        $studentId = base64urlDecode($params[0]);
        $student = $this->show($studentId);
        $this->form($student['id'], $student['name'], $student['document'], $student['email'], $student['date_of_birth']);
    }

    /**
     * Recupera os dados completos de um aluno pelo seu ID.
     *
     * Esta função encapsula a chamada ao serviço responsável por buscar os dados do aluno.
     * Ela é utilizada internamente pelo controller para obter informações antes de exibir formulários
     * ou processar alterações.
     *
     * @param int $studentId ID do aluno a ser recuperado.
     * @return array Array associativo contendo os dados do aluno.
     */
    private function show($studentId): array
    {
        return $this->studentsService->getById($studentId);
    }
}