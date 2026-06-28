<?php
/**
 * Forum Admin View — screen=forum&screenmode=admin
 * Matches original game design (see screenshot):
 *   - List existing forum sections with rename/visibility toggle/delete
 *   - Create new forum section with visibility option
 *   - Link to moderation history
 */
$baseUrl = 'game.php?village=' . $village['id'] . '&screen=forum&screenmode=admin';

// Visibility labels (visible field: 0=all, 1=hidden, 2=trusted)
$visLabels = [
    0 => 'Para todos',
    1 => 'Fórum escondido',
    2 => 'Membros de confiança',
];
?>

<?php if (!empty($error)): ?>
    <div class="error_box" style="margin-bottom:8px; padding:5px; background:#ffe0e0; border:1px solid #c00;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div style="margin-bottom:8px; padding:5px; background:#e0ffe0; border:1px solid #080;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<!-- ══════════ Novas mensagens no fórum ══════════ -->
<table class="vis" width="100%" style="margin-bottom:10px;">
    <tr class="head">
        <th colspan="2">Novas mensagens no fórum</th>
    </tr>
    <tr class="row_b">
        <td>
            <input type="checkbox" id="exclude_silent" name="exclude_silent" value="1" checked>
            <label for="exclude_silent" style="font-style:italic;">Excluir publicações de fóruns silenciados</label>
        </td>
        <td align="right">
            <a href="<?= $baseUrl ?>&action=add_section&h=<?= $session['hkey'] ?>">+</a>
        </td>
    </tr>
</table>

<!-- ══════════ Existing sections ══════════ -->
<table class="vis" width="100%">
    <tr class="head">
        <th>Fórum</th>
        <th width="150">Visibilidade</th>
        <th width="120">Acesso</th>
        <th width="200">Ação</th>
    </tr>

    <?php if (empty($sections)): ?>
        <tr class="row_b">
            <td colspan="4" align="center"><i>Nenhum fórum criado.</i></td>
        </tr>
    <?php else: ?>
        <?php foreach ($sections as $sec): ?>
            <tr class="row_b">
                <!-- Rename form -->
                <td>
                    <form method="post"
                        action="<?= $baseUrl ?>&action=edit_forum&fid=<?= $sec['id'] ?>&h=<?= $session['hkey'] ?>"
                        style="display:inline;">
                        <input type="text" name="title" value="<?= htmlspecialchars($sec['name']) ?>" size="18" maxlength="25">
                        <input type="submit" value="Renomear" class="btn">
                    </form>
                </td>

                <!-- Visibility toggle -->
                <td align="center">
                    <a href="<?= $baseUrl ?>&action=make_private&fid=<?= $sec['id'] ?>&h=<?= $session['hkey'] ?>">
                        <?= $visLabels[$sec['visible'] ?? 0] ?>
                    </a>
                    <small style="color:#666;">alterar</small>
                </td>

                <!-- Partners (access sharing) -->
                <td align="center">
                    <a href="<?= $baseUrl ?>&action=partners&fid=<?= $sec['id'] ?>">Adicionar tribos</a>
                </td>

                <!-- Delete + confirm -->
                <td align="center">
                    <form method="post"
                        action="<?= $baseUrl ?>&action=del_forum&fid=<?= $sec['id'] ?>&h=<?= $session['hkey'] ?>"
                        style="display:inline;"
                        onsubmit="return confirm('Tem a certeza que deseja apagar este fórum e todos os seus tópicos?')">
                        <input type="hidden" name="confirm" value="true">
                        <input type="checkbox" name="confirm_check" id="confirm_<?= $sec['id'] ?>"
                            onclick="this.form.elements['confirm'].value = this.checked ? 'true' : 'false'">
                        <label for="confirm_<?= $sec['id'] ?>">confirmar</label>
                        <input type="submit" value="Apagar" class="btn"
                            style="background-color:#c00; color:#fff; border-color:#900;">
                    </form>
                    &nbsp;
                    <a href="<?= $baseUrl ?>&action=add_subsection&fid=<?= $sec['id'] ?>">+</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<?php if (!empty($sections)): ?>
    <p style="font-size:11px; text-align:right; color:#666;">
        *: Esta tribo ainda não aceitou a sua partilha de fórum
    </p>
<?php endif; ?>

<br>

<!-- ══════════ Create new forum ══════════ -->
<table class="vis" width="100%">
    <tr class="head">
        <th colspan="3">Criar novo fórum</th>
    </tr>
    <tr class="row_b">
        <form method="post" action="<?= $baseUrl ?>&action=new_forum&h=<?= $session['hkey'] ?>">
            <td>
                <b>Nome do fórum:</b>
                <input type="text" name="title" size="20" maxlength="25" required>
            </td>
            <td>
                <label>
                    <input type="radio" name="trust_priv" value="0" checked>
                    Visível a todos
                </label><br>
                <label>
                    <input type="radio" name="trust_priv" value="1">
                    Fórum escondido
                </label><br>
                <label>
                    <input type="radio" name="trust_priv" value="2">
                    Membros de confiança
                </label>
            </td>
            <td align="right">
                <input type="submit" value="Criar" class="btn">
            </td>
        </form>
    </tr>
</table>

<br>

<!-- ══════════ Moderation log link ══════════ -->
<div style="text-align:center;">
    <a href="<?= $baseUrl ?>&action=log">
        <img src="/graphic/forum/forum_admin.png" alt="" style="vertical-align:middle;">
        Historico de moderação do fórum
    </a>
</div>