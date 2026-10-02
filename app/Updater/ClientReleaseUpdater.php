<?php

namespace App\Updater;

/**
 * ============================================================
 *  ClientReleaseUpdater — atualização do lado CLIENTE via GitHub
 * ============================================================
 *
 * Atualiza apenas as PÁGINAS DO LADO CLIENTE (o pacote `new_engine_crip`:
 * app/Views, app/Config, public/..., CoreFetcher, etc.). O CORE do motor
 * (Controllers, Models, Core, Helpers, Services, Libraries) NÃO é atualizado
 * aqui — esse é servido encriptado pelo endpoint licenciado (fetch_core.php).
 *
 * MODELO DE SEGURANÇA (supply-chain):
 *   1. Uma release do GitHub traz 3 assets:
 *        new_engine_crip-<versao>.tar.gz
 *        new_engine_crip-<versao>.manifest.json   (versao + sha256 por ficheiro)
 *        new_engine_crip-<versao>.manifest.sig     (assinatura RSA do manifest)
 *   2. O updater verifica a assinatura do manifest com a CHAVE PÚBLICA
 *      embutida (app/Config/release_public.pem). Sem isto, um GitHub
 *      comprometido poderia injetar código.
 *   3. Só depois confia no manifest, extrai o tar.gz para uma pasta temporária
 *      e confirma que cada ficheiro bate com o sha256 do manifest.
 *   4. Faz backup dos ficheiros atuais e só então aplica.
 *   5. Preserva sempre os ficheiros de configuração/dados do utilizador
 *      (lista configurável — ver $preserve).
 *
 * Nada é aplicado se a assinatura OU qualquer checksum falhar.
 */
class ClientReleaseUpdater
{
    /** @var array Configuração efetiva */
    private $cfg;

    /** @var callable|null Injeção para testes (fn(string $url, array $headers): ?string) */
    private $fetcher;

    /**
     * @param array $config Chaves:
     *   github_repo    'dono/repo' (obrigatório para check/latest)
     *   github_token   token opcional (aumenta o rate-limit da API)
     *   asset_prefix   prefixo dos assets (default 'new_engine_crip')
     *   root_path      raiz do motor (default: a pasta que contém app/ e public/)
     *   public_key_pem chave pública RSA (PEM) que assina os manifests
     *   state_file     ficheiro de estado (versão instalada)
     *   backup_dir     pasta de backups
     *   temp_root      pasta base para staging
     *   preserve       lista de caminhos/carpetas que NUNCA são sobrescritos
     *   fetcher        callable opcional para testes
     */
    public function __construct(array $config = [], ?callable $fetcher = null)
    {
        $root = $config['root_path'] ?? dirname(__DIR__, 2);

        $this->cfg = [
            'github_repo'    => $config['github_repo'] ?? (getenv('NOBLEWARS_GITHUB_REPO') ?: 'ice41/NobleWars'),
            'github_token'   => $config['github_token'] ?? (getenv('NOBLEWARS_GITHUB_TOKEN') ?: ''),
            'asset_prefix'   => $config['asset_prefix'] ?? 'new_engine_crip',
            'root_path'      => rtrim(str_replace('\\', '/', $root), '/'),
            'public_key_pem' => $config['public_key_pem'] ?? '',
            'state_file'     => $config['state_file'] ?? ($root . '/app/storage/client_update.json'),
            'backup_dir'     => $config['backup_dir'] ?? ($root . '/app/storage/client_backups'),
            'temp_root'      => $config['temp_root'] ?? ($root . '/app/storage/client_update_tmp'),
            'preserve'       => $config['preserve'] ?? [
                '.env',
                'public/configs/config.php',
                'app/Config/database.php',
                'app/Config/env.php',
                'app/storage',
                'public/cache',
            ],
            'max_bytes'      => $config['max_bytes'] ?? 200 * 1024 * 1024, // 200 MB
        ];

        $this->fetcher = $fetcher;
    }

