<?php
// Determine which view to show based on view_mode
$viewMode = $view_mode ?? 'overview';

// Include the appropriate sub-view
$viewFile = __DIR__ . '/ally_in_ally_forum_' . $viewMode . '.php';

if (file_exists($viewFile)) {
    include $viewFile;
} else {
    // Fallback to overview if view file doesn't exist
    include __DIR__ . '/ally_in_ally_forum_overview.php';
}
