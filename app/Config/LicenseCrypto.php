<?php
/**
 * ============================================================
 *  LicenseCrypto — criptografia partilhada (servidor central + cliente)
 * ============================================================
 *
 * Este ficheiro contém APENAS:
 *   - VERIFICAÇÃO de assinaturas (chave pública)
 *   - criptografia simétrica dos ficheiros (com chave derivada)
 *
 * NÃO contém, nem deve conter, qualquer chave privada. A assinatura
 * (licenças e respostas) é feita exclusivamente no servidor central,
 * onde vive a chave privada.
 *
 * Substitui o antigo segredo HMAC partilhado ("NobleWars_Secure_Salt_...")
 * que, estando hardcoded no cliente, permitia forjar licenças e respostas.
 * Com assinaturas RSA, quem não tem a chave privada NÃO consegue forjar.
 *
 * Formatos suportados:
 *   Licença v2:  NW1.<b64url(payload_json)>.<b64url(assinatura_rsa_sha256)>
 *   Resposta:    campo `signature` (base64) + `sig_alg` = "rsa-sha256"
 *                (ausente/legacy => HMAC com segredo partilhado, migração)
 *   Ficheiro:    "NWG1:" + b64(iv12 . tag16 . ciphertext)   [AES-256-GCM]
 *                "NWMA:" + b64(iv12 . tag16 . ciphertext)   [AES-256-GCM, chave-mestra]
 *                b64(iv16 . ciphertext)                      [AES-256-CBC legacy]
 *
 * Esta classe é copiada para o servidor central por scratch/build_release.php.
 * Qualquer alteração aqui tem de ser replicada no servidor (o build fá-lo).
 */

