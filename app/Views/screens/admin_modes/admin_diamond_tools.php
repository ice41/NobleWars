<?php
$tab = $_GET['tab'] ?? 'cheat';
$is_standalone_admin = (strpos($_SERVER['REQUEST_URI'], 'admin.php') !== false);
$adminBaseUrl = $is_standalone_admin ? 'admin.php?action=dashboard' : 'game.php?village=' . $village['id'] . '&screen=admin';
?>

<h2><i class="fas fa-tools"></i> Ferramentas Administrativas</h2>
<p style="color: #5c3a1e;">Aceda aos utilitários avançados de base de dados, segurança e auditoria exclusivos da licença Diamond.</p>

<?php if (isset($success) && $success): ?>
    <div class="admin-alert success" style="margin-bottom: 15px;"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (isset($error) && $error): ?>
    <div class="admin-alert error" style="margin-bottom: 15px;"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (!$is_diamond): ?>
    <!-- Premium lock screen -->
    <div class="admin-card" style="text-align: center; padding: 50px 20px; border: 2px solid #8b5a2b; background: rgba(139, 90, 43, 0.05); margin-top: 20px;">
        <div style="font-size: 4rem; margin-bottom: 20px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">🔒</div>
        <h3 style="font-family: 'Cinzel', serif; color: #8b5a2b; font-size: 1.6rem; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;">Funcionalidades Exclusivas Diamond</h3>
        <p style="font-size: 1.1rem; color: #5c3a1e; line-height: 1.6; max-width: 600px; margin: 0 auto 25px auto;">
            O painel de **Ferramentas Diamond** unifica o **Detetor Inteligente de Multicontas**, o gestor de **Cópias de Segurança** do mundo com 1-clique, e a **Consola SQL Direta**. 
            Para desbloquear este ecossistema administrativo premium, atualize a chave do seu servidor.
        </p>
        <a href="https://nped.pt/" target="_blank" class="btn" style="display: inline-block; background: linear-gradient(to bottom, #8b5a2b, #5c3a1e); color: #F4E4BC; border: 1px solid #3d2817; padding: 12px 30px; font-weight: bold; text-transform: uppercase; text-decoration: none; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
            Adquirir Licença Diamond
        </a>
    </div>
