<h3><?= str_replace('{count}', $odk, __('screens.ranking.odk_title')) ?></h3>
<table class="vis">
    <tr>
        <th><?= __('screens.ranking.discovery') ?></th>
        <th><?= __('screens.ranking.owner') ?></th>
        <th><?= __('screens.ranking.location') ?></th>
        <th><?= __('screens.ranking.tribe') ?></th>
    </tr>
    <?php if (!empty($descobertas)): ?>
        <?php foreach ($descobertas as $o): ?>
            <?php
            // Discovery type names via translation keys
            $typeKeys = [
                1 => 'odk_stellar_fortress',
                2 => 'odk_gunpowder',
                3 => 'odk_occupied',
                4 => 'odk_decimals',
                5 => 'odk_sundial',
                6 => 'odk_musket',
                7 => 'odk_republicanism',
                8 => 'odk_cipher',
                9 => 'odk_cartography',
                10 => 'odk_perspective',
                11 => 'odk_anatomy',
                12 => 'odk_double_entry',
            ];
            $typeKey = isset($typeKeys[$o['typ']]) ? 'screens.ranking.' . $typeKeys[$o['typ']] : 'screens.ranking.odk_unknown';
            ?>
            <tr>
                <td>
                    <b><img src="graphic/icons/secret_scroll_18x18.png">
                        <?= __($typeKey) ?>
                    </b>
                </td>
                <td>
                    <!-- Placeholder for User -->
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $o['userid'] ?? 0 ?>">
                        <?= $o['username'] ?>
                    </a>
                </td>
                <td>
                    <!-- Placeholder for Village -->
                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $o['wioska'] ?>">
                        <?= $o['village_name'] ?? 'Aldeia' ?>
                    </a>
                </td>
                <td>
                    <!-- Placeholder for Ally -->
                    <?php if (!empty($o['ally'])): ?>
                        <a href="game.php?village=<?= $village['id'] ?>&screen=info_ally&id=<?= $o['ally'] ?>">
                            <?= $o['ally_name'] ?? 'Tribo' ?>
                        </a>
                    <?php else: ?>
                        <?= __('screens.ranking.no_tribe') ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4"><?= __('screens.ranking.no_discoveries') ?></td>
        </tr>
    <?php endif; ?>
</table>