<?php
/**
 * TEMA MODERNO MEDIEVAL - Quadro de Honra
 * O layout moderno alinhado com a página index_modern.php
 */
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \__('screens.hall_of_fame.title', ['world' => htmlspecialchars($world)]) ?></title>
    <link rel="shortcut icon" href="graphic/icons/nwfavicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=MedievalSharp&family=Outfit:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --medieval-gold: #c2b280;
            --medieval-brown: #3e2723;
            --parchment: #f4e4bc;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #2b1d12;
            color: #f4e4bc;
            overflow-y: auto;
            background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('graphic/index/bg_modern.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 5%; background: rgba(43, 29, 18, 0.6);
            border-bottom: 2px solid var(--medieval-gold);
            box-shadow: 0 5px 20px rgba(0,0,0,0.4);
            backdrop-filter: blur(8px);
        }

        .logo { font-family: 'MedievalSharp', cursive; font-size: 32px; color: var(--medieval-gold); text-decoration: none; text-shadow: 2px 2px 0 #000; letter-spacing: 2px; }

        .nav-links a { margin-left: 25px; color: white; text-decoration: none; font-size: 15px; font-weight: bold; transition: 0.3s; opacity: 0.8; }
        .nav-links a:hover { opacity: 1; color: var(--medieval-gold); transform: translateY(-2px); }

        .main-container {
            display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 40px;
            padding: 40px 5%; align-items: start; max-width: 1400px; margin: 0 auto;
            flex: 1;
        }

        .hero-text h1 { 
            font-family: 'MedievalSharp', cursive; font-size: 48px; line-height: 1.1; 
            margin-bottom: 25px; color: #fff; text-shadow: 3px 3px 0 rgba(0,0,0,0.5); 
        }

        .hof-section {
            background: rgba(43, 29, 18, 0.7);
            border: 1px solid var(--medieval-gold);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            backdrop-filter: blur(8px);
        }

        .hof-section h2 {
            font-family: 'MedievalSharp', cursive;
            color: var(--medieval-gold);
            font-size: 26px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(194, 178, 128, 0.3);
            padding-bottom: 10px;
        }

        .hof-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .hof-card {
            background: rgba(255,255,255,0.05);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid rgba(194, 178, 128, 0.2);
        }

        .hof-card h3 {
            font-family: 'MedievalSharp', cursive;
            color: white;
            font-size: 18px;
            margin-bottom: 15px;
            text-align: center;
        }

        .hof-table {
            width: 100%;
            border-collapse: collapse;
        }

        .hof-table th {
            color: var(--medieval-gold);
            text-align: left;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(194, 178, 128, 0.3);
            font-size: 14px;
        }

        .hof-table td {
            padding: 10px 0;
            color: #fff;
            border-bottom: 1px dashed rgba(255,255,255,0.1);
        }

        .hof-table tr:last-child td {
            border-bottom: none;
        }

        .hof-table a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .hof-table a:hover {
            color: var(--medieval-gold);
        }

        .hof-rank {
            background: var(--medieval-gold);
            color: var(--medieval-brown);
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 13px;
        }

        .login-block {
            background-color: var(--parchment);
            background-image: 
                radial-gradient(circle at center, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0) 70%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.1'/%3E%3C/svg%3E");
            border: 2px solid var(--medieval-gold);
            border-radius: 8px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.6), inset 0 0 40px rgba(160, 82, 45, 0.2);
            padding: 25px;
            width: 100%;
            max-width: 400px;
            color: var(--medieval-brown);
            font-family: 'MedievalSharp', cursive;
            position: relative;
            margin: 0 auto;
        }

        .login-block::after {
            content: ""; position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px;
            border: 1px solid rgba(93, 64, 55, 0.2); border-radius: 4px; pointer-events: none;
        }

        .login-block h2 {
            font-size: 28px; text-align: center; margin-bottom: 20px;
            border-bottom: 2px solid #8c5f0d; padding-bottom: 10px;
            text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.5);
        }

        .medieval-button {
            display: block; width: 100%; height: 40px; line-height: 40px;
            background: linear-gradient(to bottom, #8b5a2b 0%, #6d4c41 50%, #5d4037 100%);
            border: 2px solid #3e2723; border-radius: 4px;
            color: #f5f5dc !important; font-family: 'MedievalSharp', cursive; font-size: 18px;
            text-align: center; text-decoration: none !important; text-shadow: 2px 2px 2px #000;
            cursor: pointer; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            transition: 0.2s; margin-bottom: 10px;
        }
        
        .medieval-button:hover { 
            background: linear-gradient(to bottom, #a16b35 0%, #7e584a 50%, #6d4c41 100%); 
            transform: translateY(-2px); 
        }

        .medieval-button.active {
            background: linear-gradient(to bottom, #4a6b35 0%, #3e582a 50%, #2d4017 100%);
            border-color: #1a260f;
        }

        .world-scroll {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .world-scroll::-webkit-scrollbar { width: 8px; }
        .world-scroll::-webkit-scrollbar-track { background: rgba(93, 64, 55, 0.1); border-radius: 4px; }
        .world-scroll::-webkit-scrollbar-thumb { background: #8b5a2b; border-radius: 4px; }

        .closed-icon { font-size: 0.8em; margin-left: 5px; }

        @media (max-width: 1000px) {
            .main-container { grid-template-columns: 1fr; }
            .hof-grid { grid-template-columns: 1fr; }
            .hero-text h1 { font-size: 40px; text-align: center; }
        }
        .medieval-button.closed {
            background: linear-gradient(to bottom, #5a4a3a 0%, #4a3a2a 50%, #3a2a1a 100%);
            opacity: 0.7;
            cursor: not-allowed;
            border-color: #2a1a0a;
        }

        .medieval-button.closed:hover {
            transform: none;
            background: linear-gradient(to bottom, #5a4a3a 0%, #4a3a2a 50%, #3a2a1a 100%);
        }

        .closed-icon {
            font-size: 0.8em;
            margin-left: 8px;
            color: #ff6b6b;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.php" class="logo"><img width="80" height="80" src="graphic/index/noblewars.png" alt="Noblewars Logo" ></a>
        <div class="nav-links">
            <?php
            $linki = [
                'index.php' => \__('public.index.title'),
                'rules.php' => \__('public.rules.title'),
                'team.php' => \__('public.team.title'),
                'hall_of_fame.php' => 'Hall da Fama',
                'help.php' => \__('public.help.title'),
            ];
            foreach ($linki as $url => $name): ?>
                <a href="<?= $url ?>"><?= $name ?></a>
            <?php endforeach; ?>
            <!-- REMOVIDO: Seletor de idiomas não existe -->
        </div>
    </nav>

    <div class="main-container">
        
        <div class="hero-text">
            <h1><?= \__('screens.hall_of_fame.title', ['world' => htmlspecialchars($world)]) ?></h1>
            
            <?php if (empty($top_players) && empty($top_tribe) && empty($achievements['conqueror'])): ?>
                <div class="hof-section" style="text-align: center; padding: 50px;">
                    <h2><i class="fas fa-ghost"></i> Ainda sem registos para o Mundo <?= htmlspecialchars($world) ?></h2>
                </div>
            <?php else: ?>
                <div class="hof-grid">
                    <div class="hof-card">
                        <h3><i class="fas fa-crown" style="color: var(--medieval-gold);"></i> <?= \__('screens.hall_of_fame.top_players') ?></h3>
                        <?php if (!empty($top_players)): ?>
                            <table class="hof-table">
                                <tr><th>Pos</th><th>Nome</th><th style="text-align: right;">Pontos</th></tr>
                                <?php $pos = 1; foreach ($top_players as $player): ?>
                                    <tr>
                                        <td><span class="hof-rank"><?= $pos++ ?></span></td>
                                        <td><a href="guest.php?world=<?= htmlspecialchars($world) ?>&screen=info_player&id=<?= $player['id'] ?>"><?= htmlspecialchars($player['username']) ?></a></td>
                                        <td align="right"><?= number_format($player['points'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <p style="text-align:center; opacity:0.7;"><?= \__('screens.hall_of_fame.no_data') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="hof-card">
                        <h3><i class="fas fa-shield-alt" style="color: var(--medieval-gold);"></i> <?= \__('screens.hall_of_fame.top_tribes') ?></h3>
                        <?php if (!empty($top_tribe)): ?>
                            <table class="hof-table">
                                <tr><th>Pos</th><th>Nome</th><th style="text-align: right;">Pontos</th></tr>
                                <tr>
                                    <td><span class="hof-rank">1</span></td>
                                    <td><a href="guest.php?world=<?= htmlspecialchars($world) ?>&screen=info_ally&id=<?= $top_tribe['id'] ?>"><?= htmlspecialchars($top_tribe['name']) ?></a></td>
                                    <td align="right"><?= number_format($top_tribe['points'], 0, ',', '.') ?></td>
                                </tr>
                            </table>
                            <div style="margin-top: 15px; font-size: 13px; color: #aaa;">
                                <strong style="color: var(--medieval-gold);"><?= \__('screens.hall_of_fame.members') ?>:</strong><br>
                                <?= htmlspecialchars($top_tribe['members']) ?>
                            </div>
                        <?php else: ?>
                            <p style="text-align:center; opacity:0.7;"><?= \__('screens.hall_of_fame.no_data') ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="hof-section" style="margin-top: 20px;">
                    <h2><i class="fas fa-scroll"></i> Marcos Históricos</h2>
                    
                    <div class="hof-grid">
                        <?php foreach ($achievements as $category => $catData): ?>
                            <div class="hof-card">
                                <h3><i class="fas fa-trophy" style="color: var(--medieval-gold);"></i> <?= htmlspecialchars($catData['title']) ?></h3>
                                <div style="display: flex; flex-direction: column; gap: 15px;">
                                    <?php foreach ($catData['items'] as $ach): ?>
                                        <div style="display: flex; align-items: center; gap: 15px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 10px;">
                                            <div style="width: 50px; height: 50px; flex-shrink: 0; background: rgba(0,0,0,0.3); border-radius: 8px; border: 1px solid var(--medieval-gold); display: flex; align-items: center; justify-content: center;">
                                                <img src="<?= $ach['image'] ?>" alt="" style="max-width: 40px; max-height: 40px;">
                                            </div>
                                            <div>
                                                <div style="font-size: 13px; color: #ccc;"><?= htmlspecialchars($ach['label']) ?></div>
                                                <div style="font-size: 15px; color: #fff; font-weight: bold;"><?= htmlspecialchars($ach['winner']) ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (!empty($daily_awards)): ?>
                            <div class="hof-card">
                                <h3><i class="fas fa-medal" style="color: var(--medieval-gold);"></i> Metas Diárias</h3>
                                <div style="display: flex; flex-direction: column; gap: 15px;">
                                    <?php foreach ($daily_awards as $ach): ?>
                                        <div style="display: flex; align-items: center; gap: 15px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 10px;">
                                            <div style="width: 50px; height: 50px; flex-shrink: 0; background: rgba(0,0,0,0.3); border-radius: 8px; border: 1px solid var(--medieval-gold); display: flex; align-items: center; justify-content: center;">
                                                <img src="<?= $ach['image'] ?>" alt="" style="max-width: 40px; max-height: 40px;">
                                            </div>
                                            <div>
                                                <div style="font-size: 13px; color: #ccc;"><?= htmlspecialchars($ach['name']) ?></div>
                                                <div style="font-size: 15px; color: #fff; font-weight: bold;"><?= htmlspecialchars($ach['winner']) ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="login-block">
            <h2><?= \__('screens.hall_of_fame.select_world') ?></h2>
            <div class="world-scroll">
                <?php foreach ($worlds_list as $w): ?>
                    <a href="hall_of_fame.php?world=<?= $w['id'] ?>" 
                    class="medieval-button <?= $world == $w['id'] ? 'active' : '' ?> <?= $w['is_closed'] ? 'closed' : '' ?>">
                        <?= $w['name'] ?>
                        <?php if ($w['is_closed']): ?>
                            <span class="closed-icon">🔒 Fechado</span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" style="color: var(--medieval-gold); text-decoration: none; font-weight: bold;">
                <i class="fas fa-arrow-left"></i> <?= \__('public.team.back_to_home') ?>
            </a>
        </div>                    
    </div>

    <footer style="padding: 30px 5%; text-align: center; color: var(--medieval-gold); font-size: 14px; background: rgba(0,0,0,0.5);">
        &copy; <?= date('Y') ?> by Ice41 - Nobles Wars
    </footer>

</body>
</html>