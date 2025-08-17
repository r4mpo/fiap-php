<?php

namespace Src\Controllers;

use Src\Core\Controller;
use Src\Services\Reports\ReportsService;

class ReportsController extends Controller
{
    // Serviço responsável por fornecer os dados para relatórios e gráficos
    private ReportsService $reportsService;

    /**
     * Construtor do controller
     * Inicializa o serviço de relatórios para uso nos métodos do controller
     */
    public function __construct()
    {
        $this->reportsService = new ReportsService();
    }

    /**
     * Método principal (index) do controller
     * Responsável por exibir a página de relatórios
     */
    public function index(): void
    {
        // Obtém os dados do gráfico através do método privado
        $chartData = $this->getChartData();

        // Chama a view 'reports/index' passando os dados do gráfico
        // labels => nomes das turmas
        // data   => totais de alunos por turma
        $this->view('reports/index', [
            'labels' => $chartData['classes'],
            'data' => $chartData['totals']
        ]);
    }

    /**
     * Método privado para obter os dados do gráfico
     * Delegado ao serviço de relatórios
     *
     * @return array Retorna um array com 'classes' e 'totals' já formatados para Chart.js
     */
    private function getChartData(): array
    {
        return $this->reportsService->fiveLargestClasses();
    }
}