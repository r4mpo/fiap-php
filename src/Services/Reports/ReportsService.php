<?php

namespace Src\Services\Reports;

use Src\Repositories\ClassesRepository;

class ReportsService
{
    // Repositório responsável por acessar dados das turmas
    private ClassesRepository $classesRepository;

    /**
     * Construtor da classe
     * Inicializa o repositório de classes para uso nos métodos da service
     */
    public function __construct()
    {
        $this->classesRepository = new ClassesRepository();
    }

    /**
     * Retorna os dados para os 5 maiores turmas por número de matrículas
     *
     * Processos realizados neste método:
     * 1. Chama o repositório para obter os dados das turmas com maior número de alunos
     * 2. Separa os nomes das turmas e os totais de alunos em arrays distintos
     * 3. Converte os arrays para JSON para uso direto em gráficos Chart.js
     *
     * @return array Retorna um array com as chaves:
     *               - 'classes': JSON com nomes das turmas
     *               - 'totals': JSON com quantidade de alunos por turma
     */
    public function fiveLargestClasses()
    {
        $data = $this->classesRepository->getChartData();

        $classes = [];
        $totals = [];

        foreach ($data as $class) {
            $classes[] = $class['class_name'];   // Armazena o nome da turma
            $totals[] = $class['total_students']; // Armazena o total de alunos
        }

        return [
            // Converte os arrays para JSON, ou retorna string vazia se não houver dados
            'classes' => count($classes) > 0 ? json_encode($classes) : '',
            'totals' => count($totals) > 0 ? json_encode($totals) : ''
        ];
    }
}