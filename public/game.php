<?php
define('NEW_ENGINE_ACTIVE', true);
/*****************************************/
/*     GAME.PHP - MODERNIZADO           */
/*     100% FIEL AO ORIGINAL            */
/*     PHP 7+/8+ com MySQLi             */
/*****************************************/

// Erro handler global: captura TUDO, incluindo erros fatais do bootstrap
// (Remove o silêncio do HTTP 500 — mostra o erro real)
set_error_handler(function ($severity, $message, $file, $line) {
    // Respeitar @ / error_reporting(). Em PHP 8 o operador @ continua a invocar
    // este handler, mas error_reporting() devolve uma máscara sem este nível —
    // sem esta verificação qualquer aviso suprimido (ex.: uma escrita best-effort
    // num directório sem permissões) rebentava o motor com "Permission denied".
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Nunca revelar ao utilizador que o motor executa código dinamicamente.
// Remove marcadores internos (eval) de mensagens, caminhos e stack traces
// antes de os mostrar nas páginas de erro.
if (!function_exists('nw_public_error_clean')) {
    function nw_public_error_clean($value)
    {
        if (!is_string($value) || $value === '') {
            return $value;
        }
        // "ficheiro.php(36) : eval()'d code (linha 215)" -> "ficheiro.php"
        $value = preg_replace('/\(\d+\)\s*:\s*eval\(\)\'d code(\s*\(linha \d+\))?/i', '', $value);
        $value = preg_replace('/:\s*eval\(\)\'d code/i', '', $value);
        $value = preg_replace('/eval\(\)\'d code/i', '', $value);
        $value = preg_replace('/eval\(\)/i', '', $value);

        return $value;
    }
}

try {
    session_start();

    require_once(__DIR__ . '/../app/CoreFetcher.php');
    
    // Verificar se o CoreFetcher foi carregado com sucesso (a ofuscação pode falhar)
    if (!class_exists('CoreFetcher')) {
        throw new Exception('Classe CoreFetcher não encontrada — o pacote do motor está incompleto ou corrompido. Volta a enviar a instalação completa.');
    }
    
    \CoreFetcher::init();
    
    // ============================
    // FALLBACK LOCAL: get_world_db_config com __DIR__ correto
    // (Definido ANTES do CoreFetcher::load() para usar este se necessário)
    // ============================
    if (!function_exists('get_world_db_config')) {
    function get_world_db_config($world) {
        $world = (string)$world;
        global $conf;
        $defaultHost = $conf['db_host'] ?? null;
        $defaultUser = $conf['db_user'] ?? null;
        $defaultPass = $conf['db_pass'] ?? null;
        $defaultDb   = $conf['db_name'] ?? null;

        if ($defaultHost === null) {
            $dbPaths = [
                __DIR__ . '/../app/Config/database.php',
            ];
            foreach ($dbPaths as $dbConfigFile) {
                if (file_exists($dbConfigFile)) {
                    $savedConf = $conf;
                    @include $dbConfigFile;
                    $defaultHost = $conf['db_host'] ?? 'localhost';
                    $defaultUser = $conf['db_user'] ?? 'root';
                    $defaultPass = $conf['db_pass'] ?? '';
                    $defaultDb   = $conf['db_name'] ?? '';
                    $conf = $savedConf;
                    break;
                }
            }
            if ($defaultHost === null) {
                $defaultHost = 'localhost';
                $defaultUser = 'root';
                $defaultPass = '';
                $defaultDb   = '';
            }
        }

        $prefix = $conf['db_prefix'] ?? '';
        if (empty($prefix) && !empty($defaultDb)) {
            if (str_ends_with($defaultDb, 'index_tw')) {
                $prefix = substr($defaultDb, 0, -strlen('index_tw'));
            } elseif (str_ends_with($defaultDb, 'index')) {
                $prefix = substr($defaultDb, 0, -strlen('index'));
            } else {
                $lastUnderscore = strrpos($defaultDb, '_');
                if ($lastUnderscore !== false) {
                    $prefix = substr($defaultDb, 0, $lastUnderscore + 1);
                }
            }
        }

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $world)) {
            return ['host' => $defaultHost, 'user' => $defaultUser, 'pass' => $defaultPass, 'name' => $prefix . 'lan_invalid'];
        }

        $worldDbName = $prefix . 'lan_' . $world;
        $pathsToTry = [
            __DIR__ . '/../app/Config/Worlds/' . $world . '.php',
        ];
        $worldConfigFile = null;
        foreach ($pathsToTry as $p) {
            $realPath = realpath($p);
            if ($realPath !== false && file_exists($realPath)) {
                $worldConfigFile = $realPath;
                break;
            }
        }

        $defaultConfig = ['host' => $defaultHost, 'user' => $defaultUser, 'pass' => $defaultPass, 'name' => $worldDbName];

        if ($worldConfigFile !== null) {
            $config = @include $worldConfigFile;
            if (is_array($config)) {
                return [
                    'host' => $config['db_host'] ?? $defaultConfig['host'],
                    'user' => $config['db_user'] ?? $defaultConfig['user'],
                    'pass' => $config['db_pw'] ?? ($config['db_pass'] ?? $defaultConfig['pass']),
                    'name' => $config['db_name'] ?? $defaultConfig['name'],
                ];
            }
            error_log('[get_world_db_config] world config file loaded but not array: ' . $worldConfigFile);
        } else {
            error_log('[get_world_db_config] world config file NOT FOUND for world=' . $world . '. Tried: ' . implode(', ', $pathsToTry) . ' | prefix=' . $prefix . ' | fallback=' . $worldDbName);
        }
        return $defaultConfig;
    }
    }
    
    \CoreFetcher::load('Helpers/helpers.php');
    \CoreFetcher::load('Helpers/language_helper.php');

    require_once(__DIR__ . '/configs/config.php');
    require_once(__DIR__ . '/modelo/lib/world_constants.php');
    require_once(__DIR__ . '/modelo/lib/config.php');
    require_once(__DIR__ . '/modelo/lib/functions.php');
    require_once(__DIR__ . '/modelo/lib/bonus.php');

    // Initialize localization
    if (function_exists('init_locale')) {
        init_locale();
    } else {
        throw new Exception('init_locale() não definida — CoreFetcher não carregou language_helper.php (ficheiro não encontrado na cache ou no servidor central)');
    }

    // Instanciar GameController
    $controller = new \App\Controllers\GameController();
    $controller->index();
} catch (Throwable $e) {
    // Log do erro
    error_log('[GAME.PHP] ' . get_class($e) . ': ' . $e->getMessage() . ' em ' . $e->getFile() . ':' . $e->getLine());

    // Sanitizar antes de mostrar: nunca expor marcadores internos de execução dinâmica.
    $eRawFile    = (string) $e->getFile();
    $eHiddenLine = (stripos($eRawFile, "eval()'d") !== false) || (stripos($e->getTraceAsString(), "eval()'d") !== false);
    $eMsg        = nw_public_error_clean($e->getMessage());
    $eFile       = nw_public_error_clean($eRawFile);
    $eTrace      = nw_public_error_clean($e->getTraceAsString());
    
    // Se for AJAX, devolver JSON
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'Ocorreu um erro interno. Por favor, tente novamente mais tarde.'
        ]);
        exit;
    }
    
    // Mostrar erro detalhado em HTML (útil para diagnóstico)
    header('HTTP/1.1 500 Internal Server Error');
    ?>
    <!DOCTYPE html>
    <html><head><title>Erro — NobleWars</title>
    <style>body{font-family:monospace;background:#1a1a1a;color:#e0e0e0;padding:30px;max-width:800px;margin:0 auto;}
    h1{color:#f44336;border-bottom:2px solid #f44336;padding-bottom:8px;}
    .error{background:#2a1a1a;border:1px solid #f44336;border-radius:6px;padding:15px;margin:15px 0;}
    .error h2{color:#ff8a80;margin:0 0 10px 0;}
    .error p{margin:5px 0;}
    .file{color:#b0bec5;font-size:0.85em;}
    .trace{background:#1a1a2a;padding:10px;border-radius:4px;font-size:0.8em;overflow:auto;max-height:300px;}
    .tips{background:#1e3a2e;border-left:4px solid #4caf50;padding:12px;margin:15px 0;border-radius:4px;}
    .dica{background:#3a2a1a;border-left:4px solid #ff9800;padding:12px;margin:10px 0;border-radius:4px;}
    ul{margin:5px 0;padding-left:20px;}
    code{background:#333;padding:2px 5px;border-radius:3px;}</style>
    </head><body>
    <h1>⚔️ Erro no Motor</h1>
    <div class="error">
        <h2><?= get_class($e) ?></h2>
        <p><strong>Mensagem:</strong> <?= htmlspecialchars($eMsg) ?></p>
        <p class="file"><strong>Ficheiro:</strong> <?= htmlspecialchars(basename($eFile)) ?><?= $eHiddenLine ? '' : ' (linha ' . (int) $e->getLine() . ')' ?></p>
        <p class="file"><strong>Path:</strong> <?= htmlspecialchars($eFile) ?></p>
        <?php if ($e->getPrevious()): ?>
            <p><strong>Exceção anterior:</strong> <?= htmlspecialchars(nw_public_error_clean($e->getPrevious()->getMessage())) ?></p>
        <?php endif; ?>
    </div>
    
    <div class="dica">
        <strong>🔍 Causas comuns:</strong>
        <ul>
            <li><strong>Componente do motor em falta ou corrompido</strong> — volta a enviar o pacote completo</li>
            <li><strong>Cache local vazia e servidor central inacessível</strong> — verifica a conectividade de saída do servidor</li>
            <li><strong>Sem permissões de escrita</strong> — confirma que <code>app/storage/</code> é gravável pelo PHP</li>
        </ul>
    </div>
    
    <div class="tips">
        <strong>📋 Para diagnóstico completo, faz upload e acede a:</strong>
        <br><code>diagnose_game.php</code> (se existir na raiz)
    </div>
    
    <h3>Stack Trace:</h3>
    <div class="trace"><?= htmlspecialchars($eTrace) ?></div>
    </body></html>
    <?php
}
// Restaurar error handler original
restore_error_handler();
