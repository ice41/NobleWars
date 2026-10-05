<?php
/**
 * app/Views/admin_client_update.php
 *
 * Página do painel de admin para atualizar as PÁGINAS DO LADO CLIENTE a partir
 * de uma release assinada no GitHub. O core do motor não é atualizado aqui —
 * esse continua a ser servido pelo endpoint licenciado (fetch_core.php).
 *
 * Variáveis esperadas (definidas por AdminController::clientUpdate()):
 *   $check  array|null  ['installed','available','has_update','assets']
 *   $error  string|null
 *   $flash  array|null  ['ok'=>bool,'message'=>string]
 *   $csrf   string      token CSRF
 */
$csrf = $_SESSION['admin_csrf_token'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizações do Motor | NobleWars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Verdana, Arial, sans-serif;
            background: #1a1410;
            color: #3b260e;
            padding: 40px 20px;
        }

        .container {
            max-width: 720px;
            margin: 0 auto;
            background: #f0e6d2;
            border: 3px solid #8b6c42;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
        }

        .header {
            background: #4a331c;
            padding: 20px;
            color: #e8d0a9;
            text-align: center;
            border-bottom: 2px solid #8b6c42;
        }

        .header h1 { font-size: 20px; letter-spacing: 1px; }

        .body { padding: 30px; }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #dcd0b8;
            font-size: 14px;
        }

        .row .label { font-weight: bold; color: #5c3a1e; }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-ok { background: #4b8b3b; color: #fff; }
        .badge-warn { background: #b8860b; color: #fff; }
        .badge-err { background: #8b2f2f; color: #fff; }

        .flash {
            padding: 14px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .flash-ok { background: #dff0d8; border: 1px solid #4b8b3b; color: #2d5222; }
        .flash-err { background: #f2dede; border: 1px solid #8b2f2f; color: #6b1f1f; }

        .note {
            margin-top: 20px;
            font-size: 11px;
            line-height: 1.6;
            color: #5c3a1e;
            background: #e8dcc4;
            border: 1px solid #dcd0b8;
            border-radius: 6px;
            padding: 12px 14px;
        }

        .actions { margin-top: 26px; display: flex; gap: 12px; align-items: center; }

        .btn {
            display: inline-block;
            padding: 12px 22px;
            border: 2px solid #4a331c;
            border-radius: 4px;
            background: #6b4a28;
            color: #f0e6d2;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover { background: #4a331c; }
        .btn-back { background: #8b6c42; }
        .btn[disabled] { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-cloud-download-alt"></i> Atualizações do Motor</h1>
        </div>
        <div class="body">

            <?php if (!empty($flash)): ?>
                <div class="flash <?= !empty($flash['ok']) ? 'flash-ok' : 'flash-err' ?>">
                    <?= htmlspecialchars((string) ($flash['message'] ?? '')) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="flash flash-err">
                    Não foi possível contactar o GitHub: <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (is_array($check)): ?>
                <div class="row">
                    <span class="label">Versão instalada</span>
                    <span><?= htmlspecialchars((string) $check['installed']) ?></span>
                </div>
                <div class="row">
                    <span class="label">Versão disponível</span>
                    <span>
                        <?= $check['available'] !== null
                            ? htmlspecialchars((string) $check['available'])
                            : '<em>sem release publicada</em>' ?>
                    </span>
                </div>
                <div class="row" style="border-bottom:none;">
                    <span class="label">Estado</span>
                    <span>
                        <?php if (!empty($check['has_update'])): ?>
                            <span class="badge badge-warn">Atualização disponível</span>
                        <?php elseif ($check['available'] === null): ?>
                            <span class="badge badge-err">Sem dados do GitHub</span>
                        <?php else: ?>
                            <span class="badge badge-ok">Atualizado</span>
                        <?php endif; ?>
                    </span>
                </div>

                <?php if (!empty($check['has_update'])): ?>
                    <div class="actions">
                        <form method="post" action="admin.php?action=apply_client_update"
                              onsubmit="return confirm('Aplicar a atualização? Os ficheiros atuais são guardados em backup.');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                            <button type="submit" class="btn">
                                <i class="fas fa-download"></i> Descarregar e aplicar
                            </button>
                        </form>
                    </div>
                <?php elseif ($check['available'] === null && empty($error)): ?>
                    <div class="note">
                        Nenhuma release com assets válidos foi encontrada no repositório
                        <strong><?= htmlspecialchars($nwRepo ?? 'ice41/NobleWars') ?></strong>.
                        Publica uma release com os 3 assets (tar.gz + manifest + assinatura).
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="note">
                <strong>Notas de segurança:</strong><br>
                • A assinatura do manifesto é verificada com a chave pública embutida antes de aplicar
                qualquer ficheiro — um GitHub comprometido não consegue injetar código.<br>
                • Todo o ficheiro é confirmado por <em>sha256</em> contra o manifesto assinado.<br>
                • Os ficheiros de configuração/dados do utilizador
                (<code>.env</code>, <code>public/configs/config.php</code>, <code>app/Config/database.php</code>,
                <code>app/Config/env.php</code>, <code>app/Config/license.php</code>,
                <code>app/Config/mail.php</code>, <code>app/Config/paypal.php</code>,
                <code>app/Config/Worlds/</code>, <code>app/storage</code>, <code>public/cache</code>)
                são sempre preservados.<br>
                • É feito um backup antes de substituir; podes reverter a partir de
                <code>app/storage/client_backups/</code>.<br>
                • <strong>Isto atualiza apenas o lado cliente.</strong> O core do motor atualiza-se sozinho
                pelo endpoint licenciado.
            </div>

            <div class="actions">
                <a class="btn btn-back" href="admin.php?action=dashboard">
                    <i class="fas fa-arrow-left"></i> Voltar ao painel
                </a>
            </div>

        </div>
    </div>
</body>

</html>
