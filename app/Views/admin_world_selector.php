<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('admin.world_selector.title') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Verdana, Arial, sans-serif;
            background: url('graphic/background/bg-admin-ice41.jpg') repeat;
            background-color: #1a1410;
            min-height: 100vh;
            padding: 40px 20px;
            color: #3b260e;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #e8d0a9;
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px #000;
            margin-bottom: 10px;
        }

        .header .welcome {
            color: #cbb286;
            font-size: 14px;
        }

        .header .logout-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background: #6e1c1c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .header .logout-btn:hover {
            background: #8b2323;
        }

        .worlds-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .worlds-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .world-card {
            background: url('graphic/background/bg-admin-ice41.jpg') repeat;
            background-color: #2b1d12;
            border: 3px solid #8b6c42;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .world-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.4);
            border-color: #d4af37;
        }

        .world-header {
            background: linear-gradient(135deg, #4a331c, #2b1d12);
            padding: 20px;
            border-bottom: 2px solid #8b6c42;
            text-align: center;
        }

        .world-header h2 {
            color: #e8d0a9;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 1px 1px 3px #000;
        }

        .world-header .world-db {
            color: #8b6c42;
            font-size: 11px;
            margin-top: 5px;
        }

        .world-body {
            padding: 25px;
            background: rgba(240, 230, 210, 0.95);
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #dcd0b8;
        }

        .stat-row:last-child {
            border-bottom: none;
        }

        .stat-label {
            color: #5c3a1e;
            font-size: 13px;
            font-weight: bold;
        }

        .stat-label i {
            margin-right: 8px;
            width: 18px;
            text-align: center;
            color: #8b6c42;
        }

        .stat-value {
            color: #3b260e;
            font-size: 16px;
            font-weight: bold;
        }

        .stat-value.online {
            color: #2d7a2d;
        }

        .world-footer {
            padding: 15px;
            background: rgba(43, 29, 18, 0.5);
            border-top: 1px solid #8b6c42;
            text-align: center;
        }

        .enter-btn {
            display: inline-block;
            padding: 10px 30px;
            background: linear-gradient(to bottom, #8b2323, #6e1c1c);
            color: white;
            border: 2px solid #4a0d0d;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .world-card:hover .enter-btn {
            background: linear-gradient(to bottom, #a02828, #8b2323);
            box-shadow: 0 0 10px rgba(139, 35, 35, 0.6);
        }

        .no-worlds {
            text-align: center;
            padding: 60px 20px;
            background: rgba(240, 230, 210, 0.95);
            border: 2px solid #8b6c42;
            border-radius: 8px;
        }

        .no-worlds i {
            font-size: 48px;
            color: #8b6c42;
            margin-bottom: 20px;
        }

        .no-worlds h3 {
            color: #5c3a1e;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .no-worlds p {
            color: #7a5a3a;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1><i class="fas fa-globe"></i> <?= __('admin.world_selector.heading') ?></h1>
        <div class="welcome">
            <?= __('admin.world_selector.welcome') ?>
            <strong><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></strong>
        </div>
        <a href="admin.php?action=global_settings" class="logout-btn"
            style="background: #4a331c; border: 1px solid #8b6c42;">
            <i class="fas fa-cog"></i> Configurações Globais
        </a>
        <a href="admin.php?action=logout" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> <?= __('admin.world_selector.logout') ?>
        </a>
    </div>

    <?php if (isset($_SESSION['admin_error'])): ?>
        <div
            style="max-width: 800px; margin: -20px auto 30px auto; background: rgba(110, 28, 28, 0.9); border: 2px solid #8b6c42; border-radius: 6px; padding: 15px; text-align: center; color: #e8d0a9; font-size: 13px; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
            <i class="fas fa-exclamation-triangle" style="color: #ffc107; margin-right: 8px;"></i>
            <?= htmlspecialchars($_SESSION['admin_error']) ?>
        </div>
        <?php unset($_SESSION['admin_error']); ?>
    <?php endif; ?>

    <div class="worlds-container">
        <?php if (empty($worlds)): ?>
            <div class="no-worlds">
                <i class="fas fa-exclamation-circle"></i>
                <h3><?= __('admin.world_selector.no_worlds') ?></h3>
                <p><?= __('admin.world_selector.no_worlds_desc') ?></p>
            </div>
        <?php else: ?>
            <div class="worlds-grid">
                <?php foreach ($worlds as $index => $world): ?>
                    <?php
                    $isFreeLocked = (\App\Core\Database::getLicenseType() === 'free' && $index > 0);
                    if ($isFreeLocked):
                        ?>
                        <div class="world-card"
                            style="opacity: 0.6; filter: grayscale(0.8); cursor: not-allowed; position: relative;"
                            onclick="alert('Este mundo está bloqueado porque a licença do seu servidor é Gratuita (Free), permitindo apenas 1 mundo ativo. Atualize para Gold ou Diamond no Noblewars.')">
                            <div class="world-header" style="background: #2b1d12;">
                                <h2><?= htmlspecialchars($world['display_name']) ?></h2>
                                <div class="world-db"><?= htmlspecialchars($world['db_name']) ?> (🔒 FREE LOCK)</div>
                            </div>

                            <div class="world-body">
                                <div class="stat-row">
                                    <div class="stat-label">
                                        <i class="fas fa-users"></i> <?= __('admin.stats.total_players') ?>
                                    </div>
                                    <div class="stat-value"><?= number_format($world['total_users']) ?></div>
                                </div>

                                <div class="stat-row">
                                    <div class="stat-label">
                                        <i class="fas fa-home"></i> <?= __('admin.stats.total_villages') ?>
                                    </div>
                                    <div class="stat-value"><?= number_format($world['total_villages']) ?></div>
                                </div>

                                <div class="stat-row">
                                    <div class="stat-label">
                                        <i class="fas fa-circle"></i> <?= __('admin.stats.online_players') ?>
                                    </div>
                                    <div class="stat-value"><?= number_format($world['online_users']) ?></div>
                                </div>
                            </div>

                            <div class="world-footer">
                                <span class="enter-btn"
                                    style="background: linear-gradient(to bottom, #5c432d, #423020); border-color: #2b1d12; color: #8c735d;">
                                    <i class="fas fa-lock"></i> REQUER GOLD/DIAMOND
                                </span>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="admin.php?action=switch_world&world=<?= urlencode($world['db_name']) ?>" class="world-card">
                            <div class="world-header">
                                <h2><?= htmlspecialchars($world['display_name']) ?></h2>
                                <div class="world-db"><?= htmlspecialchars($world['db_name']) ?></div>
                            </div>

                            <div class="world-body">
                                <div class="stat-row">
                                    <div class="stat-label">
                                        <i class="fas fa-users"></i> <?= __('admin.stats.total_players') ?>
                                    </div>
                                    <div class="stat-value"><?= number_format($world['total_users']) ?></div>
                                </div>

                                <div class="stat-row">
                                    <div class="stat-label">
                                        <i class="fas fa-home"></i> <?= __('admin.stats.total_villages') ?>
                                    </div>
                                    <div class="stat-value"><?= number_format($world['total_villages']) ?></div>
                                </div>

                                <div class="stat-row">
                                    <div class="stat-label">
                                        <i class="fas fa-circle"></i> <?= __('admin.stats.online_players') ?>
                                    </div>
                                    <div class="stat-value online"><?= number_format($world['online_users']) ?></div>
                                </div>
                            </div>

                            <div class="world-footer">
                                <span class="enter-btn">
                                    <i class="fas fa-sign-in-alt"></i> <?= __('admin.world_selector.manage_world') ?>
                                </span>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>