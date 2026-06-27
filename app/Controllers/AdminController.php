<?php

namespace App\Controllers;

use App\Core\Database;

/**
 * AdminController - Standalone Admin Panel Controller
 * Handles authentication and routing for standalone admin access
 */
class AdminController
{
    private $db;
    private $indexDb;

    public function __construct()
    {
        // Connect to index database for admin authentication
        $this->indexDb = Database::getInstance(\App\Core\Database::getGlobalDbName());
    }

    /**
     * Display login page for standalone admin panel
     */
    public function showLogin()
    {
        // Check if already logged in
        if ($this->isAdminLoggedIn()) {
            header('Location: admin.php?action=select_world');
            exit;
        }

        // Check for login errors
        $error = $_SESSION['admin_login_error'] ?? null;
        unset($_SESSION['admin_login_error']);

        require __DIR__ . '/../Views/admin_login.php';
    }

    /**
     * Handle admin login
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: admin.php');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['admin_login_error'] = __('admin.errors.fill_all_fields');
            header('Location: admin.php');
            exit;
        }

        // Query conta table for admin user
        $user = $this->indexDb->fetch(
            "SELECT * FROM conta WHERE nazwa = ? AND activated = '1' AND banned = '0'",
            [$username]
        );

        if (!$user) {
            $_SESSION['admin_login_error'] = __('admin.errors.invalid_credentials');
            header('Location: admin.php');
            exit;
        }

        // Verify password using SecurityHelper
        $passwordValid = \App\Helpers\SecurityHelper::verifyPassword($password, $user['haslo']);

        if (!$passwordValid) {
            $_SESSION['admin_login_error'] = __('admin.errors.invalid_credentials');
            header('Location: admin.php');
            exit;
        }

        // Check if it's a legacy hash and rehash it transparently
        if (substr($user['haslo'], 0, 4) !== '$2y$') {
            $newHash = \App\Helpers\SecurityHelper::hashPassword($password);
            $this->indexDb->query("UPDATE conta SET haslo = ? WHERE id = ?", [$newHash, $user['id']]);
            $user['haslo'] = $newHash;
        }

        // Check if user has admin privileges
        if ($user['admin'] != 1) {
            $_SESSION['admin_login_error'] = __('admin.errors.access_denied');
            header('Location: admin.php');
            exit;
        }

        // Create admin session
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['nazwa'];
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_login_time'] = time();

        // Update session in database
        $sessionId = session_id();
        $this->indexDb->query(
            "UPDATE conta SET session = ? WHERE id = ?",
            [$sessionId, $user['id']]
        );

        header('Location: admin.php?action=select_world');
        exit;
    }

    /**
     * Handle admin logout
     */
    public function logout()
    {
        // Clear session
        if (isset($_SESSION['admin_id'])) {
            $this->indexDb->query(
                "UPDATE conta SET session = '' WHERE id = ?",
                [$_SESSION['admin_id']]
            );
        }

        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_current_world']);

        header('Location: admin.php');
        exit;
    }

    /**
     * Display world selector
     */
    public function selectWorld()
    {
        if (!$this->isAdminLoggedIn()) {
            header('Location: admin.php');
            exit;
        }

        // Get list of available worlds
        $worlds = $this->getAvailableWorlds();

        require __DIR__ . '/../Views/admin_world_selector.php';
    }

    /**
     * Switch to a specific world
     */
    public function switchWorld()
    {
        if (!$this->isAdminLoggedIn()) {
            header('Location: admin.php');
            exit;
        }

        $worldDb = $_GET['world'] ?? '';

        // Validate world exists
        if (!$this->isValidWorld($worldDb)) {
            $_SESSION['admin_error'] = __('admin.errors.invalid_world');
            header('Location: admin.php?action=select_world');
            exit;
        }

        // Set current world in session
        $_SESSION['admin_current_world'] = $worldDb;

        // Redirect to admin dashboard
        header('Location: admin.php?action=dashboard');
        exit;
    }

