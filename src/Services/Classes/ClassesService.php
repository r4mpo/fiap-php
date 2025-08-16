<?php

namespace Src\Services\Classes;

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
        $data = $this->classesRepository->getAll();

        if (!empty($data)) {
            foreach ($data as $class) {
                $classes[] = [
                    'id' => base64_encode($class['id']),
                    'name' => $class['name'],
                    'description' => limitText($class['description'], 20),
                    'qttStudents' => $class['qttStudents'] ?? 0
                ];
            }
        }

        return $classes;
    }
}
