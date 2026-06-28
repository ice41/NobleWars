<link rel="stylesheet" href="/css/flags.css">

<style>
    /* Increase page width only for flags screen */
    #contentContainer {
        max-width: 980px !important;
        width: 980px !important;
    }
</style>

<h2><?= __('screens.flags.title') ?></h2>

<!-- Navigation Tabs -->
<table class="vis" width="100%">
    <tr>
        <?php foreach ($links as $name => $link_mode): ?>
            <td class="<?= $mode === $link_mode ? 'selected' : '' ?>" width="<?= 100 / count($links) ?>%">
                <a href="game.php?village=<?= $village['id'] ?>&screen=flags&mode=<?= $link_mode ?>">
                    <?= $name ?>
                </a>
            </td>
        <?php endforeach; ?>
    </tr>
</table>

<!-- Mode Content -->
<?php
switch ($mode) {
    case 'general':
        include 'flags_general.php';
        break;
    case 'commerce':
        include 'flags_commerce.php';
        break;
    case 'history':
        include 'flags_history.php';
        break;
    case 'world':
        include 'flags_world.php';
        break;
    case 'help':
        include 'flags_help.php';
        break;
}
?>