    /**
     * Display admin dashboard for current world
     */
    public function dashboard()
    {
        if (!$this->isAdminLoggedIn()) {
            header('Location: admin.php');
            exit;
        }

        $currentWorld = $_SESSION['admin_current_world'] ?? null;

        if (!$currentWorld) {
            header('Location: admin.php?action=select_world');
            exit;
        }

        // Connect to world database
        $this->db = \App\Core\Database::getInstance($currentWorld);

        // Use AdminScreen to gather data for all modes
        $adminScreen = new \App\Controllers\Screens\AdminScreen(
            ['id' => $_SESSION['admin_id'] ?? 0, 'username' => $_SESSION['admin_username'] ?? '', 'admin' => 1],
            ['id' => 0],
            [],
            $this->db
        );
        
        // Disable header redirects in AdminScreen temporarily or ensure it's bypassed
        $data = $adminScreen->getData();
        $data['is_standalone'] = true;
        // adminBaseUrl logic 
        $data['adminBaseUrl'] = 'admin.php?action=dashboard';

        // Extract variables to be available in the views
        extract($data);
        
        // Also required by the dashboard layout wrapper:
        $stats = $this->getWorldStats();

        require __DIR__ . '/../Views/admin_dashboard.php';
    }

    /**
     * Display global settings page
     */
    public function globalSettings()
    {
        if (!$this->isAdminLoggedIn()) {
            header('Location: admin.php');
            exit;
        }

        // Load current config
        require __DIR__ . '/../../public/configs/config.php';
        $currentTheme = $conf['index_theme'] ?? 'classic';
        $currentIngameTheme = $conf['ingame_theme'] ?? 'classic';

        require __DIR__ . '/../Views/admin_global_settings.php';
    }

    /**
     * Save global settings to config file
     */
    public function saveGlobalSettings()
    {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: admin.php');
            exit;
        }

        $newTheme = $_POST['index_theme'] ?? 'classic';
        if (!in_array($newTheme, ['classic', 'modern'])) {
            $newTheme = 'classic';
        }

        $newIngameTheme = $_POST['ingame_theme'] ?? 'classic';
        $valid_themes = ['classic'];
        $css_dir = __DIR__ . '/../../public/css';
        if (is_dir($css_dir)) {
            $files = scandir($css_dir);
            foreach ($files as $file) {
                if (preg_match('/^game_([a-zA-Z0-9_\-]+)\.css$/', $file, $matches)) {
                    $code = $matches[1];
                    $valid_themes[] = $code;
                }
            }
        }
        if (!in_array($newIngameTheme, $valid_themes)) {
            $newIngameTheme = 'classic';
        }

        $configFile = __DIR__ . '/../../public/configs/config.php';
        $content = file_get_contents($configFile);

        // Simple regex replace for the index_theme setting
        $pattern = "/\\\$conf\['index_theme'\]\s*=\s*['\"].*?['\"];/";
        $replacement = "\$conf['index_theme'] = '$newTheme';";

        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
        } else {
            // Append if not found (shouldn't happen since we added it)
            $content = str_replace('?>', "\$conf['index_theme'] = '$newTheme';\n?>", $content);
        }

        // Simple regex replace for the ingame_theme setting
        $patternIngame = "/\\\$conf\['ingame_theme'\]\s*=\s*['\"].*?['\"];/";
        $replacementIngame = "\$conf['ingame_theme'] = '$newIngameTheme';";

        if (preg_match($patternIngame, $content)) {
            $content = preg_replace($patternIngame, $replacementIngame, $content);
        } else {
            // Append right below the index_theme (or before the end tag)
            if (strpos($content, "\$conf['index_theme'] = '$newTheme';") !== false) {
                $content = str_replace(
                    "\$conf['index_theme'] = '$newTheme';",
                    "\$conf['index_theme'] = '$newTheme';\n\$conf['ingame_theme'] = '$newIngameTheme';",
                    $content
                );
            } else {
                $content = str_replace('?>', "\$conf['ingame_theme'] = '$newIngameTheme';\n?>", $content);
            }
        }

        file_put_contents($configFile, $content);
        if (function_exists('opcache_invalidate')) {
            @opcache_invalidate($configFile, true);
        }

        $_SESSION['admin_success'] = "Configurações guardadas com sucesso!";
        header('Location: admin.php?action=global_settings');
        exit;
    }

    private function isAdminLoggedIn()
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

