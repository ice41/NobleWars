<?php
/**
 * Memo Screen View - Improved Version
 */
?>
<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

<h3>Bloco de Notas</h3>

<div style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 10px; margin-bottom: 10px;">
    <strong>Dica:</strong>Pode usar BB-Codes para formatar seu texto. O limite é de 5.000 caracteres.
</div>

<form action="game.php?village=<?= $village['id'] ?>&screen=memo&action=edit&h=<?= $hkey ?>" method="post">
    <table class="vis" width="100%">
        <tr>
            <th colspan="2">Editar Notas</th>
        </tr>
        <tr>
                <td colspan="2">

                    <div style="margin-bottom: 15px;">
                        <?php 
                        $textareaId = 'message';
                        $prefix = 'memo_';
                        include __DIR__ . '/../components/bbcode_toolbar.php'; 
                        ?>
                    </div>
                </td>
            </tr>
        <tr><textarea id="message" name="memo" cols="80" rows="20" style="width: 98%;"><?= htmlspecialchars($memo_bb) ?></textarea>
            <td>
                <input type="submit" value="Salvar Notas" class="btn">
            </td>
            <td align="right">
                <span id="char_count">0</span> / 5000
            </td>
        </tr>
    </table>
</form>

<style>
    .color-box { width: 15px; height: 15px; display: inline-block; cursor: pointer; border: 1px solid #000; margin-right: 2px; }
</style>

<script type="text/javascript">
$(document).ready(function(){
    BBCodes.init({
        target : '#message',
        ajax_unit_url: 'ajax/unit_bb.php',
        ajax_building_url: 'ajax/build_bb.php'
    });

    // Character counter
    function updateCharCount() {
        var len = $('#message').val().length;
        $('#char_count').text(len);
        if (len > 5000) {
            $('#char_count').css('color', 'red');
        } else {
            $('#char_count').css('color', 'black');
        }
    }
    $('#message').on('input propertychange', updateCharCount);
    updateCharCount();
});
</script>

<br>
<h3>Visualização</h3>
<table class="vis" width="100%">
    <tr>
        <td style="background-color: #fff; padding: 10px; border: 1px solid #7d510f;">
            <?= $memo_viev ?>
        </td>
    </tr>
</table>