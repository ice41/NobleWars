<?php
require_once __DIR__ . '/database.php';

try {
    $host = $conf['db_host'] ?? 'localhost';
    $user = $conf['db_user'] ?? 'root';
    $pass = $conf['db_pass'] ?? '';
    
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Find all world databases
    $stmt = $pdo->query("SHOW DATABASES LIKE 'lan_%'");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($databases)) {
        echo "No world databases found matching 'lan_%'.\n";
        exit;
    }
    
    foreach ($databases as $dbName) {
        echo "Optimizing database: $dbName\n";
        $pdo->exec("USE `$dbName`");
        
        // 1. Add composite index on events(event_type, event_id)
        $hasIndex = false;
        $idxStmt = $pdo->query("SHOW INDEX FROM events");
        while ($row = $idxStmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Key_name'] === 'idx_event_type_id') {
                $hasIndex = true;
                break;
            }
        }
        if (!$hasIndex) {
            echo " - Creating composite index idx_event_type_id on events(event_type, event_id)...\n";
            $pdo->exec("CREATE INDEX idx_event_type_id ON events (event_type, event_id)");
        } else {
            echo " - Index idx_event_type_id already exists on events.\n";
        }
        
        // 2. Add index on recruit(time_finished)
        $hasIndex = false;
        $idxStmt = $pdo->query("SHOW INDEX FROM recruit");
        while ($row = $idxStmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Key_name'] === 'idx_recruit_time_finished') {
                $hasIndex = true;
                break;
            }
        }
        if (!$hasIndex) {
            echo " - Creating index idx_recruit_time_finished on recruit(time_finished)...\n";
            $pdo->exec("CREATE INDEX idx_recruit_time_finished ON recruit (time_finished)");
        } else {
            echo " - Index idx_recruit_time_finished already exists on recruit.\n";
        }
        
        // 3. Add index on research(end_time)
        $hasIndex = false;
        $idxStmt = $pdo->query("SHOW INDEX FROM research");
        while ($row = $idxStmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Key_name'] === 'idx_research_end_time') {
                $hasIndex = true;
                break;
            }
        }
        if (!$hasIndex) {
            echo " - Creating index idx_research_end_time on research(end_time)...\n";
            $pdo->exec("CREATE INDEX idx_research_end_time ON research (end_time)");
        } else {
            echo " - Index idx_research_end_time already exists on research.\n";
        }

        // 4. Add index on users(points)
        $hasIndex = false;
        $idxStmt = $pdo->query("SHOW INDEX FROM users");
        while ($row = $idxStmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Key_name'] === 'idx_users_points') {
                $hasIndex = true;
                break;
            }
        }
        if (!$hasIndex) {
            echo " - Creating index idx_users_points on users(points)...\n";
            $pdo->exec("CREATE INDEX idx_users_points ON users (points)");
        } else {
            echo " - Index idx_users_points already exists on users.\n";
        }
    }
    echo "All database optimizations applied successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
