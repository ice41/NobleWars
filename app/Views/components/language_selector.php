<?php
/**
 * Language Selector Component View
 * 
 * Usage in views:
 * <?php include __DIR__ . '/../../components/language_selector.php'; ?>
 */

$current_locale = current_locale();
$available_locales = available_locales();
?>

<div id="language-selector-container" data-current-locale="<?= htmlspecialchars($current_locale) ?>"
    data-available-locales='<?= json_encode($available_locales) ?>'>
</div>

<link rel="stylesheet" href="css/language_selector.css">
<script src="js/language_selector.js"></script>