<?php
/**
 * EQUIPA MODERNA - Noblewars
 */
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('public.team.title') ?> - Noblewars</title>
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Outfit:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --medieval-gold: #c2b280; --medieval-brown: #3e2723; --parchment: #f4e4bc; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #2b1d12;
            color: #f4e4bc;
            overflow-y: auto;
            /* Alterado de hidden para permitir scroll no mobile */
            background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.4)), url('graphic/index/bg_modern2.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            /* Alterado de height para min-height */
            display: flex;
            flex-direction: column;
        }

        .navbar {
            display: flex; justify-content: space-between; align-items: center; padding: 15px 5%;
            background: rgba(43, 29, 18, 0.8); border-bottom: 2px solid var(--medieval-gold);
            box-shadow: 0 5px 20px rgba(0,0,0,0.4); backdrop-filter: blur(8px);
        }
        .logo { font-family: 'MedievalSharp', cursive; font-size: 28px; color: var(--medieval-gold); text-decoration: none; text-shadow: 2px 2px 0 #000; }
        .nav-links a { margin-left: 20px; color: white; text-decoration: none; font-size: 14px; font-weight: bold; opacity: 0.8; }

        .container { max-width: 900px; margin: 60px auto; padding: 0 20px; }

        .team-card {
            background: rgba(43, 29, 18, 0.7); border: 2px solid var(--medieval-gold);
            border-radius: 15px; padding: 40px; backdrop-filter: blur(10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        h1 { font-family: 'MedievalSharp', cursive; font-size: 42px; color: var(--medieval-gold); text-align: center; margin-bottom: 20px; }
        .subtitle { text-align: center; opacity: 0.8; margin-bottom: 40px; line-height: 1.6; }

        .team-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .team-table th { text-align: left; padding: 15px; border-bottom: 2px solid var(--medieval-gold); color: var(--medieval-gold); font-family: 'MedievalSharp', cursive; font-size: 18px; }
        .team-table td { padding: 15px; border-bottom: 1px solid rgba(194, 178, 128, 0.2); font-size: 16px; }
        .team-table tr:hover td { background: rgba(255,255,255,0.05); }

        .role-badge { 
            display: inline-block; padding: 4px 12px; border-radius: 20px; 
            background: rgba(194, 178, 128, 0.2); border: 1px solid var(--medieval-gold);
            font-size: 12px; font-weight: bold; color: var(--medieval-gold);
        }

        .footer { text-align: center; padding: 40px; opacity: 0.6; font-size: 14px; margin-top: 40px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo"><img width="80" height="80" src="graphic/index/noblewars.png" alt="Noblewars Logo" ></a>
        <div class="nav-links">
            <?php foreach ($linki as $link => $value): ?>
                <a href="<?= $link ?>"><?= $value ?></a>
            <?php endforeach; ?>
            <div style="margin-left: 20px; display: inline-block;">
                <?php include __DIR__ . '/components/language_selector_public.php'; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="team-card">
            <h1><i class="fas fa-shield-halved"></i> <?= __('public.team.guardians') ?></h1>
            <p class="subtitle"><?= __('public.team.support_note') ?></p>

            <table class="team-table">
                <thead>
                    <tr>
                        <th><?= __('public.team.member') ?></th>
                        <th><?= __('public.team.role') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fas fa-crown" style="color: gold; margin-right: 10px;"></i> Admin</td>
                        <td><span class="role-badge"><?= __('public.team.global_admin') ?></span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-gavel" style="color: silver; margin-right: 10px;"></i> Moderador</td>
                        <td><span class="role-badge"><?= __('public.team.game_mod') ?></span></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-code" style="color: #4fc3f7; margin-right: 10px;"></i> Ice41</td>
                        <td><span class="role-badge"><?= __('public.team.tech_dev') ?></span></td>
                    </tr>
                </tbody>
            </table>

            <p style="margin-top: 30px; font-size: 13px; opacity: 0.7; text-align: center;">
                <?= __('public.team.footer_note') ?>
            </p>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" style="color: var(--medieval-gold); text-decoration: none; font-weight: bold;">
                <i class="fas fa-arrow-left"></i> <?= __('public.team.back_to_home') ?>
            </a>
        </div>
    </div>

    <footer class="footer">
        &copy; <?= date('Y') ?> by Ice41 - Nobles Wars
    </footer>
</body>
</html>
