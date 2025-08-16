<?php

namespace Src\Core;

class Model
{
    private $table;

    /**
     * Define o nome da tabela que será usada como referência do modelo.
     *
     * @param string $table Nome da tabela
     * @return void
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * Recupera o nome da tabela que está sendo espelhado pelo modelo.
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
}