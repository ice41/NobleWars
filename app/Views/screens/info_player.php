<?php
/**
 * Info Player View - Player information screen
 * Shows player details, statistics, villages, and profile
 */

// Helper functions
if (!function_exists('format_number')) {
    function format_number($num) {
        return number_format($num, 0, ',', '.');
    }
}
?>

<!-- Include Name Cosmetics CSS -->
<link rel="stylesheet" href="/css/name_cosmetics.css">

<?php if (isset($error)): ?>
    <div class="error_box text-center"  style="margin: 20px; padding: 15px; background: #f2dede; border: 1px solid #ebccd1; color: #a94442; border-radius: 4px;">
        <strong>Erro:</strong> <?php echo htmlspecialchars($error); ?>
        <br><br>
        <a href="javascript:history.back()">&laquo; Voltar</a>
    </div>
<?php return; endif; ?>

<?php if ($info_user['admin'] == 0): ?>
    <center><h2 class="error"><?php echo \App\Helpers\CosmeticHelper::formatUsername($info_user['username'], $info_user['id']); ?></h2></center>
<?php else: ?>
    <h2><?php echo \App\Helpers\CosmeticHelper::formatUsername($info_user['username'], $info_user['id']); ?></h2>
<?php endif; ?>

<?php if (isset($info_user['ranga'])): ?>
    <center><img src="../graphic/rangi/<?php echo htmlspecialchars($info_user['ranga']); ?>.png"></center>
<?php endif; ?>

<table>
    <tr>
        <td valign="top">
            <script type="text/javascript">
            var Player = {
                getAllVillages: function(anchor, link) {
                    $.get(link, {}, function(data) {
                        $('#villages_list tbody').append(data.villages);
                        $(anchor).parent().parent().remove();
                        VillageContext.init();
                    }, 'json');
                }
            };

            if (typeof VillageContext !== 'undefined') {
                VillageContext.toggleForVillage = function () {
                    var $anchor = $(this).parent(),
                        village_id = $anchor.data('id'),
                        player_id = $anchor.data('player');
                    
                    var vx = $anchor.data('x'),
                        vy = $anchor.data('y');
                    
                    if (vx && vy) {
                        var current_vid = (typeof game_data !== 'undefined' && game_data.village) ? game_data.village.id : '';
                        var isGuest = window.location.href.indexOf('guest.php') !== -1;
                        if (isGuest) {
                            var urlParams = new URLSearchParams(window.location.search);
                            var world = urlParams.get('world') || '1';
                            window.location.href = 'guest.php?world=' + world + '&screen=map&x=' + vx + '&y=' + vy;
                        } else {
                            window.location.href = 'game.php?village=' + current_vid + '&screen=map&x=' + vx + '&y=' + vy;
                        }
                        return false;
                    }
                    
                    var el_position = $(this).offset(),
                        position = [el_position.left + 6, el_position.top + 6];
                    VillageContext.beginShow($(this), position, village_id, player_id);
                    return false;
                };
            }
            </script>
            
            <table class="vis" width="100%">
                <tr><th colspan="2"><?php echo $info_user['username']; ?></th></tr>
                <tr><td width="80"><?= __('screens.ally.points') ?: 'Pontos:' ?></td><td><?php echo format_number($info_user['points']); ?></td></tr>
                <tr><td><?= __('screens.ally.ranking') ?: 'Ranking:' ?></td><td><?php echo format_number($info_user['rang']); ?></td></tr>
                <tr>
                    <td><?= __('screens.ally.enemies_defeated') ?: 'Oponentes derrotados:' ?></td>
                    <td id="kill_info" class="tooltip" title='<?= sprintf(__('screens.ally.killed_as_att_def'), format_number($info_user['killed_units_att']), $info_user['killed_units_att_rank'], format_number($info_user['killed_units_def']), $info_user['killed_units_def_rank']) ?>'>
                        <?php echo format_number($info_user['killed_units_altogether']); ?> (<?php echo format_number($info_user['killed_units_altogether_rank']); ?>)
                    </td>
                </tr>
                <?php $is_guest = $is_guest ?? false; ?>
                <?php if (empty($info_ally['short'])): ?>
                    <tr><td><?= __('screens.ally.tribe') ?: 'Tribo:' ?></td><td></td></tr>
                <?php else: ?>
                    <tr><td><?= __('screens.ally.tribe') ?: 'Tribo:' ?></td><td>
                        <?php if (!$is_guest): ?>
                            <a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_ally&amp;id=<?php echo $info_ally['id']; ?>"><?php echo htmlspecialchars($info_ally['short']); ?></a>
                        <?php else: ?>
                            <a href="guest.php?world=<?php echo $world ?? 1; ?>&amp;screen=info_ally&amp;id=<?php echo $info_ally['id']; ?>"><?php echo htmlspecialchars($info_ally['short']); ?></a>
                        <?php endif; ?>
                    </td></tr>
                <?php endif; ?>

                <?php $is_guest = $is_guest ?? false; ?>
                <?php if (!$is_guest): ?>
                    <tr><td colspan="2"><a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=mail&amp;mode=new&amp;player=<?php echo $info_user['id']; ?>">&raquo; <?= __('screens.ally.write_message') ?: 'Escreve uma mensagem' ?></a></td></tr>
                <?php endif; ?>
                
                <?php if ($can_mark): ?>
                    <tr><td colspan="2"><a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=edytuj_kolory_graczy&amp;player=<?php echo $info_user['id']; ?>">&raquo; <?= __('screens.ally.mark_on_map') ?: 'Marque no mapa' ?></a></td></tr>
                <?php endif; ?>
                
                <?php if ($can_invite): ?>
                    <tr><td colspan="2"><a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=ally&amp;mode=invite&amp;action=invite_id&amp;id=<?php echo $info_user['id']; ?>&amp;h=<?php echo $_SESSION['hkey'] ?? ''; ?>" class="evt-confirm" data-confirm-msg="<?= sprintf(__('screens.ally.confirm_invite_player'), htmlspecialchars($info_user['username'])) ?>">&raquo; <?= __('screens.ally.invite_to_tribe') ?: 'Convidar para a tribo' ?></a></td></tr>
                <?php endif; ?>
                
                <?php if (!$is_guest && $user['admin'] == 0): ?>
                    <tr><td colspan="2"><a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=admin&amp;mode=users&amp;id=<?php echo $info_user['id']; ?>">&raquo; <?= __('screens.ally.edit_player') ?: 'Editar jogador' ?></a></td></tr>
                <?php endif; ?>
            </table>
            <br>

            <?php
            // Awards (Classic Theme: Left Column)
            $isModern = (($ingame_theme ?? $GLOBALS['conf']['ingame_theme'] ?? 'classic') === 'modern');
            if (!$isModern) {
                global $awards, $config;
                if (($config['awards'] ?? true) && isset($awards) && is_object($awards)) {
                    echo $awards->get_user_awards($info_user['id'], $user['id']);
                }
            }
            ?>