    // ========================================================
    // ESTADO / VERSÃO
    // ========================================================

    /** Versão atualmente instalada (lida do ficheiro de estado). */
    public function installedVersion(): string
    {
        $f = $this->cfg['state_file'];
        if (!is_file($f)) {
            return '0.0.0';
        }
        $data = json_decode((string) file_get_contents($f), true);
        return is_array($data) && !empty($data['version']) ? (string) $data['version'] : '0.0.0';
    }

    /** Compara duas versões (semver-like, tolerante a sufixos). */
    public function isNewer(string $candidate, string $current): bool
    {
        return version_compare($this->normalizeVersion($candidate), $this->normalizeVersion($current), '>');
    }

    /**
     * Extrai a parte numérica de uma versão/tag para comparação.
     * Ex.: 'v1.2.0' -> '1.2.0'; 'Alpha-1.8.6.5' -> '1.8.6.5'; 'release-2.3' -> '2.3'.
     * Sem dígitos, devolve '0.0.0'.
     */
    private function normalizeVersion(string $v): string
    {
        if (preg_match('/(\d+(?:\.\d+)*)/', trim($v), $m)) {
            return $m[1];
        }
        return '0.0.0';
    }

    // ========================================================
    // GITHUB
    // ========================================================

    /** Consulta a última release no GitHub. Devolve null se indisponível. */
    public function latestRelease(): ?array
    {
        if ($this->cfg['github_repo'] === '') {
            return null;
        }
        $url = 'https://api.github.com/repos/' . $this->cfg['github_repo'] . '/releases/latest';
        $raw = $this->httpGet($url, $this->githubHeaders());
        if ($raw === null) {
            return null;
        }
        $data = json_decode($raw, true);
        return is_array($data) ? $data : null;
    }

    /**
     * Verifica se há atualização. Devolve:
     *   ['installed','available','has_update','release','assets']
     */
    public function check(): array
    {
        $installed = $this->installedVersion();
        $release = $this->latestRelease();
        $available = $release['tag_name'] ?? null;
        return [
            'installed'  => $installed,
            'available'  => $available,
            'has_update' => $available !== null && $this->isNewer((string) $available, $installed),
            'release'    => $release,
            'assets'     => $this->resolveAssets($release),
        ];
    }

    /** Encontra os 3 assets (tar.gz, manifest, signature) de uma release. */
    public function resolveAssets(?array $release): ?array
    {
        if (!$release || empty($release['assets']) || !is_array($release['assets'])) {
            return null;
        }
        $prefix = preg_quote($this->cfg['asset_prefix'], '/');
        $out = ['tarball' => null, 'manifest' => null, 'signature' => null];
        foreach ($release['assets'] as $a) {
            $name = $a['name'] ?? '';
            $dl   = $a['browser_download_url'] ?? '';
            if ($name === '' || $dl === '') {
                continue;
            }
            if (preg_match('/^' . $prefix . '-.*\.tar\.gz$/', $name)) {
                $out['tarball'] = ['name' => $name, 'url' => $dl];
            } elseif (preg_match('/^' . $prefix . '-.*\.manifest\.json$/', $name)) {
                $out['manifest'] = ['name' => $name, 'url' => $dl];
            } elseif (preg_match('/^' . $prefix . '-.*\.manifest\.sig$/', $name)) {
                $out['signature'] = ['name' => $name, 'url' => $dl];
            }
        }
        return ($out['tarball'] && $out['manifest'] && $out['signature']) ? $out : null;
    }

    // ========================================================
    // VERIFICAÇÃO
    // ========================================================

    /** Chave pública que assina as releases (embutida no cliente). */
    public function publicKey(): string
    {
        if ($this->cfg['public_key_pem'] !== '') {
            return $this->cfg['public_key_pem'];
        }
        $candidates = [
            $this->cfg['root_path'] . '/app/Config/release_public.pem',
            $this->cfg['root_path'] . '/app/Config/license_public.pem',
        ];
        foreach ($candidates as $f) {
            if (is_file($f)) {
                return (string) file_get_contents($f);
            }
        }
        return '';
    }

