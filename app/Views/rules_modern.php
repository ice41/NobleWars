<?php
/**
 * REGRAS MODERNAS - Noblewars
 */
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('public.rules.title') ?> - Noblewars</title>
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Outfit:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --medieval-gold: #c2b280; --medieval-brown: #3e2723; --parchment: #f4e4bc; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif; background: #2b1d12; color: #f4e4bc;
            background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5)), url('graphic/index/bg_modern.png');
            background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh;
        }

        .navbar {
            display: flex; justify-content: space-between; align-items: center; padding: 15px 5%;
            background: rgba(43, 29, 18, 0.8); border-bottom: 2px solid var(--medieval-gold);
            box-shadow: 0 5px 20px rgba(0,0,0,0.4); backdrop-filter: blur(8px);
            position: sticky; top: 0; z-index: 1000;
        }
        .logo { font-family: 'MedievalSharp', cursive; font-size: 28px; color: var(--medieval-gold); text-decoration: none; text-shadow: 2px 2px 0 #000; }
        .nav-links a { margin-left: 20px; color: white; text-decoration: none; font-size: 14px; font-weight: bold; opacity: 0.8; }

        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }

        .rules-header { text-align: center; margin-bottom: 40px; }
        .rules-header h1 { font-family: 'MedievalSharp', cursive; font-size: 48px; color: var(--medieval-gold); text-shadow: 3px 3px 0 #000; margin-bottom: 10px; }
        .rules-header p { font-size: 18px; opacity: 0.9; }

        .rule-section {
            background: rgba(43, 29, 18, 0.6); border: 1px solid var(--medieval-gold);
            border-radius: 12px; margin-bottom: 20px; overflow: hidden; backdrop-filter: blur(5px);
            transition: 0.3s;
        }
        .rule-section:hover { background: rgba(43, 29, 18, 0.8); border-color: #fff; }

        .rule-header {
            padding: 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;
        }
        .rule-header h2 { font-family: 'MedievalSharp', cursive; font-size: 20px; color: var(--medieval-gold); }
        .rule-header i { transition: 0.3s; }
        .rule-header.active i { transform: rotate(180deg); }

        .rule-content {
            padding: 0 20px 20px; display: none; line-height: 1.6; color: #f4e4bc; border-top: 1px solid rgba(194, 178, 128, 0.2);
            padding-top: 20px;
        }
        .rule-content.active { display: block; }

        .footer { text-align: center; padding: 40px; opacity: 0.7; font-size: 14px; }
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
        <div class="rules-header">
            <h1><i class="fas fa-scroll"></i> <?= __('public.rules.reign_rules') ?></h1>
            <p><?= __('public.rules.description') ?></p>
        </div>

        <?php if (!empty($rules)): ?>
            <?php foreach ($rules as $rule): ?>
                <div class="rule-section">
                    <div class="rule-header" onclick="toggleRule(this)">
                        <h2><?= htmlspecialchars($rule['section']) ?> - <?= htmlspecialchars($rule['title']) ?></h2>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="rule-content">
                        <p><?= nl2br(htmlspecialchars($rule['content'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="rule-section" style="padding: 40px; text-align: center;">
                <p><?= __('public.rules.no_rules') ?></p>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" style="color: var(--medieval-gold); text-decoration: none; font-weight: bold;">
                <i class="fas fa-arrow-left"></i> <?= __('public.rules.back_to_home') ?>
            </a>
        </div>
    </div>

    <footer class="footer">
        &copy; <?= date('Y') ?> by Ice41 - Nobles Wars
        <div style="margin-top: 10px; font-size: 13px;">
            <a href="privacy.php" style="color: var(--medieval-gold); text-decoration: none; font-weight: bold;">Política de Privacidade</a>
        </div>
    </footer>

    <script>
        function toggleRule(header) {
            const content = header.nextElementSibling;
            header.classList.toggle('active');
            content.classList.toggle('active');
        }
    </script>
    <?php include __DIR__ . '/components/cookie_banner.php'; ?>
</body>
</html>
