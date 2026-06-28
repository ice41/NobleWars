<?php if (empty($user['ally']) || $user['ally'] == -1): ?>
    <?php include 'ally_no_ally.php'; ?>
<?php else: ?>
    <?php include 'ally_in_ally.php'; ?>
<?php endif; ?>