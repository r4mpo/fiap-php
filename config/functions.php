<?php

/**
 * Arquivo: functions.php
 * Descrição: Contém funções auxiliares e gerais utilizadas em todo o sistema.
 *
 * Instruções de uso:
 * - Incluir este arquivo nos scripts que precisarem das funções: require_once 'functions.php';
 * - Adicione novas funções gerais conforme necessário, mantendo comentários claros.
 */

/**
 * Formata um CPF no padrão XXX.XXX.XXX-XX
 *
 * @param string $cpf CPF numérico ou já parcialmente formatado
 * @return string CPF formatado ou vazio se inválido
 */
if (!function_exists('formatCpf')) {
    function formatCpf(string $cpf): string
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
}

/**
 * Limita um texto para se adequar melhor na view
 *
 * @param string $string texto que deseja limitar
 * @param string $qttCaracteres quantidade de caracteres a exibir
 * @return string Texto limitado para visualização
 */
if (!function_exists('limitText')) {
    function limitText(string $string, int $qttCaracteres = 15): string
    {
        return strlen($string) > $qttCaracteres ? (substr($string, 0, $qttCaracteres) . '...') : '';
    }
}

/**
 * Valida se um CPF é válido de acordo com os dígitos verificadores
 *
 * @param string $cpf CPF numérico ou formatado
 * @return bool Retorna true se válido, false caso contrário
 */
if (!function_exists('validateCpf')) {
    function validateCpf(string $cpf): bool
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
}

/**
 * Decodifica uma string Base64 que foi previamente convertida para um formato URL-safe.
 *
 * Processos realizados nesta função:
 * 1. Converte os caracteres específicos de URL-safe ('-' e '_') de volta para os
 *    caracteres padrão do Base64 ('+' e '/').
 * 2. Ajusta o padding da string adicionando '=' ao final, caso o comprimento
 *    não seja múltiplo de 4, garantindo que o Base64 seja válido.
 * 3. Utiliza `base64_decode` para retornar o valor original da string.
 *
 * Exemplo:
 * - Entrada: "MTIz" (Base64 URL-safe de "123")
 * - Saída: "123"
 *
 * @param string $data String Base64 URL-safe a ser decodificada.
 * @return string Valor original decodificado.
 */
if (!function_exists('base64urlDecode')) {
    function base64urlDecode(string $data): string
    {
        // Converte os caracteres de volta ao padrão Base64
        $base64 = strtr($data, '-_', '+/');

        // Ajusta o padding (caso necessário)
        $padding = strlen($base64) % 4;
        if ($padding > 0) {
            $base64 .= str_repeat('=', 4 - $padding);
        }

        return base64_decode($base64);
    }
}

/**
 * Converte uma string Base64 para um formato seguro para URLs.
 *
 * @param string $str String codificada em Base64.
 * @return string Base64 em formato URL-safe.
 */
if (!function_exists('base64urlEncode')) {
    function base64urlEncode(string $str): string
    {
        // Converte a string para Base64
        $base64 = base64_encode($str);

        // Substitui caracteres para torná-la segura em URLs
        $base64url = strtr($base64, '+/', '-_');

        // Remove os sinais de padding "="
        return rtrim($base64url, '=');
    }
}

/**
 * Sanitiza uma string para uso seguro em aplicações web.
 *
 * Esta função realiza uma limpeza completa da string recebida,
 * protegendo contra possíveis ataques de Cross-Site Scripting (XSS)
 * e garantindo que o valor seja seguro para exibição em HTML.
 *
 * Processos realizados:
 * 1. `strip_tags($str)`:
 *    - Remove todas as tags HTML e PHP da string.
 *    - Impede que códigos HTML ou scripts sejam executados na página.
 *
 * 2. `trim($str)`:
 *    - Remove espaços em branco extras do início e fim da string.
 *    - Garante consistência e evita erros em comparações ou armazenamento.
 *
 * 3. `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')`:
 *    - Converte caracteres especiais em entidades HTML, como:
 *      - < → &lt;
 *      - > → &gt;
 *      - " → &quot;
 *      - ' → &#039;
 *    - Protege contra XSS ao exibir a string em páginas HTML.
 *    - O parâmetro `ENT_QUOTES` garante que tanto aspas simples quanto duplas sejam convertidas.
 *    - UTF-8 é usado como charset para suportar caracteres especiais corretamente.
 *
 * @param string $str A string de entrada que será sanitizada.
 * @return string A string limpa, segura para exibição e armazenamento.
 */
