<?php
/**
 * RECUPERAÇÃO DE SENHA MODERNA - Noblewars
 * Layout de ecrã inteiro com fundo cinematográfico.
 */
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('public.password_recovery.page_title') ?> | Noblewars</title>
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Outfit:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --medieval-gold: #c2b280; --medieval-brown: #3e2723; --parchment: #f4e4bc; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif; background: #2b1d12; color: #f4e4bc;
            background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5)), url('graphic/index/bg_modern.png');
            background-size: cover; background-position: center; background-attachment: fixed;
            min-height: 100vh; display: flex; flex-direction: column; overflow: hidden;
        }

        .navbar {
            display: flex; justify-content: space-between; align-items: center; width: 100%;
            padding: 15px 5%; background: rgba(43, 29, 18, 0.8);
            border-bottom: 2px solid var(--medieval-gold);
            box-shadow: 0 5px 20px rgba(0,0,0,0.4); backdrop-filter: blur(8px);
            position: sticky; top: 0; z-index: 1000;
        }
        .logo { font-family: 'MedievalSharp', cursive; font-size: 28px; color: var(--medieval-gold); text-decoration: none; text-shadow: 2px 2px 0 #000; }
        .nav-links a { margin-left: 20px; color: white; text-decoration: none; font-size: 14px; font-weight: bold; opacity: 0.8; }
        .nav-links a:hover { opacity: 1; color: var(--medieval-gold); }

        .main-content {
            flex: 1; display: flex; align-items: center; justify-content: center; width: 100%; padding: 20px;
        }

        .recovery-card {
            background-color: var(--parchment);
            background-image: radial-gradient(circle at center, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0) 70%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.1'/%3E%3C/svg%3E");
            border: 3px solid var(--medieval-gold); border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), inset 0 0 40px rgba(160, 82, 45, 0.2);
            padding: 30px; width: 100%; max-width: 480px; color: var(--medieval-brown);
            position: relative; transform: rotate(-0.5deg);
        }

        .recovery-card::before {
            content: ""; position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;
            border: 1px solid rgba(93, 64, 55, 0.2); border-radius: 8px; pointer-events: none;
        }

        h2 { font-family: 'MedievalSharp', cursive; font-size: 36px; text-align: center; margin-bottom: 25px; border-bottom: 2px solid #8c5f0d; padding-bottom: 10px; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; font-family: 'MedievalSharp', cursive; font-size: 16px; margin-bottom: 5px; font-weight: bold; }
        
        input {
            width: 100%; padding: 12px; background: #e6d5ac; border: 2px solid #5d4037;
            border-radius: 4px; color: #2d1b10; font-family: 'MedievalSharp', cursive; font-size: 16px;
            outline: none; transition: 0.3s;
        }
        input:focus { border-color: #8b5a2b; box-shadow: 0 0 8px rgba(139, 90, 43, 0.3); }

        .medieval-button {
            display: block; width: 100%; height: 50px; line-height: 50px;
            background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 50%, #5d4037 100%);
            border: 2px solid #3e2723; border-radius: 4px; color: #f5f5dc;
            font-family: 'MedievalSharp', cursive; font-size: 24px; text-align: center;
            text-decoration: none; text-shadow: 2px 2px 2px #000; cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.4); margin-top: 25px; transition: 0.2s;
        }
        .medieval-button:hover { transform: translateY(-2px); filter: brightness(1.1); }

        .back-link { display: block; text-align: center; margin-top: 20px; color: #7d510f; font-weight: bold; text-decoration: none; font-size: 14px; }
        .back-link:hover { text-decoration: underline; }

        .error-box { background: rgba(139, 35, 35, 0.1); border: 1px solid #8b2323; color: #8b2323; padding: 10px; border-radius: 4px; margin-bottom: 20px; font-weight: bold; text-align: center; }
        .success-box { background: rgba(46, 125, 50, 0.1); border: 1px solid #2e7d32; color: #2e7d32; padding: 10px; border-radius: 4px; margin-bottom: 20px; font-weight: bold; text-align: center; }

        .footer-info { position: fixed; bottom: 20px; color: var(--medieval-gold); font-size: 12px; opacity: 0.7; }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.php" class="logo"><img width="80" height="80" src="graphic/index/noblewars.png" alt="Noblewars Logo" ></a>
        <div class="nav-links">
            <?php foreach ($linki as $link => $value): ?>
                <a href="<?= $link ?>"><?= $value ?></a>
            <?php endforeach; ?>
            <div style="margin-left: 20px; display: inline-block; vertical-align: middle;">
                <?php include __DIR__ . '/components/language_selector_public.php'; ?>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="recovery-card">
            <h2><?= __('public.password_recovery.heading') ?></h2>

            <?php if (!empty($message)): ?>
                <div class="success-box"><i class="fas fa-check-circle"></i> <?= $message ?></div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="error-box"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> <?= __('public.password_recovery.email_label') ?></label>
                    <input type="email" id="email" name="email" required placeholder="<?= __('public.password_recovery.email_placeholder') ?>" autofocus>
                </div>

                <button class="medieval-button" type="submit"><?= __('public.password_recovery.submit_button') ?></button>
            </form>

            <a href="index.php" class="back-link"> <?= __('public.password_recovery.back_to_login') ?></a>
        </div>
    </div>

    <div class="footer-info">
        &copy; <?= date('Y') ?> by Ice41 - Nobles Wars
    </div>

</body>
</html>
