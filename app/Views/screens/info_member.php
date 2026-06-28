<?php
/**
 * Info Member View - Tribe members list
 * Shows all members of a tribe with their statistics
 */
?>

<h2>membros da tribo <font color="<?php echo ($ally['id'] == $user['ally']) ? 'blue' : 'red'; ?>">
        <?php echo htmlspecialchars($ally['short']); ?>
    </font>
</h2>
<a href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_ally&amp;id=<?php echo $ally['id']; ?>"> >>
    <?php echo htmlspecialchars($ally['name']); ?></a>

<table class="vis">
    <tr>
        <th width="280">usuario</th>
        <th width="40">Classificação</th>
        <th width="80">Pontos</th>
        <th width="40">Aldeias</th>
    </tr>
    <?php foreach ($members as $id => $arr): ?>
        <tr <?php echo ($user['id'] == $id) ? 'class="lit"' : ''; ?>>
            <td>
                <a
                    href="game.php?village=<?php echo $village['id']; ?>&amp;screen=info_player&amp;id=<?php echo $id; ?>"><?php echo htmlspecialchars($arr['username']); ?></a>
                <?php if (!empty($arr['titel'])): ?>
                    (<?php echo htmlspecialchars($arr['titel']); ?>)
                <?php endif; ?>
            </td>
            <td><?php echo $arr['rank']; ?></td>
            <td><?php echo format_number($arr['points']); ?></td>
            <td><?php echo format_number($arr['villages']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>