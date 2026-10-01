<?php
/**
 * REGRAS CLÁSSICAS - Noblewars
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= __('public.rules.title') ?> - Noblewars</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <style>
        .rules-container { max-width: 900px; margin: 20px auto; font-family: Verdana, Arial, sans-serif; }
        .rules-header { background: linear-gradient(to bottom, #f4e4bc, #d4c4a0); border: 2px solid #8b6c42; padding: 15px 20px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .rule-section { background: #f8f4e8; border: 2px solid #8b6c42; border-radius: 5px; margin-bottom: 15px; overflow: hidden; }
        .rule-section-header { background: linear-gradient(to bottom, #d4c4a0, #b4a480); padding: 12px 15px; border-bottom: 2px solid #8b6c42; cursor: pointer; }
        .rule-content { padding: 15px 20px; color: #3b260e; line-height: 1.6; font-size: 13px; }
        .collapsed { display: none; }
    </style>
</head>
<body>
    <div id="index_body">
        <div id="main">
            <div id="header">
                <h1><a href="index.php" style="background:url(graphic/index/bg-noble2.jpg) no-repeat 100% 0;"><p style="position: absolute; top: -300px">NobleWars</p></a></h1>
                <div class="navigation">
                    <div class="navigation-holder">
                        <div class="navigation-wrapper">
                            <div id="navigation_span">
                                <?php foreach ($linki as $link => $value) { echo '<a href="' . $link . '">' . $value . '</a> - '; } ?>
                                <span style="float: right; margin-right: 10px;">
                                    <?php include __DIR__ . '/components/language_selector_public.php'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="paladin"><img src="graphic/index/bg-ice41.png" alt="" /></span>
            </div>

            <div id="content">
                <div class="container-block-full">
                    <div class="container-top-full"></div>
                    <div class="container">
                        <div class="rules-container">
                            <div class="rules-header">
                                <h1>📜 <?= __('public.rules.heading') ?></h1>
                                <p><?= __('public.rules.description') ?></p>
                            </div>
                            <?php foreach ($rules as $rule): ?>
                                <div class="rule-section">
                                    <div class="rule-section-header" onclick="toggleRule(<?= $rule['id'] ?>)">
                                        <h2 style="font-size:16px; margin:0;"><?= htmlspecialchars($rule['section']) ?> - <?= htmlspecialchars($rule['title']) ?></h2>
                                    </div>
                                    <div class="rule-content" id="rule-content-<?= $rule['id'] ?>">
                                        <p><?= nl2br(htmlspecialchars($rule['content'])) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div style="text-align:center; margin:20px;"><a href="index.php" style="color:#3b260e; font-weight:bold;">← <?= __('public.rules.back_to_home') ?></a></div>
                    </div>
                    <div class="container-bottom-full"></div>
                </div>
            </div>
            <div class="closure">
                &copy; <?= date('Y') ?> by ice41 - NobleWars
                <div style="margin-top: 8px; font-size: 12px;">
                    <a href="privacy.php" style="color: #7d510f; font-weight: bold; text-decoration: none;">Política de Privacidade</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleRule(id) {
            const content = document.getElementById('rule-content-' + id);
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
        }
    </script>
    <?php include __DIR__ . '/components/cookie_banner.php'; ?>
</body>
</html>
