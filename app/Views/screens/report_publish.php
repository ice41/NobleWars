<?php
/**
 * Report Publishing View
 * Allows users to publish reports with privacy controls
 */
?>

<h2><?= __('report.publish_report', 'Publicar relatório') ?></h2>

<p><?= __('report.publish_desc', 'Aqui pode escolher a informação a ser exibida no relatório publicado. As configurações também podem ser alteradas após a publicação.') ?></p>

<form method="POST"
    action="game.php?village=<?= $village['id'] ?>&screen=report&mode=publish&report_id=<?= $report_id ?>">
    <input type="hidden" name="hkey" value="<?= $hkey ?>">

    <table class="vis" width="500">
        <tr>
            <th colspan="2"><?= __('report.privacy_options', 'Opções de privacidade') ?></th>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_all" value="1" <?= isset($published) && $published['show_all'] ? 'checked' : '' ?>>
                    <?= __('report.show_all', 'Mostrar tudo') ?>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_own_village" value="1" <?= isset($published) && $published['show_own_village'] ? 'checked' : 'checked' ?>>
                    <?= __('report.show_own_village', 'Mostrar própria aldeia') ?> <span style="color: red;">*</span>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_own_units" value="1" <?= isset($published) && $published['show_own_units'] ? 'checked' : 'checked' ?>>
                    <?= __('report.show_own_units', 'Mostrar as unidades próprias') ?>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_casualties" value="1" <?= isset($published) && $published['show_casualties'] ? 'checked' : 'checked' ?>>
                    <?= __('report.show_casualties', 'Mostrar as suas baixas') ?>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_enemy_village" value="1" <?= isset($published) && $published['show_enemy_village'] ? 'checked' : '' ?>>
                    <?= __('report.show_enemy_village', 'Mostrar aldeia inimiga') ?> <span style="color: red;">*</span>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_enemy_units" value="1" <?= isset($published) && $published['show_enemy_units'] ? 'checked' : '' ?>>
                    <?= __('report.show_enemy_units', 'Mostrar unidades inimigas') ?>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_enemy_casualties" value="1" <?= isset($published) && $published['show_enemy_casualties'] ? 'checked' : '' ?>>
                    <?= __('report.show_enemy_casualties', 'Mostrar baixas inimigas') ?>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_loot" value="1" <?= isset($published) && $published['show_loot'] ? 'checked' : '' ?>>
                    <?= __('report.show_loot', 'Mostrar saque') ?>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <label>
                    <input type="checkbox" name="show_buildings" value="1" <?= isset($published) && $published['show_buildings'] ? 'checked' : '' ?>>
                    <?= __('report.show_buildings', 'Mostrar edifícios') ?>
                </label>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="font-size: 10px; color: #666;">
                <span style="color: red;">*</span> <?= __('report.title_warning', '* Também muda o título do relatório.') ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="text-align: center;">
                <button type="submit" class="btn"><?= __('report.create', 'Criar') ?></button>
            </td>
        </tr>
    </table>
</form>

<?php if (isset($success) && $success): ?>
    <br>
    <table class="vis" width="500">
        <tr>
            <th><?= __('report.publish_success', 'Relatório publicado com sucesso!') ?></th>
        </tr>
        <tr>
            <td>
                <p><?= __('report.share_bbcode', 'Use este código BB para partilhar o relatório:') ?></p>
                <input type="text" value="[report]<?= $hash ?>[/report]" readonly style="width: 100%;"
                    onclick="this.select()">
                <br><br>
                <p><?= __('report.direct_link', 'Link direto:') ?></p>
                <input type="text" value="<?= $_SERVER['HTTP_HOST'] ?>/public_report.php?hash=<?= $hash ?>" readonly
                    style="width: 100%;" onclick="this.select()">
            </td>
        </tr>
    </table>
<?php endif; ?>