<h2><i class="fas fa-cloud-download-alt"></i> Atualizações do Motor</h2>
<p style="color: #5c3a1e;">
    Atualiza as <strong>páginas do lado cliente</strong> a partir de uma release assinada no GitHub.
</p>

<?php $flash = $flash ?? null; ?>
<?php if (!empty($flash)): ?>
    <div class="admin-alert <?= !empty($flash['ok']) ? 'success' : 'error' ?>"
        style="padding:10px 14px;border-radius:6px;margin:10px 0;<?= !empty($flash['ok']) ? 'background:#d4edda;border:1px solid #c3e6cb;color:#155724;' : 'background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;' ?>">
        <?= htmlspecialchars((string) ($flash['message'] ?? '')) ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="admin-alert error"
        style="padding:10px 14px;border-radius:6px;margin:10px 0;background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;">
        Não foi possível contactar o GitHub: <?= htmlspecialchars((string) $error) ?>
    </div>
<?php endif; ?>

<div class="admin-card">
    <h3><i class="fas fa-info-circle"></i> Estado</h3>

    <?php if (is_array($check)): ?>
        <table class="vis" width="100%">
            <tr>
                <td width="45%"><strong>Versão instalada</strong></td>
                <td><?= htmlspecialchars((string) ($check['installed'] ?? '—')) ?></td>
            </tr>
            <tr>
                <td><strong>Versão disponível</strong></td>
                <td>
                    <?= ($check['available'] ?? null) !== null
                        ? htmlspecialchars((string) $check['available'])
                        : '<em>sem release publicada</em>' ?>
                </td>
            </tr>
            <tr>
                <td><strong>Estado</strong></td>
                <td>
                    <?php if (!empty($check['has_update'])): ?>
                        <span style="color:#b8860b;font-weight:bold;">Atualização disponível</span>
                    <?php elseif (($check['available'] ?? null) === null): ?>
                        <span style="color:#8b2f2f;font-weight:bold;">Sem dados do GitHub</span>
                    <?php else: ?>
                        <span style="color:#2e7d32;font-weight:bold;">Atualizado</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <?php if (!empty($check['has_update'])): ?>
            <form method="post" action="<?= $adminBaseUrl ?>&mode=client_update"
                onsubmit="return confirm('Aplicar a atualização? Os ficheiros atuais são guardados em backup.');">
                <input type="hidden" name="apply_client_update" value="1">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <br>
                <button type="submit" class="btn"
                    style="padding: 10px 20px; font-size: 14px; background: #4caf50; border-color: #388e3c; color: white;">
                    <i class="fas fa-download"></i> Descarregar e aplicar
                </button>
            </form>
        <?php elseif (($check['available'] ?? null) === null && empty($error)): ?>
            <div class="admin-alert info" style="margin-top:10px;">
                <i class="fas fa-info-circle"></i>
                Nenhuma release com assets válidos foi encontrada no repositório
                <strong><?= htmlspecialchars((string) ($nwRepo ?? 'ice41/NobleWars')) ?></strong>.
                Publica uma release com os 3 assets (tar.gz + manifest + assinatura).
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Não foi possível determinar o estado da atualização.</p>
    <?php endif; ?>
</div>

<div class="admin-card">
    <h3><i class="fas fa-shield-alt"></i> Notas de segurança</h3>
    <ul>
        <li>São sempre preservados: <code>.env</code>, <code>public/configs/config.php</code>,
            <code>app/Config/database.php</code>, <code>app/storage</code>, <code>public/cache</code>.</li>
        <li>É feito um backup antes de substituir; podes reverter a partir de
            <code>app/storage/client_backups/</code>.</li>
        <li><strong>Isto atualiza apenas o lado cliente.</li>
    </ul>
</div>