    /** Verifica a assinatura RSA (base64) de um manifest JSON. */
    public function verifyManifestSignature(string $manifestJson, string $signatureB64): bool
    {
        $publicKey = $this->publicKey();
        if ($publicKey === '' || !function_exists('openssl_verify')) {
            return false;
        }
        $sig = base64_decode(trim($signatureB64), true);
        if ($sig === false) {
            return false;
        }
        return openssl_verify($manifestJson, $sig, $publicKey, OPENSSL_ALGO_SHA256) === 1;
    }

    /**
     * Confirma que cada ficheiro extraído corresponde ao sha256 do manifest.
     * @return array Lista de caminhos com hash errado ou ausentes.
     */
    public function findChecksumMismatches(string $dir, array $manifestFiles): array
    {
        $bad = [];
        foreach ($manifestFiles as $rel => $hash) {
            $rel = $this->safeRelative((string) $rel);
            if ($rel === null) {
                $bad[] = (string) $rel;
                continue;
            }
            $file = $dir . '/' . $rel;
            if (!is_file($file) || !hash_equals((string) $hash, hash_file('sha256', $file))) {
                $bad[] = $rel;
            }
        }
        return $bad;
    }

    // ========================================================
    // STAGING
    // ========================================================

    /**
     * Descarrega, verifica e extrai a release mais recente para staging.
     * NÃO altera a instalação.
     *
     * @return array ['ok'=>bool,'error'=>?string,'dir'=>?string,'manifest'=>?array,'version'=>?string]
     */
    public function downloadAndStage(): array
    {
        $check = $this->check();
        $assets = $check['assets'];
        if ($assets === null) {
            return $this->fail('Sem release com assets válidos (tar.gz + manifest + assinatura).');
        }

        $manifestJson = $this->httpGet($assets['manifest']['url'], $this->assetHeaders());
        $signatureB64 = $this->httpGet($assets['signature']['url'], $this->assetHeaders());
        if ($manifestJson === null || $signatureB64 === null) {
            return $this->fail('Falha ao descarregar o manifest ou a assinatura.');
        }

        // 1) Assinatura primeiro — sem ela, não se confia em nada do GitHub.
        if (!$this->verifyManifestSignature($manifestJson, $signatureB64)) {
            return $this->fail('Assinatura do manifest inválida. Atualização cancelada.');
        }

        $manifest = json_decode($manifestJson, true);
        if (!is_array($manifest) || empty($manifest['files']) || !is_array($manifest['files'])) {
            return $this->fail('Manifest malformado.');
        }

        $version = (string) ($manifest['version'] ?? $check['available'] ?? '');

        // 2) Descarregar e extrair o tar.gz.
        $dir = $this->makeTempDir();
        if ($dir === null) {
            return $this->fail('Não foi possível criar pasta temporária.');
        }
        $tarPath = $dir . '/package.tar.gz';
        $bytes = $this->httpGet($assets['tarball']['url'], $this->assetHeaders(), $this->cfg['max_bytes']);
        if ($bytes === null) {
            return $this->fail('Falha ao descarregar o pacote.');
        }
        if (@file_put_contents($tarPath, $bytes) === false) {
            return $this->fail('Não foi possível gravar o pacote temporário.');
        }

        $extractDir = $dir . '/extract';
        @mkdir($extractDir, 0755, true);
        if (!class_exists('PharData') || !$this->extractTarGz($tarPath, $extractDir)) {
            return $this->fail('Não foi possível extrair o pacote.');
        }

        // 3) Verificar cada ficheiro contra o manifest.
        $bad = $this->findChecksumMismatches($extractDir, $manifest['files']);
        if (!empty($bad)) {
            return $this->fail('Checksums não conferem (' . count($bad) . ' ficheiro(s)). Atualização cancelada.');
        }

        return [
            'ok' => true,
            'error' => null,
            'dir' => $extractDir,
            'manifest' => $manifest,
            'version' => $version,
        ];
    }

