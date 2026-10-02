<?php
/**
 * PRIVACIDADE MODERNA - Noblewars
 */
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('privacy.title') ?> - Noblewars</title>
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
            background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5)), url('graphic/index/bg_modern.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .navbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 5%; background: rgba(43, 29, 18, 0.8);
            border-bottom: 2px solid var(--medieval-gold);
            box-shadow: 0 5px 20px rgba(0,0,0,0.4);
            backdrop-filter: blur(8px);
            position: sticky; top: 0; z-index: 1000;
        }
        .logo { font-family: 'MedievalSharp', cursive; font-size: 28px; color: var(--medieval-gold); text-decoration: none; text-shadow: 2px 2px 0 #000; }
        .nav-links a { margin-left: 20px; color: white; text-decoration: none; font-size: 14px; font-weight: bold; opacity: 0.8; }
        .nav-links a:hover { opacity: 1; color: var(--medieval-gold); }

        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }

        .privacy-header { text-align: center; margin-bottom: 40px; }
        .privacy-header h1 { font-family: 'MedievalSharp', cursive; font-size: 48px; color: var(--medieval-gold); text-shadow: 3px 3px 0 #000; margin-bottom: 10px; }
        .privacy-header p { font-size: 16px; opacity: 0.8; }

        .privacy-card {
            background: rgba(43, 29, 18, 0.7);
            border: 1px solid var(--medieval-gold);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            line-height: 1.7;
        }

        .privacy-card h2 {
            font-family: 'MedievalSharp', cursive;
            color: var(--medieval-gold);
            font-size: 22px;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(194, 178, 128, 0.3);
            padding-bottom: 8px;
        }

        .privacy-card p { margin-bottom: 12px; }
        .privacy-card ul { padding-left: 20px; margin: 10px 0; }
        .privacy-card li { margin-bottom: 8px; }
        .privacy-card a { color: var(--medieval-gold); text-decoration: none; }
        .privacy-card a:hover { text-decoration: underline; }

        .email-placeholder { font-weight: bold; color: var(--medieval-gold); }

        .back-link { text-align: center; margin: 30px 0; }
        .back-link a { color: var(--medieval-gold); text-decoration: none; font-weight: bold; }

        .footer { text-align: center; padding: 40px; opacity: 0.7; font-size: 14px; }
        .footer-privacy-link { display: block; margin-top: 8px; color: var(--medieval-gold); text-decoration: none; }
        .footer-privacy-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo"><img width="80" height="80" src="graphic/index/noblewars.png" alt="Noblewars Logo"></a>
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
        <div class="privacy-header">
            <h1><i class="fas fa-shield-alt"></i> <?= __('privacy.title') ?></h1>
            <p><?= __('privacy.last_updated') ?> <?= date('Y-m-d') ?></p>
        </div>

        <?php foreach (['intro', 'controller', 'collect', 'legal_basis', 'use', 'share', 'international', 'storage', 'retention', 'cookies', 'cookie_table', 'rights', 'exercise_rights', 'automated', 'minors', 'third_parties', 'account_deletion', 'breach', 'security', 'changes', 'contact'] as $section): ?>
            <div class="privacy-card">
                <h2><?= __('privacy.sections.' . $section . '.title') ?></h2>
                <?= __('privacy.sections.' . $section . '.content') ?>
            </div>
        <?php endforeach; ?>

        <div class="back-link">
            <a href="index.php"><i class="fas fa-arrow-left"></i> <?= __('privacy.back_home') ?></a>
        </div>
    </div>

    <footer class="footer">
        &copy; <?= date('Y') ?> <?= __('privacy.footer_copyright') ?>
        <a href="privacy.php" class="footer-privacy-link"><?= __('privacy.title') ?></a>
    </footer>

    <?php include __DIR__ . '/components/cookie_banner.php'; ?>

    <script>
        (function() {
            var u = 'geral';
            var d = 'ice41.pt';
            document.querySelectorAll('.email-placeholder').forEach(function(el) {
                var a = document.createElement('a');
                a.href = 'mailto:' + u + '@' + d;
                a.textContent = u + '@' + d;
                a.style.color = '#c2b280';
                a.style.fontWeight = 'bold';
                el.innerHTML = '';
                el.appendChild(a);
            });
        })();
    </script>
</body>
</html>