<?php else: ?>
    <!-- Tabs Navigation -->
    <div class="diamond-tabs-container" style="display: flex; border-bottom: 2px solid #8b5a2b; margin-bottom: 20px; gap: 5px;">
        <a href="<?= $adminBaseUrl ?>&mode=diamond_tools&tab=cheat" class="diamond-tab <?= $tab === 'cheat' ? 'active' : '' ?>">
            <i class="fas fa-user-secret"></i> Detetor Multicontas
        </a>
        <a href="<?= $adminBaseUrl ?>&mode=diamond_tools&tab=backups" class="diamond-tab <?= $tab === 'backups' ? 'active' : '' ?>">
            <i class="fas fa-hdd"></i> Cópias de Segurança
        </a>
        <a href="<?= $adminBaseUrl ?>&mode=diamond_tools&tab=sql" class="diamond-tab <?= $tab === 'sql' ? 'active' : '' ?>">
            <i class="fas fa-terminal"></i> Consola SQL
        </a>
    </div>

    <!-- TAB 1: CHEAT DETECTOR -->
    <?php if ($tab === 'cheat'): ?>
        <div class="admin-card">
            <h3><i class="fas fa-search"></i> Auditoria de Endereços IP Partilhados</h3>
            <p>O detetor agrupa contas que realizaram login a partir do mesmo IP nas últimas 48 horas. Conexões formalmente declaradas nas definições de conta aparecem marcadas a verde e evitam falsos alertas.</p>

            <?php if (!empty($ip_reports)): ?>
                <table class="vis" width="100%">
                    <thead>
                        <tr>
                            <th>Endereço IP</th>
                            <th>Contas Associadas</th>
                            <th>Estado da Ligação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ip_reports as $report): ?>
                            <tr style="background: <?= $report['declared'] ? 'rgba(76, 175, 80, 0.08)' : 'rgba(255, 235, 59, 0.08)' ?>;">
                                <td style="font-family: monospace; font-size: 13px;">
                                    <i class="fas fa-network-wired" style="color: #8b5a2b; margin-right: 5px;"></i>
                                    <?= htmlspecialchars($report['ip']) ?>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 5px;">
                                        <?php foreach ($report['players'] as $player): ?>
                                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 4px 8px; background: rgba(0,0,0,0.02); border-radius: 3px;">
                                                <span>
                                                    <i class="fas fa-user" style="color: #666; margin-right: 5px;"></i>
                                                    <strong><?= htmlspecialchars($player['username']) ?></strong>
                                                    <?php if ($player['banned'] == '1'): ?>
                                                        <span style="background: #f44336; color: white; padding: 1px 5px; font-size: 9px; border-radius: 3px; margin-left: 5px;">BANIDO</span>
                                                    <?php endif; ?>
                                                </span>
                                                
                                                <form method="post" action="<?= $adminBaseUrl ?>&mode=diamond_tools&tab=cheat&subaction=<?= $player['banned'] == '1' ? 'unban' : 'ban' ?>" style="margin: 0;" onsubmit="return confirm('Tem a certeza que deseja prosseguir com esta ação?');">
                                                    <input type="hidden" name="target_id" value="<?= $player['id'] ?>">
                                                    <?php if ($player['banned'] == '1'): ?>
                                                        <button type="submit" class="btn" style="padding: 2px 8px; font-size: 10px; background: #4caf50; color: white;">Reativar</button>
                                                    <?php else: ?>
                                                        <button type="submit" class="btn" style="padding: 2px 8px; font-size: 10px; background: #f44336; color: white;">Banir</button>
                                                    <?php endif; ?>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td align="center" style="font-weight: bold; color: <?= $report['declared'] ? '#2e7d32' : '#b8860b' ?>;">
                                    <?php if ($report['declared']): ?>
                                        <i class="fas fa-check-circle"></i> Declarada (Sem Alerta)
                                    <?php else: ?>
                                        <i class="fas fa-exclamation-triangle"></i> Não Declarada (Suspeito!)
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: gray; padding: 20px;">
                    <i class="fas fa-shield-alt" style="font-size: 2rem; color: #4caf50; margin-bottom: 10px;"></i><br>
                    Nenhuma partilha de IP suspeita ou não-declarada foi detetada no servidor!
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- TAB 2: BACKUPS -->
    <?php if ($tab === 'backups'): ?>
        <div class="admin-card" style="text-align: center; padding: 40px 20px;">
            <div style="font-size: 3rem; color: #8b5a2b; margin-bottom: 15px;"><i class="fas fa-hdd"></i></div>
            <h3>Cópia de Segurança Completa do Mundo</h3>
            <p style="max-width: 600px; margin: 0 auto 20px auto; line-height: 1.6; color: #5c3a1e;">
                Gere e descarregue um ficheiro estruturado de cópia de segurança em formato SQL contendo a estrutura e todos os dados das tabelas do mundo ativo. 
                Recomenda-se realizar cópias regulares antes de aplicar atualizações ou proceder a resets de servidor.
            </p>
            <a href="<?= $adminBaseUrl ?>&mode=diamond_tools&tab=backups&subaction=download_db" class="btn" style="background: #2e7d32; border-color: #1b5e20; color: white; padding: 12px 30px; font-weight: bold; text-decoration: none; display: inline-block;">
                <i class="fas fa-download"></i> Descarregar Backup SQL
            </a>
        </div>
    <?php endif; ?>

    <!-- TAB 3: SQL CONSOLE -->
    <?php if ($tab === 'sql'): ?>
        <div class="admin-card">
            <h3><i class="fas fa-code"></i> Executar Consulta SQL</h3>
            <form method="post" action="<?= $adminBaseUrl ?>&mode=diamond_tools&tab=sql">
                <div style="margin-bottom: 15px;">
                    <textarea name="sql_query" rows="8" style="width: 100%; font-family: monospace; font-size: 13px; background: #faf8f5; border: 1.5px solid #8b5a2b; padding: 10px; border-radius: 4px; box-sizing: border-box;" placeholder="SELECT * FROM users LIMIT 10;" required><?= htmlspecialchars($sql ?? '') ?></textarea>
                </div>
                <div>
                    <button type="submit" class="btn" style="background: #8b5a2b; color: white; padding: 10px 25px; font-weight: bold;">
                        <i class="fas fa-play"></i> Executar SQL
                    </button>
                </div>
            </form>
        </div>

        <?php if (isset($queryType) && $queryType === 'select' && !empty($queryResult)): ?>
            <div class="admin-card" style="max-height: 500px; overflow: auto; margin-top: 20px;">
                <h3><i class="fas fa-table"></i> Resultados da Consulta</h3>
                <table class="vis" width="100%">
                    <thead>
                        <tr>
                            <?php foreach (array_keys($queryResult[0]) as $colName): ?>
                                <th><?= htmlspecialchars($colName) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($queryResult as $row): ?>
                            <tr>
                                <?php foreach ($row as $val): ?>
                                    <td>
                                        <?php
                                        if ($val === null) {
                                            echo '<span style="color: gray; font-style: italic;">NULL</span>';
                                        } else {
                                            echo htmlspecialchars(strlen($val) > 100 ? substr($val, 0, 97) . '...' : $val);
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (isset($queryType) && $queryType === 'select' && empty($queryResult)): ?>
            <div class="admin-card" style="margin-top: 20px;">
                <h3><i class="fas fa-table"></i> Resultados da Consulta</h3>
                <p style="color: gray; font-style: italic;">A consulta não retornou nenhuma linha.</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<style>
.diamond-tab {
    display: inline-block;
    padding: 10px 20px;
    background: #e6dfd3;
    border: 1px solid #8b5a2b;
    border-bottom: none;
    border-radius: 4px 4px 0 0;
    color: #5c3a1e;
    text-decoration: none;
    font-weight: bold;
    font-size: 12px;
    transition: all 0.2s ease-in-out;
}
.diamond-tab:hover {
    background: #d4cbb8;
}
.diamond-tab.active {
    background: #8b5a2b;
    color: #F4E4BC;
}
</style>