    /**
     * Calcula o que mudaria, sem aplicar nada.
     * @return array ['new'=>[],'changed'=>[],'unchanged'=>[],'skipped'=>[]]
     */
    public function plan(string $stagedDir, array $manifestFiles): array
    {
        $result = ['new' => [], 'changed' => [], 'unchanged' => [], 'skipped' => []];
        foreach ($manifestFiles as $rel => $hash) {
            $rel = $this->safeRelative((string) $rel);
            if ($rel === null || $this->isPreserved($rel)) {
                $result['skipped'][] = (string) $rel;
                continue;
            }
            $target = $this->cfg['root_path'] . '/' . $rel;
            if (!is_file($target)) {
                $result['new'][] = $rel;
            } elseif ($this->fileHash($stagedDir . '/' . $rel) === $this->fileHash($target)) {
                $result['unchanged'][] = $rel;
            } else {
                $result['changed'][] = $rel;
            }
        }
        return $result;
    }

    // ========================================================
    // APLICAR / REVERTER
    // ========================================================

    /**
     * Aplica a release em staging: backup dos ficheiros atuais e substituição.
     *
     * @return array ['ok'=>bool,'error'=>?string,'backup_dir'=>?string,'applied'=>int,'version'=>?string]
     */
    public function apply(string $stagedDir, array $manifestFiles, string $version): array
    {
        $plan = $this->plan($stagedDir, $manifestFiles);
        $toApply = array_merge($plan['new'], $plan['changed']);
        if (empty($toApply)) {
            $this->writeState($version, []);
            return ['ok' => true, 'error' => null, 'backup_dir' => null, 'applied' => 0, 'version' => $version];
        }

        $backup = $this->cfg['backup_dir'] . '/' . date('Ymd_His') . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $version);
        if (!is_dir($backup) && !@mkdir($backup, 0755, true) && !is_dir($backup)) {
            return ['ok' => false, 'error' => 'Não foi possível criar a pasta de backup.', 'backup_dir' => null, 'applied' => 0, 'version' => null];
        }

        $applied = 0;
        foreach ($toApply as $rel) {
            $src = $stagedDir . '/' . $rel;
            $dst = $this->cfg['root_path'] . '/' . $rel;

            // Backup do ficheiro atual (se existir)
            if (is_file($dst)) {
                $bpath = $backup . '/' . $rel;
                if (!is_dir(dirname($bpath))) {
                    @mkdir(dirname($bpath), 0755, true);
                }
                @copy($dst, $bpath);
            }

            if (!is_dir(dirname($dst))) {
                @mkdir(dirname($dst), 0755, true);
            }
            if (!@copy($src, $dst)) {
                return ['ok' => false, 'error' => "Falha ao aplicar $rel.", 'backup_dir' => $backup, 'applied' => $applied, 'version' => null];
            }
            $applied++;
        }

        $this->writeState($version, [
            'applied_files' => $applied,
            'backup_dir' => $backup,
        ]);

