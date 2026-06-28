<?php
// Server Info View
global $config;

// Helper function to render data tables
function renderInfoTable($title, $headers, $data)
{
    echo '<table class="vis" width="100%" style="margin-bottom: 20px;">';
    echo '<tr><th colspan="' . count($headers) . '">' . $title . '</th></tr>';
    echo '<tr>';
    foreach ($headers as $header) {
        echo '<th>' . $header . '</th>';
    }
    echo '</tr>';

    $rowColor = 0;
    foreach ($data as $row) {
        $rowColor++;
        $bgClass = ($rowColor % 2 == 0) ? 'row_b' : 'row_a';
        echo '<tr class="' . $bgClass . '">';
        foreach ($row as $cell) {
            echo '<td>' . $cell . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}
?>

<h1>Configurações do Mundo</h1>

<table class="vis" width="100%" style="margin-bottom: 20px;">
    <tr>
        <th colspan="2">Configurações Gerais</th>
    </tr>
    <tr>
        <td width="250">Velocidade do jogo:</td>
        <td><?= $config['speed'] ?></td>
    </tr>
    <tr>
        <td>Velocidade das unidades:</td>
        <td><?= $config['movement_speed'] ?></td>
    </tr>
    <tr>
        <td>Moral:</td>
        <td><?= $config['moral_activ'] ? 'Ativo' : 'Inativo' ?></td>
    </tr>
    <tr>
        <td>Bônus noturno:</td>
        <td><?= $config['noc'] ? 'Ativo (' . $config['noc_poczatek'] . 'h - ' . $config['noc_koniec'] . 'h)' : 'Inativo' ?>
        </td>
    </tr>
    <tr>
        <td>Proteção de iniciantes:</td>
        <td><?= $config['noob_protection'] ?> minutos</td>
    </tr>
    <tr>
        <td>Limite de membros na tribo:</td>
        <td>Sem limite (padrão)</td>
    </tr>
    <tr>
        <td>Sair da tribo:</td>
        <td><?= $config['leave_ally'] ? 'Permitido' : 'Proibido' ?></td>
    </tr>
</table>

<h3>Unidades / Combate</h3>
<table class="vis" width="100%" style="margin-bottom: 20px;">
    <tr>
        <td width="250">Arqueiros:</td>
        <td><?= $config['archer'] ? 'Ativo' : 'Inativo' ?></td>
    </tr>
    <tr>
        <td>Igreja:</td>
        <td><?= $config['church'] ? 'Ativo' : 'Inativo' ?> - Influência religiosa necessária</td>
    </tr>
    <tr>
        <td>Defesa base da aldeia:</td>
        <td>20</td>
    </tr>
    <tr>
        <td>Paladino:</td>
        <td><?= isset($config['pala_bonus']) ? 'Ativo (com itens)' : 'Inativo' ?></td>
    </tr>
</table>

<h3>Nobreza</h3>
<table class="vis" width="100%" style="margin-bottom: 20px;">
    <tr>
        <td width="250">Alcance máximo:</td>
        <td><?= $config['snob_range'] ?> campos</td>
    </tr>
    <tr>
        <td>Sistema de academias:</td>
        <td><?= $config['ag_style'] == 0 ? 'Por pacotes' : ($config['ag_style'] == 1 ? 'Cunhagem de Moedas' : 'Níveis (1-3)') ?>
        </td>
    </tr>
    <tr>
        <td>Lealdade reduzida por ataque:</td>
        <td><?= $config['pop_min'] ?> - <?= $config['pop_max'] ?></td>
    </tr>
    <tr>
        <td>Custo do Nobre:</td>
        <td>
            <?php
            $snob_costs = $config['custo_moedas'] ?? ['wood' => 40000, 'stone' => 50000, 'iron' => 50000];
            echo "<img src='graphic/icons/wood.png'> " . $snob_costs['wood'] . " ";
            echo "<img src='graphic/icons/stone.png'> " . $snob_costs['stone'] . " ";
            echo "<img src='graphic/icons/iron.png'> " . $snob_costs['iron'];
            ?>
        </td>
    </tr>
</table>

<?php
// Production Table Data
$prodData = [];
foreach ($config['arr_production'] as $lvl => $prod) {
    if ($lvl == 0)
        continue;
    $prodData[] = [$lvl, $prod * $config['speed']];
}
renderInfoTable('Produção de Recursos (por hora)', ['Nível', 'Madeira / Argila / Ferro'], $prodData);

// Capacity Table Data
$capData = [];
// Assuming max level is 30 for warehouse
for ($i = 1; $i <= 30; $i++) {
    $storage = $config['arr_maxstorage'][$i] ?? '-';
    $hide = $config['arr_maxhide'][$i] ?? '-';
    // Only add row if data exists for at least one
    if ($storage !== '-' || $hide !== '-') {
        $capData[] = [$i, $storage, $hide];
    }
}
renderInfoTable('Capacidade de Edifícios', ['Nível', 'Armazém', 'Esconderijo'], $capData);

// Farm Table Data
$farmData = [];
for ($i = 1; $i <= 30; $i++) {
    if (isset($config['arr_farm'][$i])) {
        $farmData[] = [$i, $config['arr_farm'][$i]];
    }
}
renderInfoTable('Fazenda', ['Nível', 'População Máxima'], $farmData);

// Wall Table Data
$wallData = [];
for ($i = 0; $i <= 20; $i++) {
    if (isset($config['arr_wall_bonus'][$i])) {
        $bonus = ($config['arr_wall_bonus'][$i] * 100) . '%';
        $defense = $config['arr_basic_defense'][$i] ?? 0;
        $wallData[] = [$i, '+' . $bonus, $defense];
    }
}
renderInfoTable('Muralha', ['Nível', 'Bônus de Defesa', 'Defesa Base'], $wallData);
?>