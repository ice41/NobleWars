<?php
/**
 * favorite (Favorites) View
 * Shows user's favorite villages
 */
?>

<h2>Favoritos</h2>

<?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<table class="vis" width="100%">
    <tr>
        <th width="60">Ações</th>
        <th>Aldeia</th>
    </tr>

    <?php if (empty($favorite)): ?>
        <tr>
            <td colspan="3" class="center">Ainda não tem favoritos.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($favorite as $vid => $fav_data): ?>
            <tr>
                <td class="center">
                    <a href="game.php?village=<?= $village['id'] ?>&amp;screen=info_village&amp;id=<?= $vid ?>">
                        <img src="graphic/buildings/place.png" title="Informações da aldeia" alt="" />
                    </a>
                    <a
                        href="game.php?village=<?= $village['id'] ?>&amp;screen=map&amp;x=<?= $fav_data['x'] ?>&amp;y=<?= $fav_data['y'] ?>">
                        <img src="graphic/map/map.png" title="Centralizar no mapa" alt="" />
                    </a>
                    <a href="game.php?village=<?= $village['id'] ?>&amp;screen=favorite&amp;action=del&amp;id=<?= $fav_data['id'] ?>&amp;h=<?= $hkey ?>"
                        style="color:red;" onclick="return confirm('Deseja remover esta aldeia dos favoritos?');">
                        <img src="graphic/icons/delete.png" title="Remover dos favoritos" alt="[X]" />
                    </a>
                </td>
                <td><?= htmlspecialchars($fav_data['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<br />

<h3>Adicionar aos favoritos</h3>
<form method="post"
    action="game.php?village=<?= $village['id'] ?>&amp;screen=favorite&amp;action=add&amp;h=<?= $hkey ?>">
    <table class="vis" width="100%">
        <tr>
            <th>Coordenadas:</th>
            <td>
                <input type="text" name="x" size="5" maxlength="3" placeholder="X" />
                |
                <input type="text" name="y" size="5" maxlength="3" placeholder="Y" />
                <input type="submit" value="Adicionar" class="btn" />
            </td>
        </tr>
    </table>
</form>