private function getAvailableWorlds()
{
    $worlds = [];
    $worldsDir = __DIR__ . '/../Config/Worlds';
    
    if (!is_dir($worldsDir)) {
        return $worlds;
    }
    
    $files = scandir($worldsDir);
    
    foreach ($files as $file) {
        // Aceita: 1.php, 2.php, classico1.php, etc.
        if (!preg_match('/^([a-zA-Z]*\d+)\.php$/', $file, $matches)) {
            continue;
        }
        
        $worldId = $matches[1];
        $worldConfigPath = $worldsDir . '/' . $file;
        $worldConfig = include $worldConfigPath;
        
        if (!is_array($worldConfig)) {
            continue;
        }
        
        // Obter credenciais da BD do mundo
        $dbHost = $worldConfig['db_host'] ?? null;
        $dbUser = $worldConfig['db_user'] ?? null;
        $dbPass = $worldConfig['db_pw'] ?? $worldConfig['db_pass'] ?? null;
        $dbName = $worldConfig['db_name'] ?? null;
        
        if (!$dbHost || !$dbName) {
            continue;
        }
        
        // Nome amigável para exibição
        if (preg_match('/^([a-zA-Z]+)(\d+)$/', $worldId, $nameMatch)) {
            $prefix = ucfirst($nameMatch[1]);
            $number = $nameMatch[2];
            $displayName = "$prefix $number";
        } else {
            $displayName = __('admin.world_selector.world_prefix') . ' ' . $worldId;
        }
        
        $isClosed = isset($worldConfig['is_closed']) && $worldConfig['is_closed'] == true;
        
        // Tentar conectar à BD do mundo para obter estatísticas
        $totalUsers = 0;
        $totalVillages = 0;
        $onlineUsers = 0;
        
        if (!$isClosed) {
            try {
                $worldDb = @\mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
                
                if ($worldDb) {
                    \mysqli_set_charset($worldDb, 'utf8');
                    
                    $result = @\mysqli_query($worldDb, "SELECT COUNT(*) as count FROM users");
                    if ($result) {
                        $row = \mysqli_fetch_assoc($result);
                        $totalUsers = (int)($row['count'] ?? 0);
                    }
                    
                    $result = @\mysqli_query($worldDb, "SELECT COUNT(*) as count FROM villages");
                    if ($result) {
                        $row = \mysqli_fetch_assoc($result);
                        $totalVillages = (int)($row['count'] ?? 0);
                    }
                    
                    $result = @\mysqli_query($worldDb, "SELECT COUNT(*) as count FROM users WHERE last_activity > " . (time() - 300));
                    if ($result) {
                        $row = \mysqli_fetch_assoc($result);
                        $onlineUsers = (int)($row['count'] ?? 0);
                    }
                    
                    \mysqli_close($worldDb);
                }
            } catch (\Exception $e) {
                // Ignorar erros de conexão
            }
        }
        
        $worlds[] = [
            'db_name' => $dbName,
            'world_id' => $worldId,
            'display_name' => $displayName,
            'total_users' => $totalUsers,
            'total_villages' => $totalVillages,
            'online_users' => $onlineUsers,
            'is_closed' => $isClosed
        ];
    }
    
    // Ordenar por número do mundo
    usort($worlds, function ($a, $b) {
        preg_match('/\d+/', $a['world_id'], $numA);
        preg_match('/\d+/', $b['world_id'], $numB);
        $numA = isset($numA[0]) ? (int)$numA[0] : 0;
        $numB = isset($numB[0]) ? (int)$numB[0] : 0;
        return $numA - $numB;
    });
    
    return $worlds;
}

/**
 * Validate if world database exists
 */
private function isValidWorld($worldDb)
{
    // Sanitize database name
    $worldDb = preg_replace('/[^a-zA-Z0-9_]/', '', $worldDb);
    
    $worldsDir = __DIR__ . '/../Config/Worlds';
    
    if (!is_dir($worldsDir)) {
        return false;
    }
    
    $files = scandir($worldsDir);
    
    foreach ($files as $file) {
        if (!preg_match('/^([a-zA-Z]*\d+)\.php$/', $file)) {
            continue;
        }
        
        $worldConfig = include $worldsDir . '/' . $file;
        
        if (is_array($worldConfig) && isset($worldConfig['db_name']) && $worldConfig['db_name'] === $worldDb) {
            return true;
        }
    }
    
    return false;
}

    /**
     * Get statistics for current world
     */
    private function getWorldStats()
    {
        return [
            'total_users' => $this->db->fetch("SELECT COUNT(*) as count FROM users")['count'] ?? 0,
            'total_villages' => $this->db->fetch("SELECT COUNT(*) as count FROM villages")['count'] ?? 0,
            'total_allies' => $this->db->fetch("SELECT COUNT(*) as count FROM ally")['count'] ?? 0,
            'online_users' => $this->db->fetch(
                "SELECT COUNT(*) as count FROM users WHERE last_activity > ?",
                [time() - 300]
            )['count'] ?? 0,
        ];
    }
}
