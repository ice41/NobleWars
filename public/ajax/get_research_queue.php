<?php
// AJAX endpoint to get research queue HTML
// Returns only the research queue table HTML for partial page updates

session_start();
session_write_close();

require_once __DIR__ . '/../../app/bootstrap_ajax.php';

// Load config
require_once(__DIR__ . '/../configs/config.php');
require_once(__DIR__ . '/../modelo/lib/world_constants.php');
require_once(__DIR__ . '/../modelo/lib/config.php');

// Language support
\CoreFetcher::load('Helpers/language_helper.php');
init_locale();

use App\Core\Database;
use App\Models\SessionModel;
use App\Models\UnitsLibrary;

// Check session
// Session cookie is dynamic: 'session_<world>' (set by set_session_cookie())
$server = get_active_world();
$worldDb = get_world_db_name($server);
$villageId = isset($_GET['village']) ? (int)$_GET['village'] : 0;

if (!$villageId) {
    echo '';
    exit;
}

$sessionCookieValue = $_COOKIE['session_' . $server]
    ?? $_COOKIE['session']
    ?? null;

if (!$sessionCookieValue) {
    echo '';
    exit;
}

$sessionModel = new SessionModel($worldDb);
$session = $sessionModel->checkSession($sessionCookieValue);

if (!$session) {
    echo '';
    exit;
}

$db = Database::getInstance($worldDb, get_world_db_host(get_active_world()), get_world_db_user(get_active_world()), get_world_db_pass(get_active_world()));
$unitsLib = new UnitsLibrary($worldDb);

// Get research queue
$research_queue = $db->fetchAll(
    "SELECT id, research as unit, end_time, trwanie FROM research WHERE villageid = ? ORDER BY id",
    [$villageId]
);

// Helper function
function format_time($seconds) {
    if ($seconds < 0) return '00:00:00';
    return gmdate('H:i:s', $seconds);
}

// Generate HTML
if (count($research_queue) > 0): ?>
    <table class="vis">
        <tr>
            <th width="220">Tecnologia</th>
            <th width="100">Duração</th>
            <th width="120">Conclusão</th>
            <th>Finalizar</th>
        </tr>
        <?php foreach ($research_queue as $q): ?>
            <?php
            $countdown = $q['end_time'] - time();
            $unit_name = $unitsLib->get_name($q['unit']);
            ?>
            <tr class="lit">
                <td><?= htmlspecialchars($unit_name) ?></td>
                <td><span class="timer"><?= format_time($countdown) ?></span></td>
                <td><?= date('d.m.Y H:i:s', $q['end_time']) ?></td>
                <td>
                    <a href="game.php?village=<?= $villageId ?>&amp;screen=smith&amp;action=cancel&amp;id=<?= $q['id'] ?>&amp;h=<?= $session['hkey'] ?? '' ?>">parar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br />
<?php endif;
