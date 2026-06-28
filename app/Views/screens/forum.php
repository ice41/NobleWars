<?php
// Forum screen dispatcher — routes to the appropriate sub-view based on $mode
$viewMode = $mode ?? 'list';
$viewFile = __DIR__ . '/forum_' . $viewMode . '.php';

if (file_exists($viewFile)) {
    include $viewFile;
} else {
    include __DIR__ . '/forum_list.php';
}
