<?php
/**
 * Account Manager View
 * Premium feature for automated game management
 */
$current_tab = $tab ?? 'overview';
?>

<h2>Gestor de conta</h2>

<!-- Tab Navigation -->
<table class="vis" width="100%">
    <tr>
        <td class="<?= $current_tab === 'overview' ? 'selected' : '' ?>" width="20%">
            <a href="game.php?village=<?= $village['id'] ?>&screen=premium&feature=AccountManager&tab=overview">
                📋 Visão Geral
            </a>
        </td>
        <td class="<?= $current_tab === 'buildings' ? 'selected' : '' ?>" width="20%">
            <a href="game.php?village=<?= $village['id'] ?>&screen=premium&feature=AccountManager&tab=buildings">
                🏗️ Construções
            </a>
        </td>
        <td class="<?= $current_tab === 'recruitment' ? 'selected' : '' ?>" width="20%">
            <a href="game.php?village=<?= $village['id'] ?>&screen=premium&feature=AccountManager&tab=recruitment">
                ⚔️ Recrutamento
            </a>
        </td>
        <td class="<?= $current_tab === 'research' ? 'selected' : '' ?>" width="20%">
            <a href="game.php?village=<?= $village['id'] ?>&screen=premium&feature=AccountManager&tab=research">
                🔬 Pesquisas
            </a>
        </td>
        <td class="<?= $current_tab === 'resources' ? 'selected' : '' ?>" width="20%">
            <a href="game.php?village=<?= $village['id'] ?>&screen=premium&feature=AccountManager&tab=resources">
                💰 Recursos
            </a>
        </td>
    </tr>
</table>

<br />

<?php if ($current_tab === 'overview'): ?>
    <!-- Overview Tab -->
    <p>Deixe as tarefas repetitivas e foque-se na sua estratégia:</p>

    <div  style="background: #f5f5dc; padding: 15px; margin: 10px 0; border: 1px solid #7D510F;">
        <h3>🏗️ Gerir construções</h3>
        <p><b>Gestor de construção</b></p>
        <p>Decida como quer construir a sua aldeia e deixe o gestor de construção tratar das ordens.</p>
        <p><a href="game.php?village=<?= $village['id'] ?>&screen=premium&feature=AccountManager&tab=buildings">Configurar
                &raquo;</a></p>
    </div>

    <div  style="background: #f5f5dc; padding: 15px; margin: 10px 0; border: 1px solid #7D510F;">
        <h3>⚔️ Gerir recrutamento</h3>
        <p><b>Gestor de tropas</b></p>
        <p>Não precisa de ir à aldeia para treinar as tropas. Defina os níveis de pesquisa para as suas aldeias.</p>
        <p><i>Em desenvolvimento</i></p>
    </div>

    <div  style="background: #f5f5dc; padding: 15px; margin: 10px 0; border: 1px solid #7D510F;">
        <h3>🔬 Gerir pesquisas</h3>
        <p><b>Gestor de Pesquisas</b></p>
        <p>Defina quais os níveis de pesquisa as suas aldeias precisam.</p>
        <p><i>Em desenvolvimento</i></p>
    </div>

    <div  style="background: #f5f5dc; padding: 15px; margin: 10px 0; border: 1px solid #7D510F;">
        <h3>💰 Guardar recursos</h3>
        <p><b>Definir recursos</b></p>
        <p>Ligue o gestor de envios e não se preocupe mais com o desperdício de recursos.</p>
        <p><i>Em desenvolvimento</i></p>
    </div>

<?php elseif ($current_tab === 'buildings'): ?>
    <!-- Building Manager Tab -->
    <h3>Gestor de Construções</h3>
    <p>Configure quais edifícios devem ser construídos automaticamente em suas aldeias.</p>

    <table class="vis" width="100%">
        <tr>
            <th colspan="2">Adicionar Nova Configuração</th>
        </tr>
        <tr>
            <td colspan="2">
                <form method="post"
                    action="game.php?village=<?= $village['id'] ?>&screen=premium&feature=AccountManager&tab=buildings">
                    <input type="hidden" name="h" value="<?= $this->session['hkey'] ?? '' ?>" />
                    <input type="hidden" name="action" value="add_building" />

                    <table class="vis" width="100%">
                        <tr>
                            <td width="150">Aldeia:</td>
                            <td>
                                <select name="village_id">
                                    <option value="all">Todas as aldeias</option>
                                    <?php foreach ($villages as $v): ?>
                                        <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['name']) ?>
                                            (<?= $v['x'] ?>|<?= $v['y'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Edifício:</td>
                            <td>
                                <select name="building">
                                    <?php foreach ($buildings as $key => $name): ?>
                                        <option value="<?= $key ?>"><?= htmlspecialchars($name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><?= __('screens.common.target_level') ?></th>
                            <td><input type="number" name="target_level" value="30" min="1" max="30" /></td>
                        </tr>
                        <tr>
                            <td>Prioridade (1-10):</td>
                            <td><input type="number" name="priority" value="5" min="1" max="10" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center">
                                <input type="submit" value="Adicionar Configuração" class="btn" />
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>

    <br />

    <div  class="p-10" style="background: #ffe; border: 1px solid #7D510F;">
        <h4>ℹ️ Como funciona:</h4>
        <ul>
            <li>O sistema verifica automaticamente se há recursos disponíveis</li>
            <li>Quando possível, adiciona o edifício à fila de construção</li>
            <li>Prioridade mais alta = construído primeiro</li>
            <li>Funciona apenas quando está online</li>
        </ul>
    </div>

    <br />

    <p><i>Nota: A automação será implementada na próxima atualização. Por enquanto, pode configurar suas
            preferências.</i></p>

<?php elseif ($current_tab === 'recruitment'): ?>
    <h3>Gestor de Recrutamento</h3>
    <p><i>Em desenvolvimento - Em breve disponível</i></p>

<?php elseif ($current_tab === 'research'): ?>
    <h3>Gestor de Pesquisas</h3>
    <p><i>Em desenvolvimento - Em breve disponível</i></p>

<?php elseif ($current_tab === 'resources'): ?>
    <h3>Gestor de Recursos</h3>
    <p><i>Em desenvolvimento - Em breve disponível</i></p>

<?php endif; ?>

<br />

<p  class="text-center">
    <a href="game.php?village=<?= $village['id'] ?>&screen=premium" class="btn">« Voltar ao Premium</a>
</p>