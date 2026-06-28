<?php
/**
 * Player Colors View - Customize player colors on the map
 */
?>

<h2><?= __('screens.ally.mark_on_map') ?: 'Marcar jogador no mapa' ?></h2>

<?php if (!empty($error)): ?>
    <div class="error" style="margin-bottom: 15px; padding: 8px; border: 1px solid #c00; background-color: #fee; color: #c00;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success" style="margin-bottom: 15px; padding: 8px; border: 1px solid #080; background-color: #efe; color: #080;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<form action="game.php?village=<?= $village['id'] ?>&screen=edytuj_kolory_graczy&action=dodaj_gracza&h=<?= $hkey ?>" method="post">
    <input type="hidden" name="color_picker_r" id="color_picker_r" value="127">
    <input type="hidden" name="color_picker_g" id="color_picker_g" value="254">
    <input type="hidden" name="color_picker_b" id="color_picker_b" value="127">

    <table class="vis" style="width: 100%; max-width: 600px;">
        <tr>
            <th colspan="2"><?= __('screens.ranking.condition') ?: 'Configuração da marcação' ?></th>
        </tr>
        <tr>
            <td width="150"><?= __('screens.ally.player_name') ?: 'Nome do jogador:' ?></td>
            <td>
                <input name="gracz" value="<?= htmlspecialchars($prepopulate_name) ?>" type="text" style="width: 200px; padding: 3px;" required>
            </td>
        </tr>
        <tr>
            <td>Cor de marcação:</td>
            <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="color" id="native_color_picker" value="#7ffe7f" style="width: 60px; height: 30px; border: 1px solid #7c5d3d; cursor: pointer; padding: 0; background: none;">
                    
                    <!-- Quick Presets -->
                    <div style="display: flex; gap: 5px;">
                        <span onclick="setPreset('#FF0000')" style="display: inline-block; width: 20px; height: 20px; background-color: #FF0000; border: 1px solid #000; cursor: pointer;" title="Vermelho"></span>
                        <span onclick="setPreset('#00FF00')" style="display: inline-block; width: 20px; height: 20px; background-color: #00FF00; border: 1px solid #000; cursor: pointer;" title="Verde"></span>
                        <span onclick="setPreset('#0000FF')" style="display: inline-block; width: 20px; height: 20px; background-color: #0000FF; border: 1px solid #000; cursor: pointer;" title="Azul"></span>
                        <span onclick="setPreset('#FFFF00')" style="display: inline-block; width: 20px; height: 20px; background-color: #FFFF00; border: 1px solid #000; cursor: pointer;" title="Amarelo"></span>
                        <span onclick="setPreset('#800080')" style="display: inline-block; width: 20px; height: 20px; background-color: #800080; border: 1px solid #000; cursor: pointer;" title="Roxo"></span>
                        <span onclick="setPreset('#FFA500')" style="display: inline-block; width: 20px; height: 20px; background-color: #FFA500; border: 1px solid #000; cursor: pointer;" title="Laranja"></span>
                        <span onclick="setPreset('#00FFFF')" style="display: inline-block; width: 20px; height: 20px; background-color: #00FFFF; border: 1px solid #000; cursor: pointer;" title="Ciano"></span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center">
                <input value="Marcar no mapa" type="submit" class="btn" style="padding: 5px 15px; font-weight: bold; cursor: pointer;">
            </td>
        </tr>
    </table>
</form>

<br>

<h3>Jogadores marcados atualmente</h3>
<?php if (count($marked_players) > 0): ?>
    <table class="vis" style="width: 100%; max-width: 600px;">
        <tr>
            <th width="250">Nome do jogador</th>
            <th width="80">Cor</th>
            <th width="80">Ações</th>
        </tr>
        <?php foreach ($marked_players as $p): ?>
            <tr>
                <td>
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $p['do_gracz_id'] ?>">
                        <?= htmlspecialchars($p['do_gracz_name']) ?>
                    </a>
                </td>
                <td class="center">
                    <div style="width: 50px; height: 18px; background-color: rgb(<?= $p['kolor'] ?>); border: 1px solid #000; margin: 0 auto;"></div>
                </td>
                <td class="center">
                    <a href="game.php?village=<?= $village['id'] ?>&screen=edytuj_kolory_graczy&action=usun_gracza&id=<?= $p['id'] ?>" onclick="return confirm('Deseja remover a marcação deste jogador?');">
                        <img src="/graphic/icons/delete.png" alt="Excluir" title="Remover marcação" style="vertical-align: middle;">
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Nenhum jogador marcado no mapa ainda.</p>
<?php endif; ?>

<script type="text/javascript">
    function updateRGB(hex) {
        var r = parseInt(hex.slice(1, 3), 16);
        var g = parseInt(hex.slice(3, 5), 16);
        var b = parseInt(hex.slice(5, 7), 16);
        document.getElementById('color_picker_r').value = r;
        document.getElementById('color_picker_g').value = g;
        document.getElementById('color_picker_b').value = b;
    }

    document.getElementById('native_color_picker').addEventListener('input', function() {
        updateRGB(this.value);
    });

    function setPreset(hex) {
        var picker = document.getElementById('native_color_picker');
        picker.value = hex;
        updateRGB(hex);
    }

    // Initialize values on load
    updateRGB(document.getElementById('native_color_picker').value);
</script>