        return ['ok' => true, 'error' => null, 'backup_dir' => $backup, 'applied' => $applied, 'version' => $version];
    }

    /** Repõe os ficheiros a partir de uma pasta de backup. */
    public function rollback(string $backupDir): array
    {
        $backupDir = rtrim(str_replace('\\', '/', $backupDir), '/');
        $base = rtrim(str_replace('\\', '/', $this->cfg['backup_dir']), '/');
        if (strpos($backupDir, $base . '/') !== 0 || !is_dir($backupDir)) {
            return ['ok' => false, 'error' => 'Backup inválido.', 'restored' => 0];
        }

        $restored = 0;
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($backupDir, \FilesystemIterator::SKIP_DOTS));
        foreach ($it as $f) {
            if (!$f->isFile()) {
                continue;
            }
            $rel = ltrim(substr(str_replace('\\', '/', $f->getPathname()), strlen($backupDir)), '/');
            $rel = $this->safeRelative($rel);
            if ($rel === null || $this->isPreserved($rel)) {
                continue;
            }
            $dst = $this->cfg['root_path'] . '/' . $rel;
            if (!is_dir(dirname($dst))) {
                @mkdir(dirname($dst), 0755, true);
            }
            if (@copy($f->getPathname(), $dst)) {
                $restored++;
            }
        }
        return ['ok' => true, 'error' => null, 'restored' => $restored];
    }

    private function writeState(string $version, array $extra): void
    {
        $state = array_merge([
            'version' => $version,
            'updated_at' => date('Y-m-d H:i:s'),
        ], $extra);
        @mkdir(dirname($this->cfg['state_file']), 0755, true);
        @file_put_contents($this->cfg['state_file'], json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    // ========================================================
    // AUXILIARES
    // ========================================================

    private function fail(string $error): array
    {
        return ['ok' => false, 'error' => $error, 'dir' => null, 'manifest' => null, 'version' => null];
    }

    /** Caminho relativo seguro, ou null se contiver traversal/absoluto. */
    private function safeRelative(string $rel): ?string
    {
        $rel = str_replace('\\', '/', trim($rel));
        if ($rel === '' || $rel[0] === '/' || preg_match('#(^|/)\.\.(/|$)#', $rel)) {
            return null;
        }
        return $rel;
    }

    private function isPreserved(string $rel): bool
    {
        foreach ($this->cfg['preserve'] as $p) {
            $p = str_replace('\\', '/', $p);
            if ($rel === $p || strpos($rel, rtrim($p, '/') . '/') === 0) {
                return true;
            }
        }
        return false;
    }

    private function fileHash(string $path): ?string
    {
        return is_file($path) ? hash_file('sha256', $path) : null;
    }

    private function makeTempDir(): ?string
    {
        $base = $this->cfg['temp_root'];
        if (!is_dir($base) && !@mkdir($base, 0755, true) && !is_dir($base)) {
            return null;
        }
        $dir = $base . '/' . date('Ymd_His') . '_' . bin2hex(random_bytes(4));
        return @mkdir($dir, 0755, true) ? $dir : null;
    }

    /** Extrai um .tar.gz para $dest (PharData). */
    private function extractTarGz(string $tarGz, string $dest): bool
    {
        try {
            $phar = new \PharData($tarGz);
            $phar->extractTo($dest, null, true);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function githubHeaders(): array
    {
        $h = [
            'User-Agent: NobleWars-ClientUpdater',
            'Accept: application/vnd.github+json',
        ];
        if ($this->cfg['github_token'] !== '') {
            $h[] = 'Authorization: Bearer ' . $this->cfg['github_token'];
        }
        return $h;
    }

    private function assetHeaders(): array
    {
        return ['User-Agent: NobleWars-ClientUpdater'];
    }

    /**
     * GET HTTPS simples (curl se existir, senão stream).
     * @return string|null Corpo, ou null em erro.
     */
    private function httpGet(string $url, array $headers = [], int $maxBytes = 0)
    {
        if ($this->fetcher !== null) {
            $body = ($this->fetcher)($url, $headers);
            if (is_string($body) && $maxBytes > 0 && strlen($body) > $maxBytes) {
                return null;
            }
            return is_string($body) ? $body : null;
        }
        if (strpos($url, 'https://') !== 0) {
            return null; // só HTTPS
        }

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 3,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_HTTPHEADER => $headers,
            ]);
            $body = curl_exec($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($body === false || $code < 200 || $code >= 300) {
                return null;
            }
            return $body;
        }

        $ctx = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $headers),
                'timeout' => 60,
                'ignore_errors' => false,
            ],
        ]);
        $body = @file_get_contents($url, false, $ctx);
        return $body === false ? null : $body;
    }
}
