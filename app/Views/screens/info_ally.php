<?php
/**
 * Info Ally View - Tribe information screen
 * Shows tribe details, statistics, and description
 */

// Helper function for number formatting
if (!function_exists('format_number')) {
    function format_number($num) {
        return number_format($num, 0, ',', '.');
    }
}
?>

<h2><?php echo htmlspecialchars($info['name']); ?></h2>

<table>
    <tr>
        <td valign="top">
            <table class="vis" width="100%">
                <tr><th colspan="2"><?= __('screens.ally.properties') ?: 'Propriedades' ?></th></tr>
                <tr><td width="180"><?= __('screens.ally.tribe_name') ?: 'Nome da tribo:' ?></td><td><?php echo htmlspecialchars($info['name']); ?></td></tr>
                <tr><td><?= __('screens.ally.tag') ?: 'Sigla:' ?></td><td><?php echo htmlspecialchars($info['short']); ?></td></tr>
                <tr><td><?= __('screens.ally.number_of_members') ?: 'Número de membros:' ?></td><td><?php echo $info['members']; ?></td></tr>
                <tr><td><?= __('screens.ally.points_top_40') ?: 'Pontos dos 40 melhores jogadores:' ?></td><td><?php echo format_number($info['best_points']); ?></td></tr>
                <tr><td><?= __('screens.ally.total_points') ?: 'Total de pontos:' ?></td><td><?php echo format_number($info['points']); ?></td></tr>
                <tr><td><?= __('screens.ally.average_points') ?: 'Média de pontos:' ?></td><td><?php echo format_number($info['cutthroungt']); ?></td></tr>
                <tr><td><?= __('screens.ally.ranking') ?: 'Posição:' ?></td><td><?php echo $info['rank']; ?></td></tr>
                <tr><td><?= __('screens.ally.enemies_defeated') ?: 'Inimigos derrotados:' ?></td><td><?php echo format_number($info['killed_units_altogether'] ?? 0); ?> (<?php echo format_number($info['killed_units_altogether_rank'] ?? 0); ?>)</td></tr>
                
                <?php if (!empty($info['homepage'])): ?>
                    <tr><td><?= __('screens.ally.homepage') ?: 'Página inicial:' ?></td><td><a href="<?php echo htmlspecialchars($info['homepage']); ?>" target="_blank"><?php echo htmlspecialchars($info['homepage']); ?></a></td></tr>
                <?php endif; ?>
                <?php if (!empty($info['irc'])): ?>
                    <tr><td>IRC:</td><td><?php echo htmlspecialchars($info['irc']); ?></td></tr>
                <?php endif; ?>
                
                
            </table>
            <br>
            
            <!-- Members Table -->
             <h2><?= __('screens.ally.menu_members') ?: 'Membros da tribo' ?></h2>
            <table class="vis" width="100%">
                <tr>
                    <th width="180"><?= __('screens.ally.name') ?: 'Nome' ?></th>
                    <th width="80"><?= __('screens.ally.ranking') ?: 'Posição' ?></th>
                    <th width="80"><?= __('screens.ally.points') ?: 'Pontos' ?></th>
                    <th width="100"><?= __('screens.ally.global_ranking') ?: 'Posição Global' ?></th>
                    <th width="80"><?= __('screens.ranking.villages') ?: 'Aldeias' ?></th>
                </tr>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td>
                            <?php 
                            // Display small avatar thumbnail
                            $avatarId = $member['avatar'] ?? 0;
                            $avatarPath = $avatarId > 0 ? "graphic/player/profile/{$avatarId}.webp" : "graphic/player/profile/default.webp";
                            ?>
                            <img src="<?= $avatarPath ?>" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 5px; border: 1px solid #3e2723;">
                            <?php $is_guest = $is_guest ?? false; ?>
                            <?php if (!$is_guest): ?>
                                <a href="game.php?village=<?php echo $village['id']; ?>&screen=info_player&id=<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['username']); ?></a>
                            <?php else: ?>
                                <a href="guest.php?world=<?php echo $world ?? '1'; ?>&screen=info_player&id=<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['username']); ?></a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $member['position']; ?></td>
                        <td><?php echo format_number($member['points']); ?></td>
                        <td><?php echo $member['global_rank']; ?></td>
                        <td><?php echo $member['villages']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>
        <td valign="top" style="min-width:350px">
            <table class="vis" width="100%">
                <tr>
                    <td align="center">
                        <?php 
                        $allyImage = !empty($info['image']) ? "{$info['image']}" : "graphic/ally/profile/default.webp";
                        ?>
                        <img src="<?= $allyImage ?>" style="align:center" width="200px" height="200px"">
                    </td>
                </tr>
            </table>
            <br>
            
            <table class="vis" width="100%">
                <tr><th><?= __('screens.ally.description') ?: 'Descrição' ?></th></tr>
                <tr>
                    <td align="center">
                        <?php echo $info['description']; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