if (!function_exists('sanitizeString')) {
    function sanitizeString($str)
    {
        $str = strip_tags($str);
        $str = trim($str);
        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        return $str;
    }
}

/**
 * Remove todos os caracteres não numéricos de uma string.
 *
 * Esta função é útil para sanitizar entradas que devem conter apenas números,
 * como CPF, CNPJ, telefones ou códigos numéricos.
 *
 * Processos realizados:
 * 1. `preg_replace('/\D/', '', $str)`:
 *    - Substitui todos os caracteres que **não são dígitos (0-9)** por uma string vazia.
 *    - Garante que a saída contenha apenas números.
 *
 * 2. `trim($str)`:
 *    - Remove espaços em branco do início e fim da string resultante.
 *    - Evita problemas de formatação ou validação de números.
 *
 * @param string $str A string de entrada que será filtrada.
 * @return string A string contendo apenas os números.
 */
if (!function_exists('sanitizeNumbers')) {
    function sanitizeNumbers($str)
    {
        $str = preg_replace('/\D/', '', $str);
        $str = trim($str);
        return $str;
    }
}

/**
 * Valida se uma string é um e-mail no formato correto.
 *
 * Esta função verifica se o valor fornecido segue um padrão de e-mail válido,
 * garantindo que contenha um usuário, o símbolo "@" e um domínio apropriado.
 *
 * Processos realizados:
 * 1. `filter_var($email, FILTER_VALIDATE_EMAIL)`:
 *    - Utiliza o filtro nativo do PHP para validar e-mails.
 *    - Retorna `false` caso o e-mail seja inválido.
 *
 * 2. `trim($email)`:
 *    - Remove espaços em branco do início e fim da string.
 *    - Evita erros de validação devido a espaços extras.
 *
 * @param string $email O endereço de e-mail a ser validado.
 * @return bool Retorna `true` se o e-mail for válido, `false` caso contrário.
 */
if (!function_exists('validateEmail')) {
    function validateEmail(string $email): bool
    {
        $email = trim($email);
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

/**
 * Valida se uma senha é considerada forte.
 *
 * Critérios de senha forte:
 * 1. Possui ao menos 8 caracteres.
 * 2. Contém ao menos uma letra maiúscula.
 * 3. Contém ao menos uma letra minúscula.
 * 4. Contém ao menos um número.
 * 5. Contém ao menos um caractere especial (símbolo).
 *
 * @param string $password A senha a ser validada.
 * @return bool Retorna `true` se a senha atende aos critérios, `false` caso contrário.
 */
if (!function_exists('validateStrongPassword')) {
    function validateStrongPassword(string $password): bool
    {
        $password = trim($password);

        // Expressão regular para senha forte
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

        return preg_match($pattern, $password) === 1;
    }
}

/**
 * Sanitiza uma string removendo todos os caracteres que não sejam letras ou espaços.
 *
 * Esta função é útil para campos de nome ou texto que devem conter apenas letras
 * e espaços, removendo números, símbolos e qualquer outro caractere especial.
 *
 * Processos realizados:
 * 1. `preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', '', $str)`:
 *    - Remove tudo que não seja:
 *      - Letras maiúsculas e minúsculas do alfabeto inglês (a-z, A-Z)
 *      - Letras acentuadas (À-ÿ)
 *      - Espaços em branco (\s)
 *    - O modificador `u` garante suporte a UTF-8 para acentuação correta.
 * 2. Retorna a string limpa apenas com letras e espaços.
 *
 * @param string $str A string de entrada que será sanitizada.
 * @return string A string contendo apenas letras e espaços.
 */
if (!function_exists('sanitizeLettersAndSpaces')) {

    function sanitizeLettersAndSpaces(string $str): string
    {
        return preg_replace('/[^a-zA-ZÀ-ÿ\s]/u', '', $str);
    }
}