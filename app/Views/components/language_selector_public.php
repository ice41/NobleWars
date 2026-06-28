<?php
/**
 * Language Selector Component for Public Pages
 * Replicates the exact functionality from hall_of_fame.php
 */

// Get current language from cookie or default to pt_PT
$current_locale = $_COOKIE['locale'] ?? 'pt_PT';

// Available languages
$available_locales = ['pt_PT', 'en_US', 'es_ES', 'pl_PL', 'fr_FR'];
?>

<div id="language-selector-container" data-current-locale="<?= htmlspecialchars($current_locale) ?>"
    data-available-locales='<?= json_encode($available_locales) ?>'>
</div>

<link rel="stylesheet" href="css/language_selector.css">
<script src="js/language_selector.js"></script>