if (!class_exists('LicenseCrypto')) {
    class LicenseCrypto
    {
        /** Prefixo das licenças com assinatura assimétrica. */
        const LICENSE_PREFIX = 'NW1.';

        /** Prefixo da encriptação de ficheiros para o cliente (GCM). */
        const FILE_PREFIX_LICENSE = 'NWG1:';

        /** Prefixo da encriptação de ficheiros em repouso (GCM, chave-mestra). */
        const FILE_PREFIX_ATREST = 'NWMA:';

        /** Salt da derivação de chave usada nas licenças (compatível com v1). */
        const SALT_LICENSE = 'noblewars_core_encryption_v1';

        /** Salt da derivação de chave usada em repouso. */
        const SALT_ATREST = 'noblewars_core_at_rest_v1';

        // ====================================================
        // LICENÇAS
        // ====================================================

        /**
         * Valida um token de licença e devolve o payload.
         *
         * @param string $token          Token recebido do cliente
         * @param string $publicKeyPem   Chave pública RSA (PEM). Vazio => só legacy
         * @param string $legacySecret   Segredo HMAC legacy. Vazio => legacy desligado
         * @return array|null  Payload ['d'=>dominio, 't'=>tier, 'e'=>expira, ...] ou null
         */
        public static function parseLicense(string $token, string $publicKeyPem = '', string $legacySecret = ''): ?array
        {
            $token = trim($token);
            if ($token === '') {
                return null;
            }

            // --- Licença v2 (assimétrica) ---
            if (strpos($token, self::LICENSE_PREFIX) === 0) {
                if ($publicKeyPem === '' || !function_exists('openssl_verify')) {
                    return null;
                }
                $parts = explode('.', $token);
                if (count($parts) !== 3) {
                    return null;
                }
                $payloadJson = self::b64urlDecode($parts[1]);
                $signature   = self::b64urlDecode($parts[2]);
                if ($payloadJson === null || $signature === null) {
                    return null;
                }
                if (openssl_verify($payloadJson, $signature, $publicKeyPem, OPENSSL_ALGO_SHA256) !== 1) {
                    return null;
                }
                $payload = json_decode($payloadJson, true);
                if (!is_array($payload) || empty($payload['d'])) {
                    return null;
                }
                if (!empty($payload['e']) && (int) $payload['e'] < time()) {
                    return null; // expirada
                }
                return $payload;
            }

            // --- Licença v1 (HMAC legacy) ---
            if ($legacySecret === '') {
                return null;
            }
            $decoded = base64_decode($token, true);
            if ($decoded === false || strpos($decoded, ':') === false) {
                return null;
            }
            list($domain, $hash) = explode(':', $decoded, 2);
            $expected = hash_hmac('sha256', $domain, $legacySecret);
            if (!hash_equals($expected, (string) $hash)) {
                return null;
            }
            return ['d' => $domain, 't' => 'legacy', 'legacy' => true];
        }

        /**
         * Assina um payload de licença. USAR APENAS NO SERVIDOR CENTRAL.
         */
        public static function signLicense(array $payload, string $privateKeyPem): ?string
        {
            $json = json_encode($payload, JSON_UNESCAPED_SLASHES);
            if ($json === false) {
                return null;
            }
            $signature = '';
            if (!openssl_sign($json, $signature, $privateKeyPem, OPENSSL_ALGO_SHA256)) {
                return null;
            }
            return self::LICENSE_PREFIX . self::b64urlEncode($json) . '.' . self::b64urlEncode($signature);
        }

        // ====================================================
        // ASSINATURA DE RESPOSTAS
        // ====================================================

        /**
         * Assina um corpo JSON de resposta. USAR APENAS NO SERVIDOR CENTRAL.
         */
        public static function signResponse(string $json, string $privateKeyPem): ?string
        {
            $signature = '';
            if (!openssl_sign($json, $signature, $privateKeyPem, OPENSSL_ALGO_SHA256)) {
                return null;
            }
            return base64_encode($signature);
        }

        /**
         * Verifica a assinatura de uma resposta.
         * Tenta primeiro RSA (se a chave pública existir); só recorre ao HMAC
         * legacy se a assinatura RSA falhar e houver segredo legacy (migração).
         */
        public static function verifyResponse(string $json, string $signature, string $publicKeyPem = '', string $legacySecret = ''): bool
        {
            $sig = base64_decode($signature, true);
            if ($sig !== false && $publicKeyPem !== '' && function_exists('openssl_verify')) {
                if (openssl_verify($json, $sig, $publicKeyPem, OPENSSL_ALGO_SHA256) === 1) {
                    return true;
                }
            }
            if ($legacySecret !== '') {
                return hash_equals(hash_hmac('sha256', $json, $legacySecret), $signature);
            }
            return false;
        }

        // ====================================================
        // FICHEIROS
        // ====================================================

        /** Deriva uma chave de 32 bytes do material + salt. */
        public static function deriveKey(string $material, string $salt): string
        {
            return hash_hmac('sha256', $material, $salt, true);
        }

        /**
         * Encripta conteúdo para o cliente.
         *
         * @param bool $gcm true => AES-256-GCM autenticado (cliente novo);
         *                  false => AES-256-CBC (cliente legacy)
         */
        public static function encryptForLicense(string $content, string $licenseMaterial, bool $gcm): string
        {
            $key = self::deriveKey($licenseMaterial, self::SALT_LICENSE);
            if ($gcm) {
                $out = self::gcmEncrypt($content, $key);
                if ($out !== null) {
                    return self::FILE_PREFIX_LICENSE . base64_encode($out);
                }
            }
            $iv = random_bytes(16);
            $ct = @openssl_encrypt($content, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
            if ($ct === false) {
                return '';
            }
            return base64_encode($iv . $ct);
        }

        /**
         * Encripta conteúdo EM REPOUSO (chave-mestra do servidor central).
         */
        public static function encryptAtRest(string $content, string $masterKey): string
        {
            $key = self::deriveKey($masterKey, self::SALT_ATREST);
            $out = self::gcmEncrypt($content, $key);
            if ($out === null) {
                return '';
            }
            return self::FILE_PREFIX_ATREST . base64_encode($out);
        }

        /**
         * Desencripta um ficheiro, detectando automaticamente o formato pelo prefixo.
         *
         * @param string $encrypted      Conteúdo (base64 com prefixo opcional)
         * @param string $licenseMaterial Token de licença OU chave-mestra
         */
        public static function decryptFile(string $encrypted, string $licenseMaterial): ?string
        {
            if (strpos($encrypted, self::FILE_PREFIX_ATREST) === 0) {
                $raw = base64_decode(substr($encrypted, strlen(self::FILE_PREFIX_ATREST)), true);
                if ($raw === false) {
                    return null;
                }
                return self::gcmDecrypt($raw, self::deriveKey($licenseMaterial, self::SALT_ATREST));
            }

            if (strpos($encrypted, self::FILE_PREFIX_LICENSE) === 0) {
                $raw = base64_decode(substr($encrypted, strlen(self::FILE_PREFIX_LICENSE)), true);
                if ($raw === false) {
                    return null;
                }
                return self::gcmDecrypt($raw, self::deriveKey($licenseMaterial, self::SALT_LICENSE));
            }

            // Legacy CBC: base64(iv16 . ciphertext)
            $key = self::deriveKey($licenseMaterial, self::SALT_LICENSE);
            $raw = base64_decode($encrypted, true);
            if ($raw === false || strlen($raw) < 17) {
                return null;
            }
            $iv = substr($raw, 0, 16);
            $ct = substr($raw, 16);
            $pt = @openssl_decrypt($ct, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
            return $pt === false ? null : $pt;
        }

        // ====================================================
        // HELPERS
        // ====================================================

        private static function gcmEncrypt(string $content, string $key): ?string
        {
            if (!function_exists('openssl_encrypt')) {
                return null;
            }
            $iv = random_bytes(12);
            $tag = '';
            $ct = @openssl_encrypt($content, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag, '', 16);
            if ($ct === false || strlen($tag) !== 16) {
                return null;
            }
            return $iv . $tag . $ct;
        }

        private static function gcmDecrypt(string $raw, string $key): ?string
        {
            if (strlen($raw) < 28) {
                return null;
            }
            $iv  = substr($raw, 0, 12);
            $tag = substr($raw, 12, 16);
            $ct  = substr($raw, 28);
            $pt = @openssl_decrypt($ct, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
            return $pt === false ? null : $pt;
        }

        public static function b64urlEncode(string $binary): string
        {
            return rtrim(strtr(base64_encode($binary), '+/', '-_'), '=');
        }

        public static function b64urlDecode(string $encoded): ?string
        {
            $encoded = strtr($encoded, '-_', '+/');
            $pad = strlen($encoded) % 4;
            if ($pad > 0) {
                $encoded .= str_repeat('=', 4 - $pad);
            }
            $decoded = base64_decode($encoded, true);
            return $decoded === false ? null : $decoded;
        }

        /**
         * Carrega uma chave de ficheiro ou variável de ambiente.
         * Ordem: variável de ambiente (conteúdo PEM ou caminho) -> ficheiro.
         */
        public static function loadKey(string $envName, string $filePath): string
        {
            $env = getenv($envName);
            if ($env !== false && $env !== '') {
                if (strpos($env, '-----BEGIN') !== false) {
                    return $env; // PEM inline
                }
                if (is_file($env)) {
                    return (string) file_get_contents($env);
                }
            }
            if (is_file($filePath)) {
                return (string) file_get_contents($filePath);
            }
            return '';
        }
    }
}
