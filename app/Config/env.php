<?php
/**
 * app/Config/env.php
 *
 * Carregador de configuração de ambiente.
 * Suporta:
 *  - Variáveis de ambiente reais (getenv/$_ENV/$_SERVER)
 *  - Ficheiro .env no root do projeto
 *  - Valores por defeito
 *
 * Pode ser usado pelo CoreFetcher (bootstrap) porque não depende de
 * ficheiros encriptados.
 */

if (!function_exists('noblewars_env')) {
    /**
     * Lê uma variável de ambiente / .env com fallback opcional.
     *
     * @param string $key      Nome da variável
     * @param mixed  $default  Valor por defeito
     * @return mixed
     */
    function noblewars_env(string $key, $default = null)
    {
        // 1. Variável de ambiente real
        $value = getenv($key);
        if ($value !== false) {
            return noblewars_env_cast($value, $default);
        }

        // 2. $_ENV / $_SERVER
        if (isset($_ENV[$key])) {
            return noblewars_env_cast($_ENV[$key], $default);
        }
        if (isset($_SERVER[$key])) {
            return noblewars_env_cast($_SERVER[$key], $default);
        }

        return $default;
    }

    /**
     * Tenta converter strings para tipos primitivos de forma segura.
     * Apenas converte valores que claramente representam booleanos;
     * números e strings vazias mantêm-se como strings.
     */
    function noblewars_env_cast(string $value, $default)
    {
        $trimmed = trim($value);

        // Booleanos literais
        $lower = strtolower($trimmed);
        if ($lower === 'true' || $lower === 'yes') {
            return true;
        }
        if ($lower === 'false' || $lower === 'no') {
            return false;
        }

        // Inteiros e floats apenas se o default for numérico
        if (is_int($default) && preg_match('/^-?\d+$/', $trimmed)) {
            return (int) $trimmed;
        }
        if (is_float($default) && is_numeric($trimmed)) {
            return (float) $trimmed;
        }

        return $value;
    }
}if (!function_exists('noblewars_load_env_file')) {
    /**
     * Carrega ficheiro .env (formato simples KEY=VAL).
     * Suporta:
     *  - Comentários iniciados por #
     *  - Valores entre aspas simples/duplas (incluindo espaços)
     *  - Comentários inline fora de aspas
     *  - Linhas vazias
     */
    function noblewars_load_env_file(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) {
            return;
        }

        $content = file_get_contents($path);
        if ($content === false) {
            return;
        }

        $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $content));

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue;
            }

            $pos = strpos($line, '=');
            if ($pos === false) {
                continue;
            }

            $key = trim(substr($line, 0, $pos));
            $value = substr($line, $pos + 1);

            // Remover whitespace no início/fim
            $value = trim($value);

            // Parsing de aspas
            if ((strlen($value) >= 2) && ($value[0] === '"' || $value[0] === "'")) {
                $quote = $value[0];
                $endPos = false;
                $escaped = false;
                for ($i = 1; $i < strlen($value); $i++) {
                    if ($escaped) {
                        $escaped = false;
                        continue;
                    }
                    if ($value[$i] === '\\' && $quote === '"') {
                        $escaped = true;
                        continue;
                    }
                    if ($value[$i] === $quote) {
                        $endPos = $i;
                        break;
                    }
                }

                if ($endPos !== false) {
                    $value = substr($value, 1, $endPos - 1);
                    // Substituir escapes comuns
                    if ($quote === '"') {
                        $value = str_replace(['\\n', '\\r', '\\t', '\\"'], ["\n", "\r", "\t", '"'], $value);
                    }
                }
            } else {
                // Remover comentário inline fora de aspas
                $hashPos = strpos($value, ' #');
                if ($hashPos !== false) {
                    $value = rtrim(substr($value, 0, $hashPos));
                }
            }

            if ($key !== '' && !isset($_ENV[$key])) {
                $_ENV[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }
}

// Carregar .env se existir (procura no root do projeto)
if (!defined('NOBLEWARS_ENV_LOADED')) {
    // Caminho do root: este ficheiro está em app/Config/, logo sobe 3 níveis
    $envPath = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '.env';
    if (is_file($envPath) && is_readable($envPath)) {
        noblewars_load_env_file($envPath);
    }
    define('NOBLEWARS_ENV_LOADED', true);
}
