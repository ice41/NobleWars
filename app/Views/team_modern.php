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

<!-- Fontes Google (adicione no <head> se ainda não tiver) -->
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

<style>
    /* ====== TABELA DA EQUIPA - ESTILO MEDIEVAL MODERNO ====== */
    .team-wrapper {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background: transparent;
        border: 2px solid #c9a961;
        border-radius: 4px;
        box-shadow:
            0 0 0 1px #8b6f3a inset,
            0 10px 30px rgba(62, 39, 35, 0.25);
        position: relative;
        font-family: 'Crimson Text', serif;
    }

    /* Ornamentos nos cantos */
    .team-wrapper::before,
    .team-wrapper::after {
        content: "❖";
        position: absolute;
        color: #c9a961;
        font-size: 1.4em;
        top: 8px;
    }
    .team-wrapper::before { left: 12px; }
    .team-wrapper::after { right: 12px; }

    .team-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        color: #3e2723;
    }

    .team-table thead th {
        font-family: 'Cinzel', serif;
        font-weight: 600;
        font-size: 0.85em;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #5d4037;
        padding: 18px 16px;
        text-align: left;
        border-bottom: 2px solid #c9a961;
        color: #f5e6c8;
    }

    .team-table td {
        padding: 14px 16px;
        border-bottom: 1px dashed rgba(139, 111, 58, 0.3);
        font-size: 1.05em;
        vertical-align: middle;
        transition: all 0.3s ease;
        color: #f5e6c8;
    }

    /* Hover apenas nas linhas de membros (não nas categorias) */
    .team-table tbody tr:not(.category-row):hover td {
        background: rgba(201, 169, 97, 0.1);
        color: #2e1a0f;
    }

    .team-table tbody tr:not(.category-row):hover i {
        transform: scale(1.15);
        transition: transform 0.3s ease;
    }

    .team-table td i {
        font-size: 1.15em;
        transition: transform 0.3s ease;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
    }

    /* ====== BADGE / SELO ====== */
    .role-badge {
        display: inline-block;
        padding: 5px 14px;
        font-family: 'Cinzel', serif;
        font-size: 0.75em;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #5d4037;
        background: linear-gradient(135deg, #f5e6c8 0%, #e8d9b0 100%);
        border: 1px solid #c9a961;
        border-radius: 2px;
        box-shadow:
            0 1px 3px rgba(62, 39, 35, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
        position: relative;
    }

    .role-badge::before {
        content: "✦";
        margin-right: 6px;
        color: #c9a961;
        font-size: 0.8em;
    }

    /* ====== CATEGORIAS (faixas de pergaminho) - SEM HOVER ====== */
    .category-row td {
        padding: 12px 16px;
        font-family: 'Cinzel', serif;
        font-size: 0.8em;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #faf3e0;
        background:
            linear-gradient(to right,
                rgba(62, 39, 35, 0) 0%,
                rgba(62, 39, 35, 0.85) 15%,
                rgba(62, 39, 35, 0.85) 85%,
                rgba(62, 39, 35, 0) 100%);
        border-bottom: 1px solid #c9a961;
        border-top: 1px solid #c9a961;
        text-align: center;
        pointer-events: none; /* Remove qualquer interação */
    }

    .category-row td::before,
    .category-row td::after {
        content: "⚜";
        color: #c9a961;
        margin: 0 12px;
        font-size: 0.9em;
    }

    /* ====== RESPONSIVO ====== */
    @media (max-width: 600px) {
        .team-wrapper { padding: 15px; margin: 20px 10px; }
        .team-table td, .team-table th { padding: 10px 8px; font-size: 0.95em; }
        .role-badge { font-size: 0.65em; letter-spacing: 1px; padding: 4px 8px; }
        .category-row td { letter-spacing: 2px; font-size: 0.7em; }
    }
</style>

<div class="team-wrapper">
    <table class="team-table">
        <thead>
            <tr>
                <th><?= __('public.team.member') ?></th>
                <th><?= __('public.team.role') ?></th>
            </tr>
        </thead>
        <tbody>

            <!-- 👑 LIDERANÇA -->
            <tr class="category-row">
                <td colspan="2">Liderança</td>
            </tr>
            <tr>
                <td><i class="fas fa-crown" style="color: #d4af37; margin-right: 10px;"></i>       </td>
                <td><span class="role-badge"><?= __('public.team.global_admin') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-star" style="color: #ffd54f; margin-right: 10px;"></i>     </td>
                <td><span class="role-badge"><?= __('public.team.co_admin') ?></span></td>
            </tr>

            <!-- 💻 DESENVOLVIMENTO -->
            <tr class="category-row">
                <td colspan="2">Desenvolvimento</td>
            </tr>
            <tr>
                <td><i class="fas fa-code" style="color: #4fc3f7; margin-right: 10px;"></i>Ice41</td>
                <td><span class="role-badge"><?= __('public.team.tech_dev') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-server" style="color: #e57373; margin-right: 10px;"></i>Ice41</td>
                <td><span class="role-badge"><?= __('public.team.sys_admin') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-palette" style="color: #ba68c8; margin-right: 10px;"></i>Ice41</td>
                <td><span class="role-badge"><?= __('public.team.ui_ux_designer') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-bug" style="color: #ef5350; margin-right: 10px;"></i>Ice41</td>
                <td><span class="role-badge"><?= __('public.team.qa_tester') ?></span></td>
            </tr>

            <!-- 🛡️ MODERAÇÃO -->
            <tr class="category-row">
                <td colspan="2">Moderação</td>
            </tr>
            <tr>
                <td><i class="fas fa-shield-alt" style="color: #aed581; margin-right: 10px;"></i>       </td>
                <td><span class="role-badge"><?= __('public.team.senior_mod') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-gavel" style="color: #b0b0b0; margin-right: 10px;"></i>     </td>
                <td><span class="role-badge"><?= __('public.team.game_mod') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-ban" style="color: #d32f2f; margin-right: 10px;"></i>      </td>
                <td><span class="role-badge"><?= __('public.team.anti_cheat') ?></span></td>
            </tr>

            <!-- 📢 COMUNIDADE E EVENTOS -->
            <tr class="category-row">
                <td colspan="2">Comunidade e Eventos</td>
            </tr>
            <tr>
                <td><i class="fas fa-users" style="color: #81c784; margin-right: 10px;"></i>        </td>
                <td><span class="role-badge"><?= __('public.team.community_manager') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-calendar-alt" style="color: #ffb74d; margin-right: 10px;"></i>     </td>
                <td><span class="role-badge"><?= __('public.team.event_organizer') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-trophy" style="color: #ffd54f; margin-right: 10px;"></i>       </td>
                <td><span class="role-badge"><?= __('public.team.tournament_admin') ?></span></td>
            </tr>

            <!-- 🎨 MÍDIA E CONTEÚDO -->
            <tr class="category-row">
                <td colspan="2">Mídia e Conteúdo</td>
            </tr>
            <tr>
                <td><i class="fas fa-video" style="color: #f06292; margin-right: 10px;"></i>        </td>
                <td><span class="role-badge"><?= __('public.team.content_creator') ?></span></td>
            </tr>
            <tr>
                <td><i class="fab fa-twitch" style="color: #9146ff; margin-right: 10px;"></i>       </td>
                <td><span class="role-badge"><?= __('public.team.streamer') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-hashtag" style="color: #29b6f6; margin-right: 10px;"></i>      </td>
                <td><span class="role-badge"><?= __('public.team.social_media') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-language" style="color: #8d6e63; margin-right: 10px;"></i>     </td>
                <td><span class="role-badge"><?= __('public.team.translator') ?></span></td>
            </tr>

            <!-- 💬 SUPORTE -->
            <tr class="category-row">
                <td colspan="2">Suporte</td>
            </tr>
            <tr>
                <td><i class="fas fa-life-ring" style="color: #4db6ac; margin-right: 10px;"></i>  </td>
                <td><span class="role-badge"><?= __('public.team.support_helper') ?></span></td>
            </tr>
            <tr>
                <td><i class="fas fa-headset" style="color: #7986cb; margin-right: 10px;"></i>  </td>
                <td><span class="role-badge"><?= __('public.team.customer_support') ?></span></td>
            </tr>

        </tbody>
    </table>
</div>

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
