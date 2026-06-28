<!DOCTYPE html>
<html>

<head>
    <title><?= __('public.activation.page_title') ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&display=swap" rel="stylesheet">
    <style>
        /* Estilos específicos para o formulário de ativação (baseado na login-block) */
        .login-block {
            float: right !important;
            position: relative !important;
            right: 10px !important;
            margin: -290px 0 0 0 !important;
            background-color: #f4e4bc;
            background-image: radial-gradient(circle at center, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0) 70%), url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.1'/%3E%3C/svg%3E");
            border: 1px solid #c2b280;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2), inset 0 0 30px rgba(160, 82, 45, 0.15), inset 0 0 5px rgba(160, 82, 45, 0.3);
            padding: 20px 25px !important;
            width: 249px !important;
            min-height: 350px;
            color: #3e2723;
            font-family: 'MedievalSharp', cursive;
            z-index: 10;
            display: block !important;
        }

        .login-block::after {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 2px solid rgba(93, 64, 55, 0.2);
            border-radius: 3px;
            pointer-events: none;
        }

        .login-block h2 {
            color: #2d1b10 !important;
            font-family: 'MedievalSharp', cursive;
            font-size: 36px !important;
            border-bottom: 2px solid #8c5f0d;
            padding-bottom: 5px;
            margin: 0 auto 20px auto !important;
            text-align: center !important;
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
            width: 100%;
            letter-spacing: 1px;
            position: relative;
        }

        .login-block h2::after {
            content: "♦";
            display: block;
            font-size: 14px;
            color: #8c5f0d;
            margin-top: 2px;
        }

        .login-block label strong {
            display: block;
            color: #2d1b10 !important;
            font-family: 'MedievalSharp', cursive;
            font-weight: normal !important;
            font-size: 18px !important;
            margin-bottom: 5px;
            text-align: left !important;
            width: 100% !important;
            float: none !important;
        }

        .login-block label span {
            display: block;
            width: 100%;
        }

        .login-block input[type="text"],
        .login-block input[type="password"] {
            background: #e6d5ac;
            border: 2px solid #5d4037;
            border-radius: 4px;
            padding: 8px 10px;
            color: #2d1b10;
            width: 100% !important;
            height: 38px !important;
            margin-bottom: 5px;
            box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            font-family: 'MedievalSharp', cursive;
            box-sizing: border-box;
        }

        .medieval-button {
            display: block;
            width: 100%;
            height: 46px;
            line-height: 46px;
            padding: 0;
            margin: 25px 0 10px;
            background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 50%, #5d4037 100%);
            border: 2px solid #3e2723;
            border-radius: 4px;
            color: #f5f5dc !important;
            font-family: 'MedievalSharp', cursive;
            font-size: 22px;
            text-align: center;
            text-decoration: none !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 2px 4px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            position: relative;
        }

        .medieval-button:hover {
            background: linear-gradient(to bottom, #a16b35 0%, #7e584a 50%, #6d4c41 100%);
            color: #fff !important;
        }

        .medieval-button::before,
        .medieval-button::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 6px;
            height: 6px;
            background: #2d1b10;
            border-radius: 50%;
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2);
            margin-top: -3px;
        }

        .medieval-button::before {
            left: 8px;
        }

        .medieval-button::after {
            right: 8px;
        }

        .closure {
            text-align: center;
            padding: 10px;
            color: #5d4037;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div id="index_body">
        <div id="main">
            <div id="header">
                <h1>
                    <a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;">
                        <p style="position: absolute; top: -300px">NobleWars - O jogo de browser</p>
                    </a>
                </h1>
                <div class="navigation">
                    <div class="navigation-holder">
                        <div class="navigation-wrapper">
                            <div id="navigation_span">
                                <a href="index.php"><?= __('public.index.title') ?></a> -
                                <a href="rules.php"><?= __('public.rules.title') ?></a> -
                                <a href="team.php"><?= __('public.team.title') ?></a> -
                                <a href="hall_of_fame.php"><?= __('public.hall_of_fame.title') ?></a> -
                                <a href="help.php"><?= __('public.help.title') ?></a>

                                <span style="float: right; margin-right: 10px;">
                                    <?php include __DIR__ . '/Components/language_selector_public.php'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="paladin"><img src="graphic/index/bg-ice41.png" alt="" /></span>
            </div>

            <div id="content">
                <div class="container-block">
                    <div class="container-top"></div>
                    <div class="container">
                        <div class="info-block">
                            <?php if (!$activated): ?>
                                <h2><?= __('public.activation.heading') ?></h2>
                                <p><?= __('public.activation.instructions') ?></p>
                            <?php else: ?>
                                <!-- Se ativado, mostra título diferente ou deixa vazio -->
                                <h2><?= __('public.activation.heading') ?></h2>
                                <p><?= __('public.activation.success') ?></p>
                            <?php endif; ?>

                            <!-- MENSAGENS DE ERRO (Esquerda) -->
                            <?php if (!empty($error)): ?>
                                <div class="error-msg"
                                    style="color:#8b0000; background:#fcc; border:1px solid #c00; padding:10px; margin: 20px 0; font-weight:bold; text-align:center; border-radius:5px;">
                                    <?= htmlspecialchars($error) ?>
                                </div>
                            <?php endif; ?>

                            <!-- Exibe informações extra apenas se NÃO ativado -->
                            <?php if (!$activated): ?>
                                <div style="margin-top: 30px; text-align:center; color:#5d4037;">
                                    <p><?= __('public.activation.instructions') ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- BLOCO DIREITO (Formulário ou Sucesso) -->
                    <div class="login-block">
                        <?php if (!$activated): ?>
                            <h2><?= __('public.activation.title') ?></h2>
                            <form action="ativar.php" method="post">
                                <input type="hidden" name="akcja" value="aktywuj">

                                <div style="margin-bottom:15px;">
                                    <label>
                                        <strong><?= __('public.activation.username') ?></strong>
                                        <span>
                                            <input name="user" type="text"
                                                value="<?= htmlspecialchars($_REQUEST['user'] ?? '') ?>" />
                                        </span>
                                    </label>
                                </div>

                                <div style="margin-bottom:15px;">
                                    <label>
                                        <strong><?= __('public.activation.activation_code') ?></strong>
                                        <span>
                                            <input name="password" type="text"
                                                value="<?= htmlspecialchars($_REQUEST['kod'] ?? '') ?>" />
                                        </span>
                                    </label>
                                </div>

                                <button type="submit"
                                    class="medieval-button"><?= __('public.activation.activate_button') ?></button>
                            </form>
                        <?php else: ?>
                            <!-- MENSAGEM DE SUCESSO NO BLOCO DIREITO -->
                            <h2 style="color:green !important; border-bottom-color:green;">
                                <?= __('public.activation.heading') ?></h2>

                            <div style="text-align:center; padding:10px;">
                                <p style="font-weight:bold; font-size:16px; color:#006400; margin-bottom:20px;">
                                    <?= htmlspecialchars($success) ?>
                                </p>

                                <a href="index.php" class="medieval-button"><?= __('public.activation.login_now') ?></a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="container-bottom"></div>
                </div>
            </div>

            <div class="closure">
                &copy; <?= date('Y') ?> by Ice41 - Nobles Wars
            </div>
        </div>
    </div>
</body>

</html>
