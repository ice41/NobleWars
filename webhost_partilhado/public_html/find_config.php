<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<pre style='background:#000; color:#0f0; padding:20px; font-family:monospace;'>";
echo "=== ENCONTRAR CONFIGURAÇÕES DE BASE DE DADOS ===\n\n";

// Procurar todos os ficheiros que podem conter configs de DB
$searchPatterns = [
    '/home/iceptds/www/game/new_engine/public/configs/*.php',
    '/home/iceptds/www/game/new_engine/public/configs/*.ini',
    '/home/iceptds/www/game/new_engine/public/configs/*.json',
    '/home/iceptds/www/game/new_engine/configs/*.php',
    '/home/iceptds/www/game/new_engine/*.php',
];

$foundFiles = [];
foreach ($searchPatterns as $pattern) {
    $files = glob($pattern);
    if ($files) {
        $foundFiles = array_merge($foundFiles, $files);
    }
}

echo "📁 FICHEIROS DE CONFIG ENCONTRADOS:\n";
foreach ($foundFiles as $file) {
    echo "   " . basename($file) . " → $file\n";
}
echo "\n";

// Procurar em todos os ficheiros PHP por strings de conexão
echo "🔍 PROCURANDO POR 'iceptdstwt' E 'rooiceptdstwt':\n\n";

function searchInFile($file, $searchTerms) {
    $content = file_get_contents($file);
    $results = [];
    
    foreach ($searchTerms as $term) {
        if (strpos($content, $term) !== false) {
            $lines = explode("\n", $content);
            foreach ($lines as $lineNum => $line) {
                if (strpos($line, $term) !== false) {
                    $results[] = [
                        'term' => $term,
                        'line' => $lineNum + 1,
                        'content' => trim($line)
                    ];
                }
            }
        }
    }
    
    return $results;
}

$searchTerms = ['iceptdstwt', 'rooiceptdstwt', 'db_user', 'DB_USER', 'mysql_connect', 'mysqli_connect'];

foreach ($foundFiles as $file) {
    $results = searchInFile($file, $searchTerms);
    if (!empty($results)) {
        echo "📄 " . basename($file) . ":\n";
        foreach ($results as $result) {
            echo "   Linha {$result['line']}: [{$result['term']}] {$result['content']}\n";
        }
        echo "\n";
    }
}

// Mostrar conteúdo dos ficheiros de config
echo "\n📋 CONTEÚDO DOS FICHEIROS DE CONFIG:\n";
echo str_repeat("=", 80) . "\n\n";

foreach ($foundFiles as $file) {
    echo "📄 " . basename($file) . ":\n";
    echo str_repeat("-", 80) . "\n";
    echo file_get_contents($file);
    echo "\n" . str_repeat("=", 80) . "\n\n";
}

echo "</pre>";