<?php
/**
 * Awards Screen View
 * Displays player achievements and medals
 */
?>

<h2><?= __('screens.awards.medals') ?></h2>

<?php if (!empty($awards_html)): ?>
    <?= $awards_html ?>
<?php else: ?>
    <p><?= __('screens.awards.no_medals') ?></p>
<?php endif; ?>