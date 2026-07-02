<?php if (empty($error)): ?>
    <h3>Revogar algumas unidades</h3>

    <form name="units"
        action="game.php?village=<?= $village['id'] ?>&screen=place&action=back&unit_id=<?= $unit_id ?>&mode=units&h=<?= $hkey ?>"
        method="post">
        <table>
            <tr>
                <?php $counter = 0; ?>
                <?php foreach ($group_units as $group_name => $value): ?>
                    <td width="150" valign="top">
                        <table class="vis" width="100%">
                            <?php foreach ($group_units[$group_name] as $dbname): ?>
                                <?php $counter++; ?>
                                <tr>
                                    <td>
                                        <a href="javascript:popup_scroll('popup_unit.php?unit=<?= $dbname ?>', 520, 520)"><img
                                                src="graphic/unit/<?= $dbname ?>.png"
                                                title="<?= $cl_units->get_name($dbname) ?>" alt="" /></a>
                                        <input name="<?= $dbname ?>" type="text" size="5" tabindex="<?= $counter ?>"
                                            value="<?php if (($arr_units[$dbname] ?? 0) > 0): ?><?= $arr_units[$dbname] ?><?php endif; ?>" />
                                        <a
                                            href="javascript:insertUnit(document.forms[0].<?= $dbname ?>, <?= $arr_units[$dbname] ?? 0 ?>)">(<?= $arr_units[$dbname] ?? 0 ?>)</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
        <input class="btn btn-default" type="submit" value="Confirmar" style="font-size: 10pt;" />
    </form>
<?php else: ?>
    <div style="color:red; font-size:large"><?= $error ?></div>
<?php endif; ?>

<script type="text/javascript">
    function insertUnit(input, max) {
        input.value = max;
    }
</script>