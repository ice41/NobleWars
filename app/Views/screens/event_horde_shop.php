<?php
$guidons = $eventData['guidons'];
?>
<style>
.horde-shop-container { padding: 10px; background: #e3d5b8; border: 2px solid #8c5f0d; border-radius: 5px; }
.horde-shop-header { margin-bottom: 20px; font-size: 14px; }
.horde-shop-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
.horde-shop-item { background: #f4e4bc; border: 1px solid #8c5f0d; text-align: center; padding: 10px; position: relative; display: flex; flex-direction: column; justify-content: space-between; }
.horde-item-title { background: #8c5f0d; color: white; padding: 5px; margin: -10px -10px 10px -10px; font-weight: bold; border-bottom: 1px solid #5c3a1e; }
.horde-item-desc { font-size: 11px; margin: 10px 0; text-align: left; flex-grow: 1; }
.horde-item-price { margin: 10px 0; font-weight: bold; color: #8c5f0d; border-top: 1px solid #c8ab78; padding-top: 10px; }
.btn-buy { background: linear-gradient(to bottom, #2d7a2d, #1a4d1a); color: white; border: 1px solid #000; padding: 5px 10px; cursor: pointer; border-radius: 3px; font-weight: bold; width: 100%; }
.btn-buy:hover { background: linear-gradient(to bottom, #3a9a3a, #206020); }
</style>

<h2>Loja do evento (Ataque da Horda)</h2>

<div class="horde-shop-container">
    <div class="horde-shop-header">
        <div style="float: right;">
            <a href="game.php?village=<?= $village['id'] ?>&screen=inventory" class="btn" style="background: green; color: white; padding: 5px 10px;">Abrir Inventário</a>
        </div>
        Disponível Guidons: <img src="graphic/events/ataque_horda/icon_currency.webp" width="16" style="vertical-align: middle;"> <b id="shop-guidons"><?= number_format($guidons, 0, ',', '.') ?></b><br><br>
        Os itens irão permanecer no inventário após o evento terminar.
    </div>

    <?php
    $shopItems = [
        ['id' => 3063, 'name' => 'Saqueador de bárbaros', 'img' => '3063.webp', 'desc' => 'Ataques enviados a aldeias bárbaras viajam mais rápido em 5%..<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 300],
        ['id' => 3003, 'name' => 'Sigilia de desespero', 'img' => '3003.webp', 'desc' => 'Apoio enviado enquanto ativo viajará 10% mais rápido.<br><br><span style="color:green">Duração: 48:00:00<br>Aplicar a: Na aldeia</span>', 'cost' => 350],
        ['id' => 3069, 'name' => 'Booster de quartéis', 'img' => '3069.webp', 'desc' => 'Toda a velocidade de recrutamento em Quartel são 10% mais rápidos!<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 950],
        ['id' => 3072, 'name' => 'Bónus de estábulo', 'img' => '3072.webp', 'desc' => 'Toda a velocidade de recrutamento em Estábulo são 10% mais rápidos!<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 950],
        
        ['id' => 3058, 'name' => 'Bónus de construção', 'img' => '3058.webp', 'desc' => 'Todos os tempos de construção foram diminuídos em 15%!<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 1400],
        ['id' => 3018, 'name' => 'Booster de defensor', 'img' => '3018.webp', 'desc' => 'Lanceiro: +5% poder de defesa<br>Espadachim: +5% poder de defesa<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 1650],
        ['id' => 3016, 'name' => 'Booster de atacante', 'img' => '3016.webp', 'desc' => 'Viking: +5% poder do atacante<br>Cavalaria leve: +5% poder do atacante<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 1650],
        ['id' => 3066, 'name' => 'Booster de dano da catapulta', 'img' => '3066.webp', 'desc' => 'Catapulta: +25% Dano contra edifícios<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 1950],
        
        ['id' => 3042, 'name' => 'Recrutador', 'img' => '3042.webp', 'desc' => 'O recrutamento de unidades, incluindo nobres, é 5% mais rápido!<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 2300],
        ['id' => 3023, 'name' => 'Decreto nobre', 'img' => '3023.webp', 'desc' => '-10% Custo de moedas<br><br><span style="color:green">Duração: 24:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 2300],
        ['id' => 3052, 'name' => 'Booster de cavalaria pesada', 'img' => '3052.webp', 'desc' => 'Cavalaria Pesada: +20% poder de defesa e ofensivo<br><br><span style="color:green">Duração: 48:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 2800],
        ['id' => 3105, 'name' => 'Estratégias Ofensivas', 'img' => '3105.webp', 'desc' => 'Aumenta permanentemente o poder de ataque das unidades ofensivas em 2%.Pode acumular este efeito numa aldeia até 5 vezes.Viking: +2% poder do atacante Cavalaria leve: +2% poder do atacante.Arqueiro a cavalo: +2% poder do atacante<br><br><span style="color:green">Aplicar a: Na aldeia</span>', 'cost' => 2800],
        ['id' => 3106, 'name' => 'Estratégias defensivas', 'img' => '3106.webp', 'desc' => 'Aumenta permanentemente o poder de defesa das unidades defensivas em 2%.Pode acumular este efeito numa aldeia até 5 vezes.Lanceiro: +2% poder de defesa. Espadachim: +2% poder de defesa. Arqueiro: +2% poder de defesa.<br><br><span style="color:green">Duração: 48:00:00<br>Aplicar a: Na aldeia</span> ', 'cost' => 3106],
        ['id' => 95, 'name' => 'Pacote de recursos (10%)', 'img' => 'resources_percent_10.webp', 'desc' => 'Adiciona 10% da capacidade dos seus armazéns de recursos em todas as cidades.', 'cost' => 3100],
        ['id' => 3039, 'name' => 'Boas ligações', 'img' => '3039.webp', 'desc' => 'Aumenta permanentemente a capacidade de armazenamento e transporte dos comerciantes em 25% na aldeia atual.<br><br>Pode ser usado apenas uma vez por aldeia.', 'cost' => 3900],
        ['id' => 3027, 'name' => 'Esforço de guerra', 'img' => '3027.webp', 'desc' => '+30% produção de recursos<br><br><span style="color:green">Duração: 48:00:00<br>Aplicar a: Em todas as aldeias</span>', 'cost' => 3900],
        ['id' => 3024, 'name' => 'Privilégio', 'img' => '3024.webp', 'desc' => 'Adiciona 1 Nobre instantaneamente à aldeia selecionada se os requisitos de unidades forem suficientes e houver moedas e população suficiente.', 'cost' => 5400],
        ['id' => 3022, 'name' => 'Crescimento da plantação', 'img' => '3022.webp', 'desc' => 'Aumenta permanentemente o máximo da população da aldeia atual em 10%<br><br>Pode ser usado apenas uma vez por aldeia.', 'cost' => 5450],
        ['id' => 98, 'name' => 'Pacote de recursos (20%)', 'img' => 'resources_percent_20.webp', 'desc' => 'Adiciona 20% da capacidade dos seus armazéns de recursos em todas as cidades.', 'cost' => 3100],
        ['id' => 3006, 'name' => 'Baú de guerra grande', 'img' => '3006.webp', 'desc' => 'Ganhe uma quantidade de moedas de ouro na academia igual ao número de aldeias que você têm ao usar este item.', 'cost' => 6000]
    ];
    ?>

    <div class="horde-shop-grid">
        <?php foreach ($shopItems as $item): ?>
            <div class="horde-shop-item">
                <div class="horde-item-title"><?= $item['name'] ?></div>
                <div><img src="graphic/new/inventory/<?= $item['img'] ?>" width="64" style="margin: 10px 0;"></div>
                <div class="horde-item-desc"><?= $item['desc'] ?></div>
                <div class="horde-item-price">
                    <img src="graphic/events/ataque_horda/icon_currency.webp" width="16" style="vertical-align: middle;"> <?= number_format($item['cost'], 0, ',', '.') ?> Guidons
                </div>
                <button class="btn-buy" onclick="buyHordeItem(<?= $item['id'] ?>, <?= $item['cost'] ?>)">Guardar no inventário</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function buyHordeItem(itemId, cost) {
    let currentGuidons = parseInt($('#shop-guidons').text().replace(/\./g, ''));
    if (currentGuidons < cost) {
        UI.ErrorMessage('Não tens Guidons suficientes para comprar este item.');
        return;
    }

    if (!confirm('Queres comprar este item por ' + cost + ' Guidons?')) return;
    
    $.post('/game.php?village=<?= $village['id'] ?>&screen=event_horde_shop&ajax_action=buy_item', { item_id: itemId, cost: cost }, function(res) {
        if (res.success) {
            UI.SuccessMessage(res.message);
            // Formatar número com pontos (separador de milhares)
            let newText = res.new_guidons.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            $('#shop-guidons').text(newText);
        } else {
            UI.ErrorMessage(res.error);
        }
    }, 'json');
}
</script>
