<?php
/**
 * Token de administração para scripts de diagnóstico
 * (diagnose_core_fetch.php, clear_core_cache.php).
 * 
 * O token abaixo é gerado automaticamente na primeira utilização.
 * Quando acedes aos scripts a partir de um IP não-local, passa:
 *   ?admin_token=SEU_TOKEN
 */

$tokenFile = __DIR__ . '/.diag_token_secret';

if (file_exists($tokenFile)) {
    return file_get_contents($tokenFile);
}

// Gerar token aleatório na primeira utilização
$token = bin2hex(random_bytes(16));
@file_put_contents($tokenFile, $token);
return $token;
