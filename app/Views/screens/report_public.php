<?php
/**
 * Public Reports Management View
 * Lists all published reports by the user with management options
 */
?>

<h2><?= __('report.public_reports', 'Relatórios públicos') ?></h2>

<p><?= __('report.desc', 'Aqui pode gerir os relatórios publicados e encaminhar as URLs a outros jogadores. Os relatórios publicados podem ser visualizados por qualquer pessoa que conheça a URL.') ?></p>

<?php if (empty($published_reports)): ?>
    <p><?= __('report.no_reports', 'Não tem relatórios publicados.') ?></p>
<?php else: ?>
    <form method="POST" action="game.php?village=<?= $village['id'] ?>&screen=report&mode=public&action=delete_multiple">
        <input type="hidden" name="hkey" value="<?= $hkey ?>">

        <table class="vis" width="100%">
            <tr>
                <th width="20">
                    <input type="checkbox" onclick="selectAll(this)">
                </th>
                <th><?= __('report.published', 'Publicado') ?></th>
                <th><?= __('report.subject', 'Assunto') ?></th>
                <th><?= __('report.received', 'Recebida') ?></th>
                <th><?= __('report.visits', 'Convites') ?></th>
                <th><?= __('report.action', 'Ação') ?></th>
            </tr>

            <?php foreach ($published_reports as $pr): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="id_<?= $pr['id'] ?>" value="1">
                    </td>
                    <td>
                        <?= date('d.m.', $pr['published_at']) ?><br>
                        <?= date('H:i:s', $pr['published_at']) ?>
                    </td>
                    <td>
                        <a href="/public_report.php?hash=<?= $pr['hash'] ?>" target="_blank">
                            <?= htmlspecialchars($pr['title']) ?>
                        </a>
                    </td>
                    <td>
                        <?= date('d.m.', $pr['time']) ?><br>
                        <?= date('H:i:s', $pr['time']) ?>
                    </td>
                    <td><?= $pr['view_count'] ?></td>
                    <td>
                        <a
                            href="game.php?village=<?= $village['id'] ?>&screen=report&mode=publish&report_id=<?= $pr['report_id'] ?>">
                            <?= __('report.edit_permissions', 'Editar permissões') ?>
                        </a>
                        |
                        <a href="game.php?village=<?= $village['id'] ?>&screen=report&mode=public&action=delete&id=<?= $pr['id'] ?>"
                            onclick="return confirm('<?= __('report.confirm_delete_single', 'Tem certeza que deseja apagar este relatório público?') ?>')">
                            <?= __('report.delete', 'Apagar') ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="6"  style="padding-left: 30px; font-size: 11px;">
                        <b><?= __('report.bbcode', 'BB-Code:') ?></b>
                        <input type="text" value="[report]<?= $pr['hash'] ?>[/report]" readonly onclick="this.select()"
                            style="width: 300px;">
                        &nbsp;
                        <b><?= __('report.link', 'Link:') ?></b>
                        <input type="text" value="<?= $_SERVER['HTTP_HOST'] ?>/public_report/<?= $pr['hash'] ?>" readonly
                            onclick="this.select()" style="width: 400px;">
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="6">
                    <input type="checkbox" id="select_all_bottom" onclick="selectAll(this)">
                    <label for="select_all_bottom"><?= __('report.select_all', 'Selecionar tudo') ?></label>
                    &nbsp;&nbsp;
                    <button class="btn btn-default" type="button" onclick="window.location.reload()"><?= __('report.forward', 'Reencaminhar') ?></button>
                    &nbsp;
                    <button class="btn btn-default" type="submit" name="delete_selected"
                        onclick="return confirm('<?= __('report.confirm_delete_multiple', 'Tem certeza que deseja apagar os relatórios selecionados?') ?>')">
                        <?= __('report.delete', 'Apagar') ?>
                    </button>
                </td>
            </tr>
        </table>
    </form>
<?php endif; ?>

<script>
    function selectAll(checkbox) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="id_"]');
        checkboxes.forEach(function (cb) {
            cb.checked = checkbox.checked;
        });
    }
</script>