<table id="villages_list" class="vis" width="100%">
                <thead>
                    <tr><th width="180"><?= sprintf(__('screens.ally.villages_with_count'), format_number(count($villages ?? []))) ?></th><th width="80"><?= __('screens.ally.coordinates') ?: 'Coordenadas' ?></th><th><?= __('screens.ally.points') ?: 'Pontos' ?></th></tr>
                </thead>
                <tbody>
                    <?php foreach ($villages as $id => $arr): ?>
                        <tr>
                            <td><span class="village_anchor" data-id="<?php echo $id; ?>" data-player="<?php echo $info_user['id']; ?>" data-x="<?php echo $arr['x']; ?>" data-y="<?php echo $arr['y']; ?>">
                                <?php if (!$is_guest): ?>
                                    <a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_village&amp;id=<?php echo $id; ?>"><?php echo htmlspecialchars($arr['name']); ?></a>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($arr['name']); ?>
                                <?php endif; ?>
                            </span></td>
                            <td>
                                <?php if (!$is_guest): ?>
                                    <a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=map&amp;x=<?php echo $arr['x']; ?>&amp;y=<?php echo $arr['y']; ?>"><?php echo $arr['x']; ?>|<?php echo $arr['y']; ?></a>
                                <?php else: ?>
                                    <?php echo $arr['x']; ?>|<?php echo $arr['y']; ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo format_number($arr['points']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </td>
        <td valign="top"  style="min-width:240px;">
            <table class="vis" width="100%">
                <tbody>
                    <tr><th colspan="2"><?= __('screens.ally.profile') ?: 'Perfil' ?></th></tr>
                    <?php if (isset($info_user['avatar']) && $info_user['avatar'] > 0): ?>
                        <tr><td colspan="2" align="center">
                            <div  style="background-color: #5d4037; border: 2px solid #3e2723; width: 120px; height: 120px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                <img src="graphic/player/profile/<?php echo $info_user['avatar']; ?>.webp" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td></tr>
                    <?php else: ?>
                        <tr><td colspan="2" align="center">
                            <div  style="background-color: #5d4037; border: 2px solid #3e2723; width: 120px; height: 120px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                <img src="graphic/player/profile/default.webp"  class="w-100" style="height: 100%; object-fit: cover;">
                            </div>
                        </td></tr>
                    <?php endif; ?>
                    <?php if ($age != -1): ?>
                        <tr><td><?= __('screens.ally.age') ?: 'Idade:' ?></td><td><?php echo $age; ?></td></tr>
                    <?php endif; ?>
                    <?php if ($sex != -1): ?>
                        <tr><td><?= __('screens.ally.gender') ?: 'Genero:' ?></td><td><?php echo $sex; ?></td></tr>
                    <?php endif; ?>
                    <?php if (!empty($info_user['home'])): ?>
                        <tr><td><?= __('screens.ally.location') ?: 'Localização:' ?></td><td><?php echo htmlspecialchars($info_user['home']); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br />
            <?php if (!empty($info_user['personal_text'])): ?>
                <table class="vis" width="100%">
                    <tr><th><?= __('screens.ally.description') ?: 'Descrição' ?></th></tr>
                    <tr><td align="center">
                        <?php echo $info_user['personal_text']; ?>
                    </td></tr>
                </table>
            <?php endif; ?>

            <?php if ($isModern): ?>
                <br />
                <?php
                // Awards (Modern Theme: Right Column)
                global $awards, $config;
                if (($config['awards'] ?? true) && isset($awards) && is_object($awards)) {
                    echo $awards->get_user_awards($info_user['id'], $user['id']);
                }
                ?>
            <?php endif; ?>
        </td>
    </tr>
</table>
