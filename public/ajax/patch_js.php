<?php
if ((getenv('APP_ENV') ?: 'production') !== 'development' && !isset($_SERVER['HTTP_X_DEBUG_TOKEN'])) {
    http_response_code(403);
    die('Forbidden');
}
require_once __DIR__ . '/../../app/bootstrap_ajax.php';

$file = __DIR__ . '/../../public/js/core_combined.js';
if (!file_exists($file)) {
    die("File not found: $file\n");
}
$content = file_get_contents($file);
$worldDbName = \App\Core\Database::getWorldDbName();
$target = '    // Get current village ID from page
    function getVillageId() {
        const urlParams = new URLSearchParams(window.location.search);
        const vid = urlParams.get(\'village\');
        // console.log(\'[Resource Updater] Village ID:\', vid);
        return vid;
    }
    // Get world from URL or default
    function getWorld() {
        const urlParams = new URLSearchParams(window.location.search);
        const world = urlParams.get(\'world\') || \'lan_1\';
        // console.log(\'[Resource Updater] World:\', world);
        return world;
    }';
$replacement = '    // Get current village ID from page
    function getVillageId() {
        const urlParams = new URLSearchParams(window.location.search);
        let vid = urlParams.get(\'village\');
        if (!vid && typeof game_data !== \'undefined\' && game_data.village && game_data.village.id) {
            vid = game_data.village.id;
        }
        // console.log(\'[Resource Updater] Village ID:\', vid);
        return vid;
    }
    // Get world from URL or default
    function getWorld() {
        const urlParams = new URLSearchParams(window.location.search);
        let world = urlParams.get(\'world\');
        if (!world && typeof game_data !== \'undefined\' && game_data.world) {
            world = game_data.world;
        }
        if (!world) {
            world = \'' . $worldDbName . '\';
        }
        // console.log(\'[Resource Updater] World:\', world);
        return world;
    }';

if (strpos($content, $target) !== false) {
    $content = str_replace($target, $replacement, $content);
    file_put_contents($file, $content);
    echo "SUCCESS\n";
} else {
    echo "TARGET NOT FOUND\n";
}
