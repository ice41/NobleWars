<h3><?= __('screens.settings_delete.title') ?></h3>
<p><?= __('screens.settings_delete.description') ?></p>
<p><?= __('screens.settings_delete.warning') ?></p>

<form action="game.php?village=<?= $village['id'] ?>&screen=settings&mode=delete&action=delete&h=<?= $hkey ?>"
    method="post">
    <?= __('screens.common.password') ?> <input name="password" type="password">
    <input class="btn btn-default" value="<?= __('screens.common.confirm') ?>" type="submit">
</form>