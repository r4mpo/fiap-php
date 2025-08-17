<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Registrations\RegistrationsService;

class RegistrationsController extends Controller
{
    /**
     * Serviço responsável pelas operações de negócio relacionadas às matrículas.
     *
     * @var RegistrationsService
     */
    private RegistrationsService $registrationsService;

    /**
     * Construtor da classe RegistrationsController.
     *
     * Inicializa a instância de `RegistrationsService`, permitindo que o controller
     * utilize os métodos de negócio para gerenciar as matrículas.
     */
    public function __construct()
    {
        $this->registrationsService = new RegistrationsService();
    }

    /**
     * Exibe a lista de turmas disponíveis no sistema.
     *
     * Processos realizados neste método:
     * 1. Recupera todas as turmas através do serviço `RegistrationsService`.
     * 2. Envia os dados obtidos para a view `registrations/index`.
     *
     * Dados enviados para a view:
     * - **classes**: lista de turmas com `id` (codificado em base64) e `name`.
     *
     * @return void
     */
    public function index(): void
    {
        $classes = $this->registrationsService->getClasses();
        $this->view('registrations/index', [
            'classes' => $classes
        ]);
    }

    /**
     * Exibe a lista de alunos matriculados em uma turma específica.
     *
     * Processos realizados neste método:
     * 1. Decodifica o identificador da turma recebido como parâmetro (`$params[0]`),
     *    convertendo de Base64 URL-safe para o valor original.
     * 2. Utiliza o serviço `RegistrationsService` para recuperar todos os alunos
     *    associados à turma informada.
     * 3. Renderiza a view `registrations/students`, enviando como parâmetro:
     *    - **students**: lista de alunos matriculados na turma selecionada.
     *
     * @param array $params Array de parâmetros recebidos pela rota, onde
     *                      o índice [0] representa o ID da turma (em Base64).
     * @return void
     */
    public function search($params): void
    {
        $classId = base64urlDecode($params[0]);
        $students = $this->registrationsService->getStudentsByClassId($classId);

        $this->view('registrations/students', [
            'id' => $params[0],
            'students' => $students,
        ]);
    }

    /**
     * Exibe o formulário para cadastrar uma nova matrícula.
     *
     * Este método é responsável por renderizar a view que permite ao usuário
     * cadastrar uma nova matrícula, associando um aluno a uma turma específica.
     *
     * @param array $params Parâmetros da rota, onde o índice [0] contém o ID da turma.
     * @return void
     */
    public function newRegistration($params): void
    {
        // Decodifica o ID da turma do parâmetro Base64 URL-safe
        $classId = base64urlDecode($params[0]);

        // Obtém a lista de alunos disponíveis para matrícula
        $students = $this->registrationsService->getAvailableStudents($classId);

        // Renderiza a view com os dados necessários
        $this->view('registrations/newRegistration', [
            'id' => $params[0],
            'students' => $students,
        ]);
    }

    /**
     * Executa o processo de matrícula a partir dos dados recebidos na requisição.
     *
     * Processos realizados:
     * 1. Recupera os dados de entrada (provavelmente do formulário ou requisição HTTP).
     * 2. Chama o serviço de matrículas (`registrationsService`) para registrar o aluno.
     * 3. Retorna o resultado da operação no formato JSON para o cliente.
     * 4. Interrompe a execução do script após enviar a resposta.
     *
     * @return void
     */
    public function exeData(): void
    {
        // Chama o serviço para processar a matrícula
        $execute = $this->registrationsService->registerStudent($this->input());
        echo json_encode($execute);
        exit;
    }
}
