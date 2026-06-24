<?php

/**
 * Configuração Completa do Mundo 1
 * 
 * Este arquivo contém TODAS as configurações do mundo.
 * Cada mundo é completamente independente.
 */

return array(
  'event_horse_race_active' => false,
  'event_horse_race_end' => '30.05.2026 00:24',
  'event_spring_active' => false,
  'event_spring_end' => '12.05.2026 23:54',
  'event_horde_active' => true,
  'event_horde_end' => '30.08.2026 23:03',
  // ============================================
  // IDENTIFICAÇÃO DO SERVIDOR
  // ============================================
  '__SERVER__ID' => 1,

  // ============================================
  // BASE DE DADOS
  // ============================================
  'db_host' => 'localhost',
  'db_user' => 'root',
  'db_pw' => '',
  'db_name' => 'lan_1',

  // ============================================
  // VELOCIDADE DO JOGO
  // ============================================
  'speed' => 5000,              // Velocidade do Mundo (multiplicador geral)
  'movement_speed' => 801,      // Velocidade de Movimento (quanto MAIOR, mais rápido)
  'dealer_time' => 5,           // Tempo de viagem dos mercadores (minutos por campo)

  // ============================================
  // COMBATE E DEFESA
  // ============================================
  'reason_defense' => 10,       // Defesa base da aldeia
  'cancel_movement' => 1,      // Tempo para cancelar movimento (minutos)

  // ============================================
  // SISTEMA DE MORAL
  // ============================================
  'moral_activ' => true,        // Moral ativado
  'min_moral' => 1,             // Moral mínimo em %

  // ============================================
  // EDIFÍCIOS
  // ============================================
  'church' => true,             // Igreja ativada
  'watchtower' => true,         // Torre de Vigia ativada
  'kosciol_i_mnisi' => true,    // Igrejas e Monges
  'destroy_mode_main' => true,  // Permitir destruir edifícios

  // ============================================
  // UNIDADES
  // ============================================
  'archer' => true,             // Arqueiros ativados

  // ============================================
  // NOBREZA
  // ============================================
  'agreement_per_hour' => 1,    // Apoio recuperado por hora
  'snob_range' => 100,          // Alcance máximo do nobre (campos)
  'ag_style' => 1,              // Estilo de nobreza (0 ou 1)
  'pop_min' => 20,              // Apoio mínimo quebrado por nobre
  'pop_min_paladin' => 30,      // Com item de paladino
  'pop_max' => 35,              // Apoio máximo quebrado

  // ============================================
  // PROTEÇÃO
  // ============================================
  'noob_protection' => 180,     // Proteção de iniciante (minutos)

  // ============================================
  // MERCADO
  // ============================================
  'cancel_dealers' => 5,        // Tempo para cancelar mercadores

  // ============================================
  // ESTILOS DE JOGO
  // ============================================
  'bh_style' => 1,              // Estilo de fazenda (0 ou 1)

  // ============================================
  // ALIANÇAS
  // ============================================
  'create_ally' => true,        // Permitir criar alianças
  'leave_ally' => true,         // Permitir sair de alianças
  'close_ally' => false,        // Permitir dissolver alianças

  // ============================================
  // RESTRIÇÕES
  // ============================================
  'no_actions' => false,        // Desativar todas as ações
  'not_more_villages' => false, // Limitar número de aldeias
  'village_choose_direction' => true, // Escolher direção da aldeia

  // ============================================
  // CUSTO DAS MOEDAS (para Nobres)
  // ============================================
  'm_wood' => '28000',
  'm_stone' => '30000',
  'm_iron' => '25000',
  'custo_moedas' => array(
    'wood' => '28000',
    'stone' => '30000',
    'iron' => '25000',
  ),

  // ============================================
  // BÔNUS NOTURNO
  // ============================================
  'noc' => true,                // Bônus noturno ativado
  'noc_poczatek' => 22,         // Hora de início (22h)
  'noc_koniec' => 8,            // Hora de fim (8h)

  // ============================================
  // ALDEIAS BÁRBARAS
  // ============================================
  'create_users_and_villages' => true,
  'opuszczone_na_gracza' => 2,
  'rozwoj_barbar_wiosek' => true,
  'rozwoj_barabar_punkty' => 5000,
  'bot_barbar_rad' => 1,
  'left_name' => 'Aldeia Bárbara',

  // ============================================
  // SISTEMAS ADICIONAIS
  // ============================================
  'awards' => true,             // Sistema de conquistas
  'premium' => true,            // Sistema premium
  'premium_enabled' => true,
  'wioski_na_start' => 1,       // Aldeias iniciais para novos jogadores

  // ============================================
  // FEATURE TOGGLES (Ativar/Desativar Funcionalidades)
  // ============================================
  'flags_enabled' => true,        // Sistema de Bandeiras
  'inventory_enabled' => true,    // Sistema de Inventário
  'daily_bonus_enabled' => true,  // Bônus Diário
  'questlog_enabled' => false,     // Sistema de Questlog
  'paladin_enabled' => true,      // Sistema de Paladino
  'theater_enabled' => false,      // Sistema de Teatro



  // ============================================
  // NÍVEIS MÁXIMOS DE EDIFÍCIOS
  // ============================================
  'max_stage' => array(
    'main' => 30,
    'barracks' => 25,
    'stable' => 20,
    'garage' => 15,
    'church' => 3,
    'snob' => 2,
    'smith' => 20,
    'place' => 1,
    'statue' => 1,
    'market' => 25,
    'wood' => 30,
    'stone' => 30,
    'iron' => 30,
    'farm' => 30,
    'storage' => 30,
    'hide' => 10,
    'wall' => 20,
    'watchtower' => 20,
  ),

  // ============================================
  // PRODUÇÃO DE RECURSOS POR HORA (por nível)
  // ============================================
  'arr_production' => array(
    "0" => "5",
    "1" => "30",
    "2" => "35",
    "3" => "41",
    "4" => "47",
    "5" => "55",
    "6" => "64",
    "7" => "74",
    "8" => "86",
    "9" => "100",
    "10" => "117",
    "11" => "136",
    "12" => "158",
    "13" => "184",
    "14" => "214",
    "15" => "249",
    "16" => "289",
    "17" => "337",
    "18" => "391",
    "19" => "455",
    "20" => "530",
    "21" => "616",
    "22" => "717",
    "23" => "833",
    "24" => "969",
    "25" => "1127",
    "26" => "1311",
    "27" => "1525",
    "28" => "1774",
    "29" => "2063",
    "30" => "2400"
  ),

  // ============================================
  // BÔNUS DE DEFESA DA MURALHA (por nível)
  // ============================================
  'arr_wall_bonus' => array(
    "0" => "0.00",
    "1" => "0.04",
    "2" => "0.08",
    "3" => "0.12",
    "4" => "0.16",
    "5" => "0.20",
    "6" => "0.24",
    "7" => "0.29",
    "8" => "0.34",
    "9" => "0.39",
    "10" => "0.44",
    "11" => "0.49",
    "12" => "0.55",
    "13" => "0.60",
    "14" => "0.66",
    "15" => "0.72",
    "16" => "0.79",
    "17" => "0.85",
    "18" => "0.92",
    "19" => "0.99",
    "20" => "1.07",
  ),

  // ============================================
  // DEFESA BÁSICA DA ALDEIA (por nível)
  // ============================================
  'arr_basic_defense' => array(
    "0" => "0",
    "1" => "70",
    "2" => "120",
    "3" => "170",
    "4" => "220",
    "5" => "270",
    "6" => "320",
    "7" => "370",
    "8" => "420",
    "9" => "470",
    "10" => "520",
    "11" => "570",
    "12" => "620",
    "13" => "670",
    "14" => "720",
    "15" => "760",
    "16" => "820",
    "17" => "870",
    "18" => "920",
    "19" => "970",
    "20" => "1020",
  ),

  // ============================================
  // CAPACIDADE DO ARMAZÉM (por nível)
  // ============================================
  'arr_maxstorage' => array(
    "1" => "1000",
    "2" => "1229",
    "3" => "1512",
    "4" => "1859",
    "5" => "2285",
    "6" => "2810",
    "7" => "3454",
    "8" => "4247",
    "9" => "5222",
    "10" => "6420",
    "11" => "7893",
    "12" => "9705",
    "13" => "11932",
    "14" => "14670",
    "15" => "18037",
    "16" => "22177",
    "17" => "27266",
    "18" => "33523",
    "19" => "41217",
    "20" => "50675",
    "21" => "62305",
    "22" => "76604",
    "23" => "94184",
    "24" => "115798",
    "25" => "142373",
    "26" => "175047",
    "27" => "215219",
    "28" => "264611",
    "29" => "325337",
    "30" => "400000"
  ),

  // ============================================
  // CAPACIDADE DO ESCONDERIJO (por nível)
  // ============================================
  'arr_maxhide' => array(
    "1" => "100",
    "2" => "135",
    "3" => "183",
    "4" => "247",
    "5" => "333",
    "6" => "450",
    "7" => "333",
    "8" => "822",
    "9" => "1110",
    "10" => "1500"
  ),

  // ============================================
  // CAPACIDADE DA FAZENDA (por nível) - Estilo 1
  // ============================================
  'arr_farm' => array(
    "1" => "240",
    "2" => "281",
    "3" => "329",
    "4" => "386",
    "5" => "452",
    "6" => "530",
    "7" => "622",
    "8" => "729",
    "9" => "854",
    "10" => "1002",
    "11" => "1174",
    "12" => "1376",
    "13" => "1613",
    "14" => "1891",
    "15" => "2216",
    "16" => "2598",
    "17" => "3045",
    "18" => "3569",
    "19" => "4183",
    "20" => "4904",
    "21" => "5748",
    "22" => "6737",
    "23" => "7896",
    "24" => "9255",
    "25" => "10848",
    "26" => "12715",
    "27" => "14904",
    "28" => "17469",
    "29" => "20476",
    "30" => "24000",
    "31" => "24642",
    "32" => "26472",
    "33" => "47000"
  ),

  // ============================================
  // EDIFÍCIOS QUE COMEÇAM NO NÍVEL 1
  // ============================================
  'arr_builds_starts_by_one' => array("main", "farm", "storage", "hide", "place"),

  // ============================================
  // NÚMERO DE COMERCIANTES (por nível do mercado)
  // ============================================
  'arr_dealers' => array(
    0 => 0,
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 6,
    10 => 10,
    11 => 11,
    12 => 14,
    13 => 19,
    14 => 26,
    15 => 35,
    16 => 46,
    17 => 59,
    18 => 74,
    19 => 91,
    20 => 110,
    21 => 131,
    22 => 154,
    23 => 179,
    24 => 206,
    25 => 235
  ),

  // ============================================
  // BÔNUS DE ITENS DO PALADINO
  // ============================================
  'pala_bonus' => array(
    'unit_spear' => array(1.3, 1.2, 'Alabarda de Guan Yu'),
    'unit_sword' => array(1.4, 1.3, 'Espada Longa de Ullrich'),
    'unit_axe' => array(1.4, 1.3, 'Machado de Guerra de Thogard'),
    'unit_archer' => array(1.3, 1.2, 'Arco Longo de Nimrod'),
    'unit_spy' => array(1, 1, 'Telescópio de Kalid'),
    'unit_light' => array(1.3, 1.2, 'Lança de Miezko'),
    'unit_marcher' => array(1.3, 1.2, 'Arco Composto de Nimrod'),
    'unit_heavy' => array(1.3, 1.2, 'Estandarte de Baptiste'),
    'unit_ram' => array(1, 1, 'Estrela da Manhã de Carol'),
    'unit_catapult' => array(1, 10, 'Fogueira de Aletheia'),
    'unit_snob' => array(1.3, 1.2, 'Cetro de Vasco'),
  ),

  // ============================================
  // MENSAGENS DO SISTEMA
  // ============================================
  'mail' => array(
    'nadawca' => 'Sistema',
    'temat' => 'Bem-vindo!',
    'text' => 'Bem-vindo ao jogo!'
  ),

  // ============================================
  // MENSAGEM DE BOAS-VINDAS
  // ============================================
  'powitalna' => array(
    'wsk_tyg_img' => '../graphic/unit/unit_ram.png',
    'wsk_tyg_text' => 'Os arietes são fortes como defesa contra a cavalaria.',
    'kolor' => 'red'
  ),

  // ============================================
  // CÓDIGOS PREMIUM (exemplo)
  // ============================================
  'kod' => array(
    '1' => array('numer' => 'XXXXX', 'tresc' => 'XXXXXXX', 'zl' => 'X,XX'),
    '2' => array('numer' => 'XXXXX', 'tresc' => 'XXXXXXX', 'zl' => 'X,XX'),
    '3' => array('numer' => 'XXXXX', 'tresc' => 'XXXXXXX', 'zl' => 'XX,XX'),
  ),
);
