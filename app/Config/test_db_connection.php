<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<pre style='background:#1a1a1a; color:#00ff00; padding:20px; font-family:monospace; font-size:13px; line-height:1.6;'>";

echo "=== TESTE DE CONEXÃO À BASE DE DADOS ===\n\n";

// Carregar configurações
require_once '/home/iceptds/www/game/new_engine/app/Config/database.php';

echo "📋 CONFIGURAÇÕES CARREGADAS:\n";
echo "   Host: " . ($conf['db_host'] ?? 'N/A') . "\n";
echo "   User: " . ($conf['db_user'] ?? 'N/A') . "\n";
echo "   Pass: " . (isset($conf['db_pass']) ? str_repeat('*', strlen($conf['db_pass'])) . ' (' . strlen($conf['db_pass']) . ' chars)' : 'N/A') . "\n";
echo "   DB: " . ($conf['db_name'] ?? 'N/A') . "\n\n";

// Teste 1: Resolver hostname
echo "🌐 TESTE 1: RESOLVER HOSTNAME\n";
$host = $conf['db_host'] ?? 'iceptdstw.mysql.db';
$ip = gethostbyname($host);
echo "   Hostname: $host\n";
echo "   IP resolvido: $ip\n";
echo "   Status: " . ($ip !== $host ? '✅ Resolvido' : '❌ Não resolvido') . "\n\n";

// Teste 2: Conexão com mysqli
echo "🔌 TESTE 2: CONEXÃO COM MYSQLI\n";
try {
    echo "   Tentando conectar...\n";
    $conn = @mysqli_connect(
        $conf['db_host'],
        $conf['db_user'],
        $conf['db_pass'],
        $conf['db_name']
    );
    
    if ($conn) {
        echo "   ✅ CONEXÃO BEM-SUCEDIDA!\n";
        echo "   Versão do servidor: " . mysqli_get_server_info($conn) . "\n";
        echo "   Base de dados atual: " . mysqli_get_host_info($conn) . "\n";
        mysqli_close($conn);
    } else {
        echo "   ❌ FALHOU!\n";
        echo "   Erro: " . mysqli_connect_error() . "\n";
        echo "   Código: " . mysqli_connect_errno() . "\n";
    }
} catch (Exception $e) {
    echo "   ❌ EXCEÇÃO: " . $e->getMessage() . "\n";
}
echo "\n";

// Teste 3: Conexão sem password (fallback)
echo "🔌 TESTE 3: CONEXÃO SEM PASSWORD (FALLBACK)\n";
try {
    $conn = @mysqli_connect(
        $conf['db_host'],
        $conf['db_user'],
        '',
        $conf['db_name']
    );
    
    if ($conn) {
        echo "   ✅ CONEXÃO BEM-SUCEDIDA SEM PASSWORD!\n";
        mysqli_close($conn);
    } else {
        echo "   ❌ FALHOU!\n";
        echo "   Erro: " . mysqli_connect_error() . "\n";
    }
} catch (Exception $e) {
    echo "   ❌ EXCEÇÃO: " . $e->getMessage() . "\n";
}
echo "\n";

// Teste 4: Testar diferentes hosts comuns na OVH
echo "🌐 TESTE 4: TESTAR HOSTS ALTERNATIVOS\n";
$alternativeHosts = [
    'localhost',
    '127.0.0.1',
    'iceptdstw.mysql.db',
    'iceptdstw.db',
    'mysql.db',
    'db',
];

foreach ($alternativeHosts as $altHost) {
    echo "   Testando: $altHost\n";
    $conn = @mysqli_connect($altHost, $conf['db_user'], $conf['db_pass'], $conf['db_name']);
    if ($conn) {
        echo "      ✅ FUNCIONA!\n";
        mysqli_close($conn);
    } else {
        echo "      ❌ " . mysqli_connect_error() . "\n";
    }
}
echo "\n";

// Teste 5: Verificar se há outros ficheiros de config
echo "🔍 TESTE 5: PROCURAR OUTRAS CONFIGS\n";
$configFiles = [
    '/home/iceptds/www/game/new_engine/public/configs/config.php',
    '/home/iceptds/www/game/new_engine/app/Config/database.php',
];

foreach ($configFiles as $file) {
    if (file_exists($file)) {
        echo "   📄 " . basename($file) . "\n";
        $content = file_get_contents($file);
        
        // Procurar por definições de DB
        if (preg_match_all('/\$conf\[\'db_(host|user|pass|name)\'\]\s*=\s*[\'"]([^\'"]*)[\'"]/', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $key = $match[1];
                $value = $match[2];
                if ($key === 'pass') {
                    $value = str_repeat('*', strlen($value)) . ' (' . strlen($value) . ' chars)';
                }
                echo "      db_$key = $value\n";
            }
        }
    }
}
echo "\n";

// Teste 6: Mostrar a password em claro (para verificação)
echo "🔐 TESTE 6: VERIFICAR PASSWORD\n";
echo "   Password em claro: '" . ($conf['db_pass'] ?? '') . "'\n";
echo "   Length: " . strlen($conf['db_pass'] ?? '') . "\n";
echo "   MD5: " . md5($conf['db_pass'] ?? '') . "\n";
echo "   SHA1: " . sha1($conf['db_pass'] ?? '') . "\n\n";

echo "=== FIM DO TESTE ===\n";
echo "</pre>";