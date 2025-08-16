<?php

/**
 * Arquivo: functions.php
 * Descrição: Contém funções auxiliares e gerais utilizadas em todo o sistema.
 *
 * Instruções de uso:
 * - Incluir este arquivo nos scripts que precisarem das funções:
 *     require_once 'functions.php';
 * - Adicione novas funções gerais conforme necessário, mantendo comentários claros.
 */

// /////////////////////////////
// FUNÇÕES DE FORMATAÇÃO
// /////////////////////////////

/**
 * Formata um CPF no padrão XXX.XXX.XXX-XX
 *
 * @param string $cpf CPF numérico ou já parcialmente formatado
 * @return string CPF formatado ou vazio se inválido
 */
function format_cpf(string $cpf): string
{
    // Remove qualquer caractere que não seja número
    $cpf = preg_replace('/\D/', '', $cpf);

    // Verifica se possui 11 dígitos
    if (strlen($cpf) !== 11) {
        return '';
    }

    // Retorna CPF formatado
    return substr($cpf, 0, 3) . '.'
        . substr($cpf, 3, 3) . '.'
        . substr($cpf, 6, 3) . '-'
        . substr($cpf, 9, 2);
}

// /////////////////////////////
// FUNÇÕES DE VALIDAÇÃO
// /////////////////////////////

/**
 * Valida se um CPF é válido de acordo com os dígitos verificadores
 *
 * @param string $cpf CPF numérico ou formatado
 * @return bool Retorna true se válido, false caso contrário
 */
function validate_cpf(string $cpf): bool
{
    // Remove caracteres não numéricos
    $cpf = preg_replace('/\D/', '', $cpf);

    // CPF deve ter 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (inválido)
    if (preg_match('/^(.)\1{10}$/', $cpf)) {
        return false;
    }

    // Validação dos dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

// /////////////////////////////
// OUTRAS FUNÇÕES GERAIS
// /////////////////////////////

/**
 * Gera um hash seguro para senhas (bcrypt)
 *
 * @param string $password Senha em texto plano
 * @return string Hash seguro pronto para armazenar no banco
 */
function generate_password_hash(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}