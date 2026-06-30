<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações Globais | NobleWars Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Verdana, Arial, sans-serif;
            background: #1a1410;
            color: #3b260e;
            padding: 40px 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #f0e6d2;
            border: 3px solid #8b6c42;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
        }

        .header {
            background: #4a331c;
            padding: 20px;
            color: #e8d0a9;
            text-align: center;
            border-bottom: 2px solid #8b6c42;
        }

        .body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #5c3a1e;
        }

        .theme-options {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }

        .theme-card {
            border: 2px solid #dcd0b8;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            text-align: center;
            transition: 0.3s;
        }

        .theme-card:hover {
            border-color: #8b6c42;
            background: rgba(0, 0, 0, 0.05);
        }

        .theme-card.active {
            border-color: #8b2323;
            background: #fff;
            box-shadow: 0 0 10px rgba(139, 35, 35, 0.2);
        }

        .theme-card i {
            font-size: 32px;
            margin-bottom: 10px;
            color: #8b6c42;
        }

        .theme-card h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .theme-card p {
            font-size: 11px;
            opacity: 0.7;
        }

        .theme-card input {
            display: none;
        }

        .btn-save {
            display: block;
            width: 100%;
            padding: 15px;
            background: linear-gradient(to bottom, #8b2323, #6e1c1c);
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn-save:hover {
            background: #a02828;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #cbb286;
            text-decoration: none;
            font-size: 14px;
        }

        .success-msg {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>
    <div style="max-width: 600px; margin: 0 auto;">
        <a href="admin.php?action=select_world" class="back-link"><i class="fas fa-arrow-left"></i> Voltar ao
            Seletor</a>

        <div class="container">
            <div class="header">
                <h1><i class="fas fa-cog"></i> Configurações Globais</h1>
            </div>
            <div class="body">
                <?php if (isset($_SESSION['admin_success'])): ?>
                    <div class="success-msg"><?= $_SESSION['admin_success'];
                    unset($_SESSION['admin_success']); ?></div>
                <?php endif; ?>

                <form action="admin.php?action=save_global_settings" method="POST">
                    <div class="form-group">
                        <label>Aparência do Site (Páginas Públicas):</label>
                        <div class="theme-options">
                            <label class="theme-card <?= $currentTheme == 'classic' ? 'active' : '' ?>">
                                <input type="radio" name="index_theme" value="classic" <?= $currentTheme == 'classic' ? 'checked' : '' ?> onchange="updateCards(this)">
                                <i class="fas fa-scroll"></i>
                                <h3>Clássico</h3>
                                <p>O design original e fiel de 2010.</p>
                            </label>
                            <label class="theme-card <?= $currentTheme == 'modern' ? 'active' : '' ?>">
                                <input type="radio" name="index_theme" value="modern" <?= $currentTheme == 'modern' ? 'checked' : '' ?> onchange="updateCards(this)">
                                <i class="fas fa-clapperboard"></i>
                                <h3>Moderno</h3>
                                <p>Fundo cinematográfico e layout de ecrã inteiro.</p>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Aparência In-game (Páginas do Jogo):</label>
                        <div class="theme-options"
                            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px;">
                            <?php
                            $currentIngameTheme = ($currentIngameTheme === 'classic') ? 'new' : $currentIngameTheme;

                            $ingameThemes = [];
                            $css_dir = __DIR__ . '/../../public/css';
                            if (is_dir($css_dir)) {
                                $files = scandir($css_dir);
                                foreach ($files as $file) {
                                    if (preg_match('/^game_([a-zA-Z0-9_\-]+)\.css$/', $file, $matches)) {
                                        $code = $matches[1];
                                        if ($code === 'new') {
                                            $ingameThemes[$code] = [
                                                'name' => 'Clássico',
                                                'icon' => 'fa-chess-rook',
                                                'desc' => 'O layout clássico tradicional com bordas de madeira e fundo pergaminho.'
                                            ];
                                        } elseif ($code === 'modern') {
                                            $ingameThemes[$code] = [
                                                'name' => 'Moderno',
                                                'icon' => 'fa-wand-magic-sparkles',
                                                'desc' => 'Interface moderna com layouts responsivos, cantos arredondados e detalhes elegantes.'
                                            ];
                                        } elseif ($code === 'viking') {
                                            $ingameThemes[$code] = [
                                                'name' => 'Viking',
                                                'icon' => 'fa-snowflake',
                                                'desc' => 'Tema nórdico com tons de gelo e aço, bordas prateadas e estilo glacial.'
                                            ];
                                        } elseif ($code === 'obsidian') {
                                            $ingameThemes[$code] = [
                                                'name' => 'Obsidian',
                                                'icon' => 'fa-gem',
                                                'desc' => 'Tema escuro premium com contrastes obsidianos e estilo vulcânico.'
                                            ];
                                        } elseif ($code === 'nexon') {
                                            $ingameThemes[$code] = [
                                                'name' => 'Nexon',
                                                'icon' => 'fa-gem',
                                                'desc' => 'Tema escuro premium com contrastes nexon e estilo nexon.'
                                            ];
                                        } else {
                                            $ingameThemes[$code] = [
                                                'name' => ucfirst(str_replace('_', ' ', $code)),
                                                'icon' => 'fa-palette',
                                                'desc' => 'Tema customizado carregado dinamicamente a partir dos ficheiros do servidor.'
                                            ];
                                        }
                                    }
                                }
                            }

                            if (empty($ingameThemes)) {
                                $ingameThemes = [
                                    'new' => [
                                        'name' => 'Clássico',
                                        'icon' => 'fa-chess-rook',
                                        'desc' => 'O layout clássico tradicional com bordas de madeira e fundo pergaminho.'
                                    ],
                                    'modern' => [
                                        'name' => 'Moderno',
                                        'icon' => 'fa-wand-magic-sparkles',
                                        'desc' => 'Interface moderna com layouts responsivos, cantos arredondados e detalhes elegantes.'
                                    ]
                                ];
                            }

                            foreach ($ingameThemes as $code => $th):
                                $isActive = ($currentIngameTheme === $code);
                                ?>
                                <label class="theme-card <?= $isActive ? 'active' : '' ?>">
                                    <input type="radio" name="ingame_theme" value="<?= htmlspecialchars($code) ?>"
                                        <?= $isActive ? 'checked' : '' ?> onchange="updateCards(this)">
                                    <i class="fas <?= htmlspecialchars($th['icon']) ?>"></i>
                                    <h3><?= htmlspecialchars($th['name']) ?></h3>
                                    <p><?= htmlspecialchars($th['desc']) ?></p>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 30px;">
                        <label for="maintenance_mode">Modo Manutenção:</label>
                        <select name="maintenance_mode" id="maintenance_mode"
                            style="width: 100%; padding: 12px; border: 2px solid #8b6c42; border-radius: 4px; background: #fff; color: #3b260e; font-size: 14px; font-weight: bold; cursor: pointer;">
                            <option value="false" <?= $maintenanceMode === 'false' ? 'selected' : '' ?>>Desativado (Jogo
                                Online)</option>
                            <option value="true" <?= $maintenanceMode === 'true' ? 'selected' : '' ?>>Ativado (Jogo em
                                Manutenção)</option>
                        </select>
                        <p style="font-size: 11px; margin-top: 5px; opacity: 0.8; color: #5c3a1e; line-height: 1.4;">
                            * Quando ativado, os jogadores verão a página de manutenção medieval e não conseguirão
                            aceder a nenhuma funcionalidade do jogo. O painel de administração (`admin.php`) continuará
                            disponível para reverter esta opção.
                        </p>
                    </div>

                    <button type="submit" class="btn-save">Guardar Alterações</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateCards(input) {
            input.closest('.theme-options').querySelectorAll('.theme-card').forEach(card => card.classList.remove('active'));
            input.parentElement.classList.add('active');
        }
    </script>
</body>

</html>