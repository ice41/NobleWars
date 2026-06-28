<?php
/**
 * TEMA MODERNO MEDIEVAL - Noblewars
 * O layout moderno com o icónico login clássico de pergaminho.
 */
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noblewars | O Despertar dos Reis</title>
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Outfit:wght@300;400;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --medieval-gold: #c2b280;
            --medieval-brown: #3e2723;
            --parchment: #f4e4bc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        /* Navbar Elegante */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            background: rgba(43, 29, 18, 0.6);
            border-bottom: 2px solid var(--medieval-gold);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
        }

        .logo {
            font-family: 'MedievalSharp', cursive;
            font-size: 32px;
            color: var(--medieval-gold);
            text-decoration: none;
            text-shadow: 2px 2px 0 #000;
            letter-spacing: 2px;
        }

        .nav-links a {
            margin-left: 25px;
            color: white;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            transition: 0.3s;
            opacity: 0.8;
        }

        .nav-links a:hover {
            opacity: 1;
            color: var(--medieval-gold);
            transform: translateY(-2px);
        }

        .main-container {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            padding: 40px 5% 20px 5%;
            align-items: start;
            max-width: 1400px;
            margin: 0 auto;
            flex: 1;
            overflow: visible;
            position: relative;
            /* Necessário para o login-block usar position: absolute */
        }

        /* Texto Hero Moderno */
        .hero-text h1 {
            font-family: 'MedievalSharp', cursive;
            font-size: 54px;
            line-height: 1.0;
            margin-bottom: 15px;
            color: #fff;
            text-shadow: 4px 4px 0 rgba(0, 0, 0, 0.5);
        }

        .hero-text p {
            font-size: 16px;
            line-height: 1.4;
            opacity: 0.9;
            margin-bottom: 25px;
            max-width: 500px;
        }

        /* LOGIN CLÁSSICO DE PERGAMINHO (Estilos preservados da index clássica) */
        .login-block {
            background-color: var(--parchment);
            background-image:
                radial-gradient(circle at center, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0) 70%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.1'/%3E%3C/svg%3E");
            border: 2px solid var(--medieval-gold);
            border-radius: 8px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.6), inset 0 0 40px rgba(160, 82, 45, 0.2);
            padding: 25px !important;
            width: 100%;
            max-width: 340px;
            color: var(--medieval-brown);
            font-family: 'MedievalSharp', cursive;
            position: absolute;
            top: 170px;
            left: 60%;
            /* Um pouco mais à direita */
            transform: rotate(0.5deg);
            z-index: 10;
        }

        .login-block::after {
            content: "";
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 1px solid rgba(93, 64, 55, 0.2);
            border-radius: 4px;
            pointer-events: none;
        }

        .login-block h2 {
            font-size: 28px;
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #8c5f0d;
            padding-bottom: 5px;
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
        }

        .login-block label strong {
            display: block;
            font-size: 15px;
            margin-bottom: 5px;
            font-weight: normal;
        }

        .medieval-input {
            width: 100%;
            padding: 8px 12px;
            margin-bottom: 12px;
            background: #e6d5ac;
            border: 2px solid #5d4037;
            border-radius: 4px;
            color: #2d1b10;
            font-family: 'MedievalSharp', cursive;
            font-size: 16px;
            box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.2);
            outline: none;
        }

        /* Botão de Madeira Clássico */
        .medieval-button {
            display: block;
            width: 100%;
            height: 40px;
            line-height: 40px;
            background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 50%, #5d4037 100%);
            border: 2px solid #3e2723;
            border-radius: 4px;
            color: #f5f5dc !important;
            font-family: 'MedievalSharp', cursive;
            font-size: 20px;
            text-align: center;
            text-decoration: none !important;
            text-shadow: 2px 2px 2px #000;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            transition: 0.2s;
        }

        .medieval-button:hover {
            background: linear-gradient(to bottom, #a16b35 0%, #7e584a 50%, #6d4c41 100%);
            transform: translateY(-2px);
        }

        /* Seção de Notícias - faixa centrada abaixo da grelha principal */
        .news-section {
            background: rgba(43, 29, 18, 0.7);
            padding: 25px 40px;
            border-radius: 12px;
            border: 1px solid var(--medieval-gold);
            backdrop-filter: blur(8px);
            max-height: 320px;
            overflow-y: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 1000px;
            margin: 0 auto 30px auto;
        }

        .news-title {
            font-family: 'MedievalSharp', cursive;
            font-size: 22px;
            color: var(--medieval-gold);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-bottom: 1px solid rgba(194, 178, 128, 0.3);
            padding-bottom: 5px;
        }

        .news-slider {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .news-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid rgba(194, 178, 128, 0.2);
            text-align: center;
        }

        .news-card h3 {
            font-family: 'MedievalSharp', cursive;
            color: white;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .news-card span {
            font-size: 11px;
            opacity: 0.6;
            display: block;
            margin-bottom: 8px;
        }

        .news-card p {
            font-size: 13px;
            line-height: 1.5;
            color: #f4e4bc;
        }

        .theme-switcher {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            background: var(--medieval-brown);
            color: var(--parchment);
            padding: 12px 25px;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'MedievalSharp', cursive;
            border: 2px solid var(--medieval-gold);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            transition: 0.3s;
        }

        .theme-switcher:hover {
            background: #5d4037;
            transform: scale(1.05);
        }

        .world-scroll {
            max-height: 250px;
            overflow-y: auto;
            padding-right: 10px;
            margin-bottom: 20px;
        }

        .world-item {
            margin-bottom: 12px;
        }

        @media (max-width: 1000px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .nav-links {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            .nav-links a {
                margin-left: 0;
            }

            .main-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 38px;
            }

            .hero-text p {
                margin: 0 auto 30px auto;
            }

            .login-block {
                margin: 0 auto;
            }

            .news-section {
                width: 100%;
                margin-top: 30px;
            }
        }

        @media (max-width: 600px) {
            .hero-text h1 {
                font-size: 32px;
            }

            .medieval-button {
                font-size: 16px;
            }

            .login-block {
                padding: 15px !important;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="index.php" class="logo"><img width="80" height="80" src="graphic/index/noblewars.png"
                alt="Noblewars Logo"></a>
        <div class="nav-links">
            <?php foreach ($linki as $link => $value): ?>
                <a href="<?= $link ?>"><?= $value ?></a>
            <?php endforeach; ?>
            <div style="margin-left: 20px; display: inline-block; vertical-align: middle;">
                <?php include __DIR__ . '/components/language_selector_public.php'; ?>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="hero-text">
            <h1><?= __('public.index.heading') ?></h1>
            <p><?= __('public.index.description') ?></p>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <a href="register.php" class="medieval-button"
                    style="width: auto; padding: 0 40px; background: linear-gradient(to bottom, #4a6b35 0%, #3e582a 50%, #2d4017 100%);">
                    <?= __('public.index.register_now') ?>
                </a>
                <div style="line-height: 50px; font-weight: bold; color: var(--medieval-gold);">
                    <i class="fas fa-users"></i> <?= __('public.index.registered_accounts', ['count' => $players]) ?>
                </div>
            </div>
        </div>

    </div>

    <!-- O LOGIN CLÁSSICO DE PERGAMINHO DENTRO DO LAYOUT MODERNO -->
    <div class="login-block">
        <h2><?= __('public.index.login') ?></h2>

        <?php if ($can_log): ?>
            <form action="index.php?action=login" method="post" id="login_form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <label>
                    <strong><?= __('public.index.username') ?></strong>
                    <input type="text" name="user" class="medieval-input" required
                        style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22%235d4037%22><path d=%22M20.41 3.03l-9.53 9.53 2.83 2.83 9.53-9.53-2.83-2.83zm-12.02 12.02l2.83 2.83-1.42 1.42-2.83-2.83 1.42-1.42zm-5.66 5.66l1.42 1.42-2.83 2.83-1.42-1.42 2.83-2.83z%22/></svg>'); background-repeat: no-repeat; background-position: 96% center; background-size: 18px;">
                </label>
                <label>
                    <strong><?= __('public.index.password') ?></strong>
                    <input type="password" name="password" class="medieval-input" required>
                </label>

                <button type="submit" class="medieval-button"><?= __('public.index.enter') ?></button>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="password_recovery.php"
                        style="color: #7d510f; text-decoration: none; font-size: 15px; font-weight: bold;">
                        <?= __('public.index.recover_password') ?>
                    </a>
                </div>
            </form>

            <?php if (!empty($error)): ?>
                <div style="color: #8b0000; text-align: center; margin-top: 15px; font-weight: bold;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="world-selection">
                <p style="text-align: center; margin-bottom: 20px; font-size: 22px; color: #5d4037;">
                    <?= __('public.index.select_world') ?>
                </p>

                <div class="world-scroll">
                    <?php if (!empty($user_worlds)): ?>
                        <?php foreach ($user_worlds as $world): ?>
                            <div class="world-item">
                                <a href="<?= htmlspecialchars(get_world_url($world, 'index.php?action=select_world&csrf_token=' . ($_SESSION['csrf_token'] ?? ''))) ?>"
                                    class="medieval-button">
                                    <?= __('public.index.world') ?>: <?= htmlspecialchars($world) ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php
                    $active_worlds_clean = array_map('strval', $active_worlds);
                    $user_worlds_clean = array_map('strval', $user_worlds);
                    $available_worlds = array_diff($active_worlds_clean, $user_worlds_clean);
                    if (!empty($available_worlds)):
                        ?>
                        <div style="height: 1px; background: rgba(0,0,0,0.1); margin: 20px 0;"></div>
                        <p style="font-size: 14px; color: #5d4037; font-weight: bold; margin-bottom: 10px;">Novos Mundos:</p>
                        <?php foreach ($available_worlds as $world): ?>
                            <div class="world-item">
                                <a href="<?= htmlspecialchars(get_world_url($world, 'index.php?action=select_world&csrf_token=' . ($_SESSION['csrf_token'] ?? ''))) ?>"
                                    class="medieval-button"
                                    style="background: linear-gradient(to bottom, #4a6b35 0%, #3e582a 50%, #2d4017 100%);">
                                    Jogar no: <?= htmlspecialchars($world) ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <a href="index.php?action=logout&csrf_token=<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" class="medieval-button"
                    style="background: #333; font-size: 18px; height: 40px; line-height: 40px;">
                    ← Sair da Conta
                </a>
            </div>
        <?php endif; ?>
    </div>
    </div>

    <?php if (count($news) > 0): ?>
        <section class="news-section">
            <h2 class="news-title"><i class="fas fa-newspaper"></i> <?= __('public.index.news') ?></h2>
            <div class="news-slider">
                <?php foreach ($news as $og): ?>
                    <article class="news-card">
                        <span><i class="fas fa-calendar-day"></i> <?= $og['data'] ?></span>
                        <h3><?= htmlspecialchars($og['nazwa']) ?></h3>
                        <p><?= $og['text'] ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <footer
        style="padding: 40px 5%; text-align: center; color: var(--medieval-gold); font-size: 14px; border-top: 1px solid rgba(194, 178, 128, 0.2);">
        &copy; <?= date('Y') ?> by Ice41 - Nobles Wars
    </footer>

    <!-- Tema controlado globalmente pelo administrador -->

</body>

</html>