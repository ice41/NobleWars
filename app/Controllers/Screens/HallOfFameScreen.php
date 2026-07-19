<?php
namespace App\Controllers\Screens;

class HallOfFameScreen
{
    private $db;
    private $world;
    private $worldConfig;

    public function __construct($world = '1')
    {
        require_once __DIR__ . '/../../Core/LanguageManager.php';
        require_once __DIR__ . '/../../Helpers/language_helper.php';
        \init_locale();

        $this->world = $world;
        $this->loadWorldConfig();
        
        $isClosed = isset($this->worldConfig['is_closed']) && $this->worldConfig['is_closed'] == true;
        if (!$isClosed) {
            $this->connectToWorld();
        }
    }

    private function loadWorldConfig()
    {
        $worldConfigPath = __DIR__ . '/../../Config/Worlds/' . $this->world . '.php';
        
        if (!file_exists($worldConfigPath)) {
            die("World config file not found: " . $worldConfigPath);
        }

        $this->worldConfig = include $worldConfigPath;
        
        if (!is_array($this->worldConfig)) {
            die("Invalid world config format in: " . $worldConfigPath);
        }
    }

    private function connectToWorld()
    {
        // Usar credenciais do ficheiro do mundo específico
        $dbHost = $this->worldConfig['db_host'] ?? null;
        $dbUser = $this->worldConfig['db_user'] ?? null;
        $dbPass = $this->worldConfig['db_pw'] ?? $this->worldConfig['db_pass'] ?? null;
        $dbName = $this->worldConfig['db_name'] ?? null;

        if (!$dbHost || !$dbUser || !$dbName) {
            die("Missing database configuration in world config file for world: " . $this->world);
        }

        $this->db = @\mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

        if (!$this->db) {
            die("Erro ao conectar ao mundo " . $this->world . " (BD: $dbName): " . \mysqli_connect_error());
        }
        
        \mysqli_set_charset($this->db, 'utf8');
        \mysqli_query($this->db, "SET SESSION sql_mode = ''") or die(\mysqli_error($this->db));
    }

    public function render()
    {
        $data = $this->getHallOfFameData();
        $data['world'] = $this->world;
        $data['worlds_list'] = $this->getWorldsList();
        return $this->renderView($data);
    }

private function getWorldsList()
{
    $worlds_list = [];
    $worldsDir = __DIR__ . '/../../Config/Worlds';
    
    if (is_dir($worldsDir)) {
        $files = glob($worldsDir . '/*.php');
        foreach ($files as $file) {
            $worldId = basename($file, '.php');
            if (empty($worldId)) {
                continue;
            }
            
            $worldConfig = @include $file;
            if (!is_array($worldConfig)) {
                continue;
            }
            
            $isClosed = isset($worldConfig['is_closed']) && $worldConfig['is_closed'] == true;
            
            // Extrair número para ordenação (caso exista)
            preg_match('/\d+/', $worldId, $numMatch);
            $sortNum = isset($numMatch[0]) ? (int)$numMatch[0] : 999;
            
            // Nome amigável para exibição
            if (preg_match('/^([a-zA-Z]+)(\d+)$/', $worldId, $nameMatch)) {
                $prefix = ucfirst($nameMatch[1]);
                $number = $nameMatch[2];
                $worldName = "$prefix $number";
            } elseif (preg_match('/^(\d+)$/', $worldId, $numMatchOnly)) {
                $worldName = "Mundo " . $numMatchOnly[1];
            } else {
                $worldName = ucfirst(str_replace('_', ' ', $worldId));
            }
            
            $worlds_list[] = [
                "id" => $worldId, 
                "name" => $worldName, 
                "is_closed" => $isClosed,
                "sort_num" => $sortNum
            ];
        }
        
        usort($worlds_list, function ($a, $b) {
            return $a['sort_num'] - $b['sort_num'];
        });
    }
    return $worlds_list;
}

    private function getHallOfFameData()
    {
        $isClosed = isset($this->worldConfig['is_closed']) && $this->worldConfig['is_closed'] == true;
        if ($isClosed) {
            $archivedData = $this->getArchivedHallOfFameData();
            // Se existirem dados arquivados, usa-os
            if (!empty($archivedData['top_players']) || !empty($archivedData['top_tribe'])) {
                return $archivedData;
            }
            
            // Fallback: Se o arquivo estiver vazio (ex: mundo fechado antes desta migração), tenta ler da BD viva
            if ($this->connectToWorldNoError()) {
                return $this->getLiveHallOfFameData();
            }
            
            return $archivedData;
        }

        return $this->getLiveHallOfFameData();
    }

    private function connectToWorldNoError(): bool
    {
        $dbHost = $this->worldConfig['db_host'] ?? null;
        $dbUser = $this->worldConfig['db_user'] ?? null;
        $dbPass = $this->worldConfig['db_pw'] ?? $this->worldConfig['db_pass'] ?? null;
        $dbName = $this->worldConfig['db_name'] ?? null;

        if (!$dbHost || !$dbUser || !$dbName) {
            return false;
        }

        $this->db = @\mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        if ($this->db) {
            \mysqli_set_charset($this->db, 'utf8');
            @\mysqli_query($this->db, "SET SESSION sql_mode = ''");
            return true;
        }
        return false;
    }

    private function getLiveHallOfFameData()
    {
        $data = [];

        $result = \mysqli_query($this->db, "SELECT id, username, points FROM users ORDER BY points DESC LIMIT 3");
        $data['top_players'] = [];
        if ($result) {
            while ($row = \mysqli_fetch_assoc($result)) {
                $data['top_players'][] = $row;
            }
        }

        $result = \mysqli_query($this->db, "SELECT id, `short`, `name`, points FROM ally ORDER BY points DESC LIMIT 3");
        $data['top_tribes'] = [];
        if ($result) {
            while ($row = \mysqli_fetch_assoc($result)) {
                $row['tag'] = $row['short'];
                
                $tribeId = $row['id'];
                $countRes = \mysqli_query($this->db, "SELECT COUNT(*) as cnt FROM users WHERE ally = '$tribeId'");
                $countRow = $countRes ? \mysqli_fetch_assoc($countRes) : null;
                $row['members_count'] = $countRow ? (int)$countRow['cnt'] : 0;
                $row['members'] = ''; // Manter vazio/compatibilidade
                
                $data['top_tribes'][] = $row;
            }
        }
        
        $data['top_tribe'] = $data['top_tribes'][0] ?? null;

        $data['achievements'] = [];

        $resVillas = \mysqli_query($this->db, "SELECT username, villages FROM users ORDER BY villages DESC LIMIT 1");
        $topVillas = $resVillas ? \mysqli_fetch_assoc($resVillas) : null;
        $data['achievements']['conqueror'] = [
            'title' => \__('screens.hall_of_fame.conqueror'),
            'items' => [
                '100_villages' => [
                    'label' => \__('screens.hall_of_fame.has_villages_first', ['count' => 100]),
                    'winner' => ($topVillas && $topVillas['villages'] >= 100) ? $topVillas['username'] : \__('screens.hall_of_fame.nobody_yet'),
                    'image' => 'graphic/awards/odznaczenie_podbicia.png'
                ],
                '2_villages' => [
                    'label' => \__('screens.hall_of_fame.has_villages_first', ['count' => 2]),
                    'winner' => ($topVillas && $topVillas['villages'] >= 2) ? $topVillas['username'] : \__('screens.hall_of_fame.nobody_yet'),
                    'image' => 'graphic/awards/odznaczenie_podbicia.png'
                ]
            ]
        ];

        $topPoints = $data['top_players'][0] ?? null;
        $data['achievements']['champion'] = [
            'title' => \__('screens.hall_of_fame.points_champion'),
            'items' => [
                '10k_points' => [
                    'label' => \__('screens.hall_of_fame.reached_points_first', ['points' => '10.000']),
                    'winner' => ($topPoints && $topPoints['points'] >= 10000) ? $topPoints['username'] : \__('screens.hall_of_fame.nobody_yet'),
                    'image' => 'graphic/awards/odznaczenie_punkty.png'
                ]
            ]
        ];

        $resODA = \mysqli_query($this->db, "SELECT username, killed_units_att FROM users ORDER BY killed_units_att DESC LIMIT 1");
        $topODA = $resODA ? \mysqli_fetch_assoc($resODA) : null;
        $data['achievements']['battle_lord'] = [
            'title' => \__('screens.hall_of_fame.battlefield_master'),
            'items' => [
                '10k_kills' => [
                    'label' => \__('screens.hall_of_fame.defeated_units_first', ['count' => '10.000']),
                    'winner' => ($topODA && $topODA['killed_units_att'] >= 10000) ? $topODA['username'] : \__('screens.hall_of_fame.nobody_yet'),
                    'image' => 'graphic/awards/odznaczenie_zabite_jednostki.png'
                ]
            ]
        ];

        $resCoins = \mysqli_query($this->db, "SELECT username, snob_coins FROM users ORDER BY snob_coins DESC LIMIT 1");
        $topCoins = $resCoins ? \mysqli_fetch_assoc($resCoins) : null;
        $data['achievements']['gold_rush'] = [
            'title' => \__('screens.awards.names.odznaczenie_monety'),
            'items' => [
                '500_coins' => [
                    'label' => \__('screens.hall_of_fame.reached_points_first', ['points' => '500 moedas']),
                    'winner' => ($topCoins && $topCoins['snob_coins'] >= 500) ? $topCoins['username'] : \__('screens.hall_of_fame.nobody_yet'),
                    'image' => 'graphic/awards/odznaczenie_monety.png'
                ]
            ]
        ];

        $resLoot = \mysqli_query($this->db, "SELECT username, zlupione_sur FROM users ORDER BY zlupione_sur DESC LIMIT 1");
        $topLoot = $resLoot ? \mysqli_fetch_assoc($resLoot) : null;
        $data['achievements']['looter'] = [
            'title' => \__('screens.awards.names.odznaczenie_lupy'),
            'items' => [
                '1m_loot' => [
                    'label' => \__('screens.hall_of_fame.reached_points_first', ['points' => '1.000.000']),
                    'winner' => ($topLoot && $topLoot['zlupione_sur'] >= 1000000) ? $topLoot['username'] : \__('screens.hall_of_fame.nobody_yet'),
                    'image' => 'graphic/awards/odznaczenie_lupy.png'
                ]
            ]
        ];

        $data['daily_awards'] = [
            'attacker' => ['name' => \__('screens.hall_of_fame.best_attacker'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_att_kill.png'],
            'defender' => ['name' => \__('screens.hall_of_fame.best_defender'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_def_kill.png'],
            'plunderer' => ['name' => \__('screens.hall_of_fame.best_raider'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_farmed_vills.png'],
            'farmer' => ['name' => \__('screens.hall_of_fame.best_looter'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_lupy.png']
        ];

        return $data;
    }

    private function getArchivedHallOfFameData()
    {
        $data = [
            'top_players' => [],
            'top_tribe' => null,
            'top_tribes' => [],
            'achievements' => [],
            'daily_awards' => []
        ];

        try {
            require_once __DIR__ . '/../../Core/Database.php';
            $globalDb = \App\Core\Database::getInstance(\App\Core\Database::getGlobalDbName());
            
            $worldDbName = $this->worldConfig['db_name'] ?? ('lan_' . $this->world);
            
            $rows = $globalDb->fetchAll(
                "SELECT * FROM hall_of_fame WHERE world_db = ? ORDER BY rank ASC", 
                [$worldDbName]
            );

            // Se não encontrou pelo nome do banco, tenta pelo nome amigável do mundo "Mundo X"
            if (empty($rows)) {
                preg_match('/(\d+)/', $worldDbName, $m);
                $worldNumber = $m[1] ?? $this->world;
                $worldName = 'Mundo ' . $worldNumber;
                $rows = $globalDb->fetchAll(
                    "SELECT * FROM hall_of_fame WHERE world_name = ? ORDER BY rank ASC",
                    [$worldName]
                );
            }

            foreach ($rows as $row) {
                if ($row['type'] === 'player') {
                    $data['top_players'][] = [
                        'id' => $row['id'],
                        'username' => $row['name'],
                        'points' => $row['points'],
                        'villages' => $row['villages']
                    ];
                    
                    // Decode conquistas a partir da linha do primeiro classificado (Rank 1)
                    if ((int)$row['rank'] === 1) {
                        if (!empty($row['achievements'])) {
                            $achDetails = json_decode($row['achievements'], true);
                            if (is_array($achDetails)) {
                                $data['achievements'] = [
                                    'conqueror' => [
                                        'title' => \__('screens.hall_of_fame.conqueror'),
                                        'items' => [
                                            '100_villages' => [
                                                'label' => \__('screens.hall_of_fame.has_villages_first', ['count' => 100]),
                                                'winner' => !empty($achDetails['conqueror']['100_villages']) ? $achDetails['conqueror']['100_villages'] : \__('screens.hall_of_fame.nobody_yet'),
                                                'image' => 'graphic/awards/odznaczenie_podbicia.png'
                                            ],
                                            '2_villages' => [
                                                'label' => \__('screens.hall_of_fame.has_villages_first', ['count' => 2]),
                                                'winner' => !empty($achDetails['conqueror']['2_villages']) ? $achDetails['conqueror']['2_villages'] : \__('screens.hall_of_fame.nobody_yet'),
                                                'image' => 'graphic/awards/odznaczenie_podbicia.png'
                                            ]
                                        ]
                                    ],
                                    'champion' => [
                                        'title' => \__('screens.hall_of_fame.points_champion'),
                                        'items' => [
                                            '10k_points' => [
                                                'label' => \__('screens.hall_of_fame.reached_points_first', ['points' => '10.000']),
                                                'winner' => !empty($achDetails['champion']['10k_points']) ? $achDetails['champion']['10k_points'] : \__('screens.hall_of_fame.nobody_yet'),
                                                'image' => 'graphic/awards/odznaczenie_punkty.png'
                                            ]
                                        ]
                                    ],
                                    'battle_lord' => [
                                        'title' => \__('screens.hall_of_fame.battlefield_master'),
                                        'items' => [
                                            '10k_kills' => [
                                                'label' => \__('screens.hall_of_fame.defeated_units_first', ['count' => '10.000']),
                                                'winner' => !empty($achDetails['battle_lord']['10k_kills']) ? $achDetails['battle_lord']['10k_kills'] : \__('screens.hall_of_fame.nobody_yet'),
                                                'image' => 'graphic/awards/odznaczenie_zabite_jednostki.png'
                                            ]
                                        ]
                                    ],
                                    'gold_rush' => [
                                        'title' => \__('screens.awards.names.odznaczenie_monety'),
                                        'items' => [
                                            '500_coins' => [
                                                'label' => \__('screens.hall_of_fame.reached_points_first', ['points' => '500 moedas']),
                                                'winner' => !empty($achDetails['gold_rush']['500_coins']) ? $achDetails['gold_rush']['500_coins'] : \__('screens.hall_of_fame.nobody_yet'),
                                                'image' => 'graphic/awards/odznaczenie_monety.png'
                                            ]
                                        ]
                                    ],
                                    'looter' => [
                                        'title' => \__('screens.awards.names.odznaczenie_lupy'),
                                        'items' => [
                                            '1m_loot' => [
                                                'label' => \__('screens.hall_of_fame.reached_points_first', ['points' => '1.000.000']),
                                                'winner' => !empty($achDetails['looter']['1m_loot']) ? $achDetails['looter']['1m_loot'] : \__('screens.hall_of_fame.nobody_yet'),
                                                'image' => 'graphic/awards/odznaczenie_lupy.png'
                                            ]
                                        ]
                                    ]
                                ];
                            }
                        }
                    }
                } elseif ($row['type'] === 'tribe') {
                    $data['top_tribes'][] = [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'tag' => $row['tag'],
                        'points' => $row['points'],
                        'members_count' => $row['members'] ?? 0,
                        'members' => $row['member_list']
                    ];
                }
            }
            
            $data['top_tribe'] = $data['top_tribes'][0] ?? null;
        } catch (\Exception $e) {
            // Log or fallback
        }

        // Medalhas diárias estáticas por padrão
        $data['daily_awards'] = [
            'attacker' => ['name' => \__('screens.hall_of_fame.best_attacker'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_att_kill.png'],
            'defender' => ['name' => \__('screens.hall_of_fame.best_defender'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_def_kill.png'],
            'plunderer' => ['name' => \__('screens.hall_of_fame.best_raider'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_farmed_vills.png'],
            'farmer' => ['name' => \__('screens.hall_of_fame.best_looter'), 'winner' => \__('screens.hall_of_fame.nobody_yet'), 'image' => 'graphic/awards/day_lupy.png']
        ];

        return $data;
    }

    private function renderView($data)
    {
        extract($data);
        
        global $conf;
        if (empty($conf) || !isset($conf['index_theme'])) {
            require __DIR__ . '/../../../public/configs/config.php';
        }
        $theme = $conf['index_theme'] ?? 'classic';
        $viewFile = $theme == 'modern' ? 'hall_of_fame_modern.php' : 'hall_of_fame_classic.php';
        
        $viewPath = __DIR__ . '/../../Views/' . $viewFile;
        
        if (!file_exists($viewPath)) {
            die("View file not found: " . $viewPath);
        }
        
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}