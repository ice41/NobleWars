<?php
// Validar variáveis principais
$dealers_available = $dealers_available ?? 0;
$dealers_total = $dealers_total ?? 1;
?>


<?php if (!empty($error)): ?>
    <div  class="bold text-red mb-10">
        <?= $error ?>
    </div>
<?php endif; ?>

<?php
// Building Header (Market Image + Info)
$min = 10;
$max = 10; // Placeholder
$dbname = 'market';
$market_lvl = $village['market'] ?? 0;
?>
<table width="100%">
    <tr>
        <td valign="top" width="100">
            <?php
            $img_idx = ($market_lvl > 50) ? 3 : (($market_lvl > 20) ? 2 : 1);
            ?>
            <img src="graphic/big_buildings/market<?= $img_idx ?>.png" title="<?= __('screens.market.title') ?>"
                alt="" />
        </td>
        <td valign="top">
            <h2>
                <?= __('screens.market.title') ?> (
                <?= ($market_lvl > 0) ? __('screens.common.level') . ' ' . $market_lvl : __('screens.market.not_built') ?>)
            </h2>
            <p>
                <?= __('screens.market.description') ?>
            </p>
        </td>
    </tr>
</table>
<br />

<table width="100%">
    <tr>
        <td valign="top" width="150">
            <table class="vis" width="100%">
                <?php
                $links = [
                    'other_offer' => __('screens.market.commerce') ?? 'Comércio',
                    'premium' => __('screens.market.premium_exchange') ?? 'Troca Premium',
                    'own_offer' => __('screens.market.create_offers') ?? 'Criar ofertas',
                    'send' => __('screens.market.send_resources') ?? 'Enviar recursos',
                    'transports' => __('screens.market.transports') ?? 'Transporte',
                    'merchant_status' => __('screens.market.merchant_status') ?? 'Status dos mercadores',
                    'all_offers' => __('screens.market.all_my_offers') ?? 'Todas as minhas ofertas'
                ];
                $active_mode = $_GET['mode'] ?? 'send';

                foreach ($links as $m => $label):
                    $selected = ($m === $active_mode) ? 'class="selected"' : '';
                    ?>
                    <tr>
                        <td <?= $selected ?> width="120">
                            <a href="game.php?village=<?= $village['id'] ?>&screen=market&mode=<?= $m ?>">
                                <?= $label ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>

        <td valign="top" width="*">
            <!-- Official Header Info -->
            <table class="vis p-5" width="100%"  style="background-color: #f4e4bc; border: 1px solid #7d510f;">
                <tr>
                    <td>
                        <b><?= __('screens.market.dealers') ?>: <?= $dealers_total - ($summary['counts']['total_in_use'] ?? 0) ?>/<?= $dealers_total ?></b>
                        &nbsp;&nbsp;
                        <b><?= __('screens.market.max_transport') ?>: <?= number_format($dealers_total * 1000) ?></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><?= __('screens.market.incoming_res') ?? 'A chegar' ?>:</b>
                        <?php if($summary['res_incoming']['wood']): ?><img src="graphic/icons/wood.png"> <?= number_format($summary['res_incoming']['wood'], 0, ',', '.') ?><?php endif; ?>
                        <?php if($summary['res_incoming']['stone']): ?><img src="graphic/icons/stone.png"> <?= number_format($summary['res_incoming']['stone'], 0, ',', '.') ?><?php endif; ?>
                        <?php if($summary['res_incoming']['iron']): ?><img src="graphic/icons/iron.png"> <?= number_format($summary['res_incoming']['iron'], 0, ',', '.') ?><?php endif; ?>
                        <?php if(!$summary['res_incoming']['wood'] && !$summary['res_incoming']['stone'] && !$summary['res_incoming']['iron']): ?>---<?php endif; ?>
                        
                        &nbsp;&nbsp;
                        <b><?= __('screens.market.outgoing_res') ?? 'De saída' ?>:</b>
                        <?php if($summary['res_outgoing']['wood']): ?><img src="graphic/icons/wood.png"> <?= number_format($summary['res_outgoing']['wood'], 0, ',', '.') ?><?php endif; ?>
                        <?php if($summary['res_outgoing']['stone']): ?><img src="graphic/icons/stone.png"> <?= number_format($summary['res_outgoing']['stone'], 0, ',', '.') ?><?php endif; ?>
                        <?php if($summary['res_outgoing']['iron']): ?><img src="graphic/icons/iron.png"> <?= number_format($summary['res_outgoing']['iron'], 0, ',', '.') ?><?php endif; ?>
                        <?php if(!$summary['res_outgoing']['wood'] && !$summary['res_outgoing']['stone'] && !$summary['res_outgoing']['iron']): ?>---<?php endif; ?>
                    </td>
                </tr>
            </table>
            <br>

            <?php if ($active_mode === 'send'): ?>
                <!-- MODE: SEND RESOURCES - Image 3 Style -->
                <h3><?= __('screens.market.send_resources') ?></h3>
                
                <?php if ($confirmation): ?>
                    <!-- Confirmation Table (Unified Style) -->
                    <form action="game.php?village=<?= $village['id'] ?>&screen=market&mode=send&action=send&h=<?= $user['hkey'] ?? '' ?>" method="post">
                        <input type="hidden" name="target_type" value="coords">
                        <input type="hidden" name="input" value="<?= $confirmation['target_village']['x'] ?>|<?= $confirmation['target_village']['y'] ?>">
                        <input type="hidden" name="wood" value="<?= $confirmation['resources']['wood'] ?>">
                        <input type="hidden" name="stone" value="<?= $confirmation['resources']['stone'] ?>">
                        <input type="hidden" name="iron" value="<?= $confirmation['resources']['iron'] ?>">
                        <input type="hidden" name="confirm" value="1">
                        
                        <table class="vis" width="500">
                            <tr><th colspan="2"  style="background-color: #c1a264; color: #fff;"><?= __('screens.market.confirm_resources') ?? 'Confirmar transporte de recursos' ?></th></tr>
                            <tr><td><?= __('screens.market.target') ?? 'Alvo' ?>:</td><td><b><?= htmlspecialchars($confirmation['target_username'] ?? '') ?></b> (<?= htmlspecialchars($confirmation['target_village']['name']) ?> <?= $confirmation['target_village']['x'] ?>|<?= $confirmation['target_village']['y'] ?>) K<?= $confirmation['target_village']['continent'] ?></td></tr>
                            <tr><td><?= __('screens.market.resources') ?>:</td>
                                <td>
                                    <?php if($confirmation['resources']['wood']) echo "<img src='graphic/icons/wood.png' title='".__('screens.market.wood')."'> ".number_format($confirmation['resources']['wood'])." "; ?>
                                    <?php if($confirmation['resources']['stone']) echo "<img src='graphic/icons/stone.png' title='".__('screens.market.clay')."'> ".number_format($confirmation['resources']['stone'])." "; ?>
                                    <?php if($confirmation['resources']['iron']) echo "<img src='graphic/icons/iron.png' title='".__('screens.market.iron')."'> ".number_format($confirmation['resources']['iron'])." "; ?>
                                </td>
                            </tr>
                            <tr><td><?= __('screens.market.merchants') ?? 'Comerciantes' ?>:</td><td><?= $confirmation['dealers'] ?></td></tr>
                            <tr><td><?= __('screens.market.duration') ?>:</td><td><?= format_time($confirmation['duration']) ?></td></tr>
                            <tr><td><?= __('screens.market.arrival') ?>:</td><td><?= format_date($confirmation['arrival']) ?></td></tr>
                        </table>
                        <br>
                        <input type="submit" class="btn" value="<?= __('screens.market.confirm') ?? 'Confirmar' ?>">
                    </form>
                <?php else: ?>
                    <form action="game.php?village=<?= $village['id'] ?>&screen=market&mode=send&action=send&h=<?= $user['hkey'] ?? '' ?>" method="post">
                        <table class="vis" width="100%">
                            <tr>
                                <td valign="top" width="200">
                                    <table class="vis" width="100%">
                                        <tr><th colspan="3"  style="background-color: #c1a264; color: #fff;"><?= __('screens.market.resources') ?></th></tr>
                                        <tr>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><img src="graphic/icons/wood.png"></td>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><input type="text" name="wood" size="5" id="wood_input" value="<?= $_POST['wood'] ?? '' ?>"></td>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><a href="#" onclick="document.getElementById('wood_input').value=<?= floor($village['r_wood']) ?>; return false;">(<?= floor($village['r_wood']) ?>)</a></td>
                                        </tr>
                                        <tr>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><img src="graphic/icons/stone.png"></td>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><input type="text" name="stone" size="5" id="stone_input" value="<?= $_POST['stone'] ?? '' ?>"></td>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><a href="#" onclick="document.getElementById('stone_input').value=<?= floor($village['r_stone']) ?>; return false;">(<?= floor($village['r_stone']) ?>)</a></td>
                                        </tr>
                                        <tr>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><img src="graphic/icons/iron.png"></td>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><input type="text" name="iron" size="5" id="iron_input" value="<?= $_POST['iron'] ?? '' ?>"></td>
                                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;"><a href="#" onclick="document.getElementById('iron_input').value=<?= floor($village['r_iron']) ?>; return false;">(<?= floor($village['r_iron']) ?>)</a></td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top"  style="padding-left: 15px;">
                                    <table class="vis" width="100%">
                                        <tr>
                                            <th colspan="2"  class="text-left bold" style="background-color: #c1a264; color: #fff; font-style: italic; padding: 3px;"><?= __('screens.market.destination') ?></th>
                                        </tr>
                                        <tr>
                                            <td  class="nowrap" style="background-color: #f4e4bc; border: 1px solid #7d510f; padding: 4px;">
                                                <input type="radio" name="target_type" value="coords" id="tt_coords" checked> <label for="tt_coords"><?= __('screens.market.coords') ?? 'Coordenadas' ?></label>
                                                <input type="radio" name="target_type" value="village_name" id="tt_vname"> <label for="tt_vname"><?= __('screens.market.village_name') ?? 'Nome da aldeia' ?></label>
                                                <input type="radio" name="target_type" value="player_name" id="tt_pname"> <label for="tt_pname"><?= __('screens.market.player_name') ?? 'Nome do jogador' ?></label>
                                            </td>
                                            <td rowspan="2" align="center" valign="middle"  class="p-10" style="background-color: #f4e4bc; border: 1px solid #7d510f;">
                                                <input type="submit" class="btn" value="<?= __('screens.market.send') ?>" style="font-size: 10pt; font-weight: bold; width: 80px; height: 28px;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="p-5" style="background-color: #f4e4bc; border: 1px solid #7d510f; box-sizing: border-box;">
                                                <input type="text" id="market_destination_input" name="input" autocomplete="off" value="<?= $_POST['input'] ?? '' ?>" style="width: 100%; box-sizing: border-box; padding: 4px;">
                                                <!-- Selected Village Card -->
                                                <div id="market_selected_village_card"  class="p-5" style="display:none; align-items:center; border:1px solid #7d510f; background:#fcf6e4; box-sizing:border-box; margin-top:2px;">
                                                    <img id="sel_village_img" src="graphic/map/v1.png"  style="width:38px; height:38px; margin-right:12px; object-fit:contain;" alt="">
                                                    <div  class="text-left" style="flex:1; font-size:11px; line-height:1.4; color:#000;">
                                                        <b id="sel_village_title"></b><br>
                                                        Proprietário: <span id="sel_village_owner"></span> Pontos: <span id="sel_village_points"></span><br>
                                                        Distância: <span id="sel_village_distance"></span> campos
                                                    </div>
                                                    <div  style="display:flex; align-items:center; margin-left:10px;">
                                                        <a href="#" id="clear_selected_village"  class="text-center bold pointer" style="display:inline-block; width:20px; height:20px; line-height:20px; border:1px solid #7d510f; background:#e3d5b3; color:#a00; text-decoration:none; font-size:13px;" title="Limpar">X</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <a href="#" onclick="showMarketVillagesModal(); return false;">&raquo; <?= __('screens.market.your_villages') ?? 'As suas aldeias' ?></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </form>
                    
                    <style>
                    #market_autocomplete_dropdown {
                        display: none;
                        position: absolute;
                        z-index: 99999;
                        border: 1px solid #7d510f;
                        background: #f4e4bc;
                        max-height: 300px;
                        overflow-y: auto;
                        box-shadow: 0px 4px 8px rgba(0,0,0,0.3);
                        transform: translateY(-100%);
                        margin-top: -2px;
                    }
                    .autocomplete-item {
                        display: flex;
                        align-items: center;
                        padding: 6px 10px;
                        border-bottom: 1px solid #7d510f;
                        cursor: pointer;
                        background: #f4e4bc;
                        color: #000;
                    }
                    .autocomplete-item:hover {
                        background-color: #e3d5b3;
                    }
                    .autocomplete-item img {
                        width: 38px;
                        height: 38px;
                        margin-right: 12px;
                        object-fit: contain;
                    }
                    .autocomplete-details {
                        flex: 1;
                        font-size: 11px;
                        line-height: 1.4;
                        text-align: left;
                    }
                    </style>

                    <script type="text/javascript">
                    $(document).ready(function() {
                        const input = $('#market_destination_input');
                        
                        // Append autocomplete dropdown container to body to avoid container clipping
                        if ($('#market_autocomplete_dropdown').length === 0) {
                            $('body').append('<div id="market_autocomplete_dropdown"></div>');
                        }
                        const dropdown = $('#market_autocomplete_dropdown');
                        let ajaxTimeout = null;

                        function repositionDropdown() {
                            if (dropdown.is(':visible')) {
                                let offset = input.offset();
                                dropdown.css({
                                    top: offset.top + 'px',
                                    left: offset.left + 'px',
                                    width: input.outerWidth() + 'px'
                                });
                            }
                        }

                        $(window).on('scroll resize', repositionDropdown);

                        function showSelectedVillageCard(item) {
                            if (!item) return;

                            let pts = parseInt(item.points) || 0;
                            let graphic = 'v1';
                            if (pts >= 11000) graphic = 'v6';
                            else if (pts >= 9000) graphic = 'v5';
                            else if (pts >= 3000) graphic = 'v4';
                            else if (pts >= 1000) graphic = 'v3';
                            else if (pts >= 300) graphic = 'v2';

                            $('#sel_village_img').attr('src', 'graphic/map/' + graphic + '.png');
                            $('#sel_village_title').text(item.name + ' (' + item.x + '|' + item.y + ')');
                            $('#sel_village_owner').text(item.owner || 'Aldeia bárbara');
                            $('#sel_village_points').text(pts.toLocaleString('pt-PT'));
                            $('#sel_village_distance').text(item.distance);

                            // Force target type to coordinates since we have exact coordinates now
                            $('#tt_coords').prop('checked', true);

                            input.hide();
                            $('#market_selected_village_card').css('display', 'flex');
                            dropdown.hide().empty();
                        }

                        let lastValue = '';
                        let currentAjax = null;

                        function checkCoordinates(val) {
                            let match = val.match(/^(\d{1,3})\|(\d{1,3})$/);
                            if (match) {
                                let x = match[1];
                                let y = match[2];

                                if (currentAjax) currentAjax.abort();

                                currentAjax = $.ajax({
                                    url: 'game.php',
                                    type: 'GET',
                                    data: {
                                        screen: 'api',
                                        type: 'village_by_coords',
                                        x: x,
                                        y: y
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data) {
                                            showSelectedVillageCard(data);
                                        } else {
                                            $('#market_selected_village_card').hide();
                                            input.show();
                                        }
                                    }
                                });
                            } else {
                                $('#market_selected_village_card').hide();
                                input.show();
                            }
                        }

                        // Run interval to detect coordinate changes (e.g. load, autocomplete, manual entry, map click)
                        setInterval(function() {
                            let val = input.val().trim();
                            if (val !== lastValue) {
                                lastValue = val;
                                checkCoordinates(val);
                            }
                        }, 200);

                        input.on('input focus', function() {
                            let q = $(this).val().trim();
                            let targetType = $('input[name="target_type"]:checked').val();

                            if (q.length < 2 || targetType === 'coords') {
                                dropdown.hide().empty();
                                return;
                            }

                            clearTimeout(ajaxTimeout);
                            ajaxTimeout = setTimeout(function() {
                                let apiType = targetType === 'village_name' ? 'autocomplete_village' : 'autocomplete_player';
                                $.ajax({
                                    url: 'game.php',
                                    type: 'GET',
                                    data: {
                                        screen: 'api',
                                        type: apiType,
                                        q: q
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        dropdown.empty();
                                        if (!data || data.length === 0) {
                                            // Reposition before showing
                                            let offset = input.offset();
                                            dropdown.css({
                                                top: offset.top + 'px',
                                                left: offset.left + 'px',
                                                width: input.outerWidth() + 'px'
                                            }).html('<div  class="p-10 text-center" style="font-style:italic; font-size:11px; color:#555; background:#f4e4bc;">Nenhuma aldeia encontrada</div>').show();
                                            return;
                                        }

                                        data.forEach(function(item, idx) {
                                            let pts = parseInt(item.points) || 0;
                                            let graphic = 'v1';
                                            if (pts >= 11000) graphic = 'v6';
                                            else if (pts >= 9000) graphic = 'v5';
                                            else if (pts >= 3000) graphic = 'v4';
                                            else if (pts >= 1000) graphic = 'v3';
                                            else if (pts >= 300) graphic = 'v2';

                                            let displayStyle = idx >= 10 ? 'style="display:none;" class="autocomplete-item hidden-item"' : 'class="autocomplete-item"';

                                            let row = $(`
                                                <div ${displayStyle} data-x="${item.x}" data-y="${item.y}">
                                                    <img src="graphic/map/${graphic}.png" alt="">
                                                    <div class="autocomplete-details">
                                                        <b>${item.name} (${item.x}|${item.y})</b><br>
                                                        Proprietário: ${item.owner} Pontos: ${pts.toLocaleString('pt-PT')}<br>
                                                        Distância: ${item.distance} campos
                                                    </div>
                                                </div>
                                            `);
                                            row.data('item', item);
                                            dropdown.append(row);
                                        });

                                        if (data.length > 10) {
                                            dropdown.append(`
                                                <div id="show_more_autocomplete"  class="text-center bold pointer" style="padding:8px; background:#e3d5b3; border-top:1px solid #7d510f; color:#000; font-size:11px;">
                                                    Mostrar mais
                                                </div>
                                            `);
                                        }

                                        // Position and show
                                        let offset = input.offset();
                                        dropdown.css({
                                            top: offset.top + 'px',
                                            left: offset.left + 'px',
                                            width: input.outerWidth() + 'px'
                                        }).show();
                                    }
                                });
                            }, 150);
                        });

                        // Handle selection click from dropdown
                        dropdown.on('click', '.autocomplete-item', function() {
                            let x = $(this).data('x');
                            let y = $(this).data('y');
                            let item = $(this).data('item');

                            input.val(x + '|' + y);
                            lastValue = x + '|' + y;

                            $('#tt_coords').prop('checked', true);
                            dropdown.hide().empty();
                            
                            showSelectedVillageCard(item);
                        });

                        // Handle clearing the selected village
                        $('#clear_selected_village').on('click', function(e) {
                            e.preventDefault();
                            input.val('');
                            lastValue = '';
                            $('#market_selected_village_card').hide();
                            input.show().focus();
                        });

                        // Handle "Mostrar mais" click
                        dropdown.on('click', '#show_more_autocomplete', function() {
                            $(this).remove();
                            dropdown.find('.hidden-item').removeClass('hidden-item').show();
                            repositionDropdown(); // Adjust height calculations if container grows
                        });

                        // Hide on click outside
                        $(document).on('click', function(e) {
                            if (!$(e.target).closest('#market_destination_input, #market_autocomplete_dropdown').length) {
                                dropdown.hide();
                            }
                        });

                        // Handle target type change
                        $('input[name="target_type"]').on('change', function() {
                            dropdown.hide().empty();
                            if ($(this).val() !== 'coords') {
                                input.trigger('input');
                            }
                        });
                    });
                    </script>
                <?php endif; ?>

            <?php elseif ($active_mode === 'transports'): ?>
                <!-- MODE: TRANSPORTS - Image 4 Style -->
                <h3><?= __('screens.market.your_transports') ?></h3>
                <?php if (!empty($outgoing_dealers)): ?>
                    <table class="vis" width="100%">
                        <tr>
                            <th width="200"  style="background-color: #c1a264;"><?= __('screens.market.destination') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.merchandise') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.dealers') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.arrival') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.arrives_in') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.action') ?></th>
                        </tr>
                        <?php foreach ($outgoing_dealers as $d): ?>
                            <tr>
                                <td>
                                    <?= $d['type'] === 'back' ? (__('screens.market.back')) : (__('screens.market.to')) ?>
                                    <br>
                                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $d['to_village'] ?>">
                                        <b><?= htmlspecialchars($d['vname']) ?></b> (<?= $d['x'] ?>|<?= $d['y'] ?>) K<?= $d['continent'] ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if ($d['wood']) echo "<img src='graphic/icons/wood.png'> " . number_format($d['wood']) . " "; ?>
                                    <?php if ($d['stone']) echo "<img src='graphic/icons/stone.png'> " . number_format($d['stone']) . " "; ?>
                                    <?php if ($d['iron']) echo "<img src='graphic/icons/iron.png'> " . number_format($d['iron']) . " "; ?>
                                </td>
                                <td><?= $d['dealers'] ?></td>
                                <td><?= format_date($d['end_time']) ?></td>
                                <td><span class="timer"><?= format_time(max(0, $d['end_time'] - time())) ?></span></td>
                                <td>
                                    <?php if ($d['type'] === 'to' && (time() - $d['start_time'] <= 300)): ?>
                                        <a href="game.php?village=<?= $village['id'] ?>&screen=market&mode=transports&action=cancel_send&id=<?= $d['id'] ?>&h=<?= $user['hkey'] ?? '' ?>">
                                            <?= __('screens.market.cancel') ?>
                                        </a>
                                    <?php else: ?>
                                        ---
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p><?= __('screens.market.no_outgoing_transports') ?></p>
                <?php endif; ?>

                <br>
                <h3><?= __('screens.market.incoming_transports') ?></h3>
                <?php if (!empty($incoming_dealers)): ?>
                    <table class="vis" width="100%">
                        <tr>
                            <th width="200"  style="background-color: #c1a264;"><?= __('screens.market.origin') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.merchandise') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.arrival') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.arrives_in') ?></th>
                        </tr>
                        <?php foreach ($incoming_dealers as $d): ?>
                            <tr>
                                <td>
                                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_village&id=<?= $d['from_village'] ?>">
                                        <b><?= htmlspecialchars($d['vname']) ?></b> (<?= $d['x'] ?>|<?= $d['y'] ?>) K<?= $d['continent'] ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if ($d['wood']) echo "<img src='graphic/icons/wood.png'> " . number_format($d['wood']) . " "; ?>
                                    <?php if ($d['stone']) echo "<img src='graphic/icons/stone.png'> " . number_format($d['stone']) . " "; ?>
                                    <?php if ($d['iron']) echo "<img src='graphic/icons/iron.png'> " . number_format($d['iron']) . " "; ?>
                                </td>
                                <td><?= format_date($d['end_time']) ?></td>
                                <td><span class="timer"><?= format_time(max(0, $d['end_time'] - time())) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p><?= __('screens.market.no_incoming_transports') ?></p>
                <?php endif; ?>

            <?php elseif ($active_mode === 'merchant_status'): ?>
                <!-- MODE: MERCHANT STATUS - Image 5 Style -->
                <h3><?= __('screens.market.merchant_status_title') ?></h3>
                <p><?= __('screens.market.merchant_status_desc') ?></p>
                
                <table class="vis" width="400">
                    <tr><th colspan="2"  style="background-color: #c1a264;"><?= __('screens.market.merchant_occupation') ?></th></tr>
                    <tr>
                        <td><?= __('screens.market.merchants_to_target') ?></td>
                        <td align="center"><?= $summary['counts']['to'] ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.market.merchants_returning') ?></td>
                        <td align="center"><?= $summary['counts']['back'] ?></td>
                    </tr>
                    <tr>
                        <td><?= __('screens.market.your_offers_in_market') ?></td>
                        <td align="center"><?= $summary['counts']['offers'] ?></td>
                    </tr>
                    <tr>
                        <td><b><?= __('screens.market.merchants_busy') ?></b></td>
                        <td align="center"><b><?= $summary['counts']['total_in_use'] ?></b></td>
                    </tr>
                </table>

            <?php elseif ($active_mode === 'all_offers'): ?>
                <!-- MODE: ALL OFFERS OVERVIEW -->
                <h3><?= __('screens.market.all_my_offers') ?></h3>
                <?php if (!empty($own_offers)): ?>
                    <table class="vis" width="100%">
                        <tr>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.village') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.recebo') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.procuro') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.disponibilidade') ?></th>
                            <th  style="background-color: #c1a264;"><?= __('screens.market.action') ?></th>
                        </tr>
                        <?php foreach ($own_offers as $offer): 
                             $sell_res = ($offer['sell_wood'] > 0) ? 'wood' : (($offer['sell_stone'] > 0) ? 'stone' : 'iron');
                             $sell_amt = $offer['sell_' . $sell_res];
                             $buy_res = ($offer['buy_wood'] > 0) ? 'wood' : (($offer['buy_stone'] > 0) ? 'stone' : 'iron');
                             $buy_amt = $offer['buy_' . $buy_res];
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($offer['village_name']) ?> (<?= $offer['x'] ?>|<?= $offer['y'] ?>)</td>
                                <td><img src="graphic/<?= $sell_res == 'stone' ? 'lehm' : ($sell_res == 'wood' ? 'holz' : 'eisen') ?>.png"> <?= $sell_amt ?></td>
                                <td><img src="graphic/<?= $buy_res == 'stone' ? 'lehm' : ($buy_res == 'wood' ? 'holz' : 'eisen') ?>.png"> <?= $buy_amt ?></td>
                                <td><?= $offer['multi'] ?></td>
                                <td><a href="game.php?village=<?= $village['id'] ?>&screen=market&mode=all_offers&action=delete_offer&id=<?= $offer['id'] ?>&h=<?= $user['hkey'] ?>"><?= __('screens.market.delete') ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p><?= __('screens.market.no_own_offers') ?></p>
                <?php endif; ?>

            <?php elseif ($active_mode === 'own_offer'): ?>
                <!-- MODE: CREATE OFFER - Image 2 Style -->
                <h3><?= __('screens.market.create_offer_title') ?></h3>
                
                <p><?= __('screens.market.ratio_warning') ?></p>

                <form action="game.php?village=<?= $village['id'] ?>&screen=market&mode=own_offer&action=create_offer&h=<?= $user['hkey'] ?? '' ?>" method="post">
                    <table class="vis">
                        <tr>
                            <td width="200"  style="background-color: #f4e4bc; border: 1px solid #7d510f;"><b><?= __('screens.market.i_offer_short') ?>:</b></td>
                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f;">
                                <input name="sell" type="text" size="5" />
                                <input id="res_sell_wood" name="res_sell" type="radio" value="wood" checked /> <label for="res_sell_wood"><img src="graphic/icons/wood.png"></label>
                                <input id="res_sell_stone" name="res_sell" type="radio" value="stone" /> <label for="res_sell_stone"><img src="graphic/icons/stone.png"></label>
                                <input id="res_sell_iron" name="res_sell" type="radio" value="iron" /> <label for="res_sell_iron"><img src="graphic/icons/iron.png"></label>
                            </td>
                        </tr>
                        <tr>
                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f;"><b><?= __('screens.market.i_want_short') ?>:</b></td>
                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f;">
                                <input name="buy" type="text" size="5" />
                                <input id="res_buy_wood" name="res_buy" type="radio" value="wood" /> <label for="res_buy_wood"><img src="graphic/icons/wood.png"></label>
                                <input id="res_buy_stone" name="res_buy" type="radio" value="stone" checked /> <label for="res_buy_stone"><img src="graphic/icons/stone.png"></label>
                                <input id="res_buy_iron" name="res_buy" type="radio" value="iron" /> <label for="res_buy_iron"><img src="graphic/icons/iron.png"></label>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="vis">
                        <tr>
                            <th colspan="2"  class="text-left"><?= __('screens.market.limitations') ?></th>
                        </tr>
                        <tr>
                            <td><?= __('screens.market.how_many_offers') ?>:</td>
                            <td><input name="multi" type="text" size="5" value="1" /> <?= __('screens.market.offers') ?></td>
                        </tr>
                        <tr>
                            <td><?= __('screens.market.max_travel_time') ?>:</td>
                            <td><input name="max_time" type="text" size="5" value="5" /> <?= __('screens.market.hours') ?></td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" class="btn btn-send" value="<?= __('screens.market.create_btn') ?>" />
                </form>

                <?php if (!empty($own_offers)): ?>
                    <br>
                    <h3>
                        <?= __('screens.market.your_offers') ?>
                    </h3>
                    <table class="vis" width="100%">
                        <tr>
                            <th>
                                <?= __('screens.market.i_receive') ?>
                            </th>
                            <th>
                                <?= __('screens.market.i_search') ?>
                            </th>
                            <th>
                                <?= __('screens.market.quantity') ?>
                            </th>
                            <th>
                                <?= __('screens.market.action') ?>
                            </th>
                        </tr>
                        <?php foreach ($own_offers as $offer):
                            // Determine sell type/amount for display (Legacy DB schema vs New schema logic handled here)
                            $sell_res = ($offer['sell_wood'] > 0) ? 'wood' : (($offer['sell_stone'] > 0) ? 'stone' : 'iron');
                            $sell_amt = $offer['sell_' . $sell_res];
                            $buy_res = ($offer['buy_wood'] > 0) ? 'wood' : (($offer['buy_stone'] > 0) ? 'stone' : 'iron');
                            $buy_amt = $offer['buy_' . $buy_res];
                            ?>
                            <tr>
                                <td><img
                                        src="graphic/<?= $sell_res == 'stone' ? 'lehm' : ($sell_res == 'wood' ? 'holz' : 'eisen') ?>.png">
                                    <?= $sell_amt ?>
                                </td>
                                <td><img
                                        src="graphic/<?= $buy_res == 'stone' ? 'lehm' : ($buy_res == 'wood' ? 'holz' : 'eisen') ?>.png">
                                    <?= $buy_amt ?>
                                </td>
                                <td>
                                    <?= $offer['multi'] ?>x
                                </td>
                                <td><a class="btn btn-cancel" href="game.php?village=<?= $village['id'] ?>&screen=market&mode=own_offer&action=cancel_offer&id=<?= $offer['id'] ?>&h=<?= $user['hkey'] ?? '' ?>">
                                        <?= __('screens.market.cancel') ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>

            <?php elseif ($active_mode === 'other_offer'): ?>
                <!-- MODE: OTHER OFFERS - Image 1 Style -->
                <h3><?= __('screens.market.search_offers') ?></h3>

                <!-- Filter Form (Horizontal) -->
                <form action="game.php" method="get">
                    <input type="hidden" name="village" value="<?= $village['id'] ?>" />
                    <input type="hidden" name="screen" value="market" />
                    <input type="hidden" name="mode" value="other_offer" />
                    
                    <table class="vis" width="100%">
                        <tr>
                            <td width="150"  style="background-color: #f4e4bc; border: 1px solid #7d510f;"><b><?= __('screens.market.i_want') ?>:</b></td>
                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f;">
                                <input type="radio" name="filter_sell" value="all" id="qs_all" <?= ($filters['sell'] ?? '') === 'all' ? 'checked' : '' ?>> <label for="qs_all"><?= __('screens.market.all') ?></label>
                                <input type="radio" name="filter_sell" value="wood" id="qs_wood" <?= ($filters['sell'] ?? '') === 'wood' ? 'checked' : '' ?>> <label for="qs_wood"><img src="graphic/icons/wood.png"></label>
                                <input type="radio" name="filter_sell" value="stone" id="qs_stone" <?= ($filters['sell'] ?? '') === 'stone' ? 'checked' : '' ?>> <label for="qs_stone"><img src="graphic/icons/stone.png"></label>
                                <input type="radio" name="filter_sell" value="iron" id="qs_iron" <?= ($filters['sell'] ?? '') === 'iron' ? 'checked' : '' ?>> <label for="qs_iron"><img src="graphic/icons/iron.png"></label>
                            </td>
                            <td rowspan="2" align="center" width="50">
                                <img src="graphic/new/swap.webp"  class="pointer" title="Alternar" onclick="SwapMarketFilters()">
                            </td>
                        </tr>
                        <tr>
                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f;"><b><?= __('screens.market.i_offer') ?>:</b></td>
                            <td  style="background-color: #f4e4bc; border: 1px solid #7d510f;">
                                <input type="radio" name="filter_buy" value="all" id="of_all" <?= ($filters['buy'] ?? '') === 'all' ? 'checked' : '' ?>> <label for="of_all"><?= __('screens.market.all') ?></label>
                                <input type="radio" name="filter_buy" value="wood" id="of_wood" <?= ($filters['buy'] ?? '') === 'wood' ? 'checked' : '' ?>> <label for="of_wood"><img src="graphic/icons/wood.png"></label>
                                <input type="radio" name="filter_buy" value="stone" id="of_stone" <?= ($filters['buy'] ?? '') === 'stone' ? 'checked' : '' ?>> <label for="of_stone"><img src="graphic/icons/stone.png"></label>
                                <input type="radio" name="filter_buy" value="iron" id="of_iron" <?= ($filters['buy'] ?? '') === 'iron' ? 'checked' : '' ?>> <label for="of_iron"><img src="graphic/icons/iron.png"></label>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="vis">
                        <tr>
                            <th colspan="4"  class="text-left"><?= __('screens.market.limitations') ?></th>
                        </tr>
                        <tr>
                            <td><?= __('screens.market.duration') ?>:</td>
                            <td>
                                <select name="limit_duration">
                                    <option value="2"><?= sprintf(__('screens.market.x_hours'), 2) ?></option>
                                    <option value="5" <?= ($filters['limit_duration'] == 5) ? 'selected' : '' ?>><?= sprintf(__('screens.market.x_hours'), 5) ?></option>
                                    <option value="10" <?= ($filters['limit_duration'] == 10) ? 'selected' : '' ?>><?= sprintf(__('screens.market.x_hours'), 10) ?></option>
                                    <option value="24" <?= ($filters['limit_duration'] == 24) ? 'selected' : '' ?>><?= sprintf(__('screens.market.x_hours'), 24) ?></option>
                                    <option value="0" <?= ($filters['limit_duration'] == 0) ? 'selected' : '' ?>><?= __('screens.market.all') ?></option>
                                </select>
                            </td>
                            <td><?= __('screens.market.filter') ?>:</td>
                            <td>
                                <select name="ratio">
                                    <option value="0"><?= __('screens.market.show_all') ?></option>
                                    <option value="1.0" <?= ($filters['ratio'] == 1.0) ? 'selected' : '' ?>><?= __('screens.market.max_ratio_1') ?></option>
                                    <option value="1.5" <?= ($filters['ratio'] == 1.5) ? 'selected' : '' ?>><?= __('screens.market.max_ratio_15') ?></option>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox" name="only_friends" id="fl_friends" <?= ($filters['only_friends'] ?? false) ? 'checked' : '' ?>> <label for="fl_friends"><?= __('screens.market.only_friends') ?></label><br>
                                <input type="checkbox" name="exclude_enemies" id="fl_enemies" <?= ($filters['exclude_enemies'] ?? false) ? 'checked' : '' ?>> <label for="fl_enemies"><?= __('screens.market.exclude_enemies') ?></label>
                            </td>
                            <td><input type="submit" value="<?= __('screens.market.search') ?>" class="btn"></td>
                        </tr>
                    </table>
                </form>

                <script>
                function SwapMarketFilters() {
                    const sellVal = $('input[name="filter_sell"]:checked').val();
                    const buyVal = $('input[name="filter_buy"]:checked').val();
                    
                    if (sellVal !== 'all' && buyVal !== 'all') {
                        $(`input[name="filter_sell"][value="${buyVal}"]`).prop('checked', true);
                        $(`input[name="filter_buy"][value="${sellVal}"]`).prop('checked', true);
                    }
                }
                </script>

                <br>

                <?php if (!empty($other_offers)): ?>
                    <table class="vis" width="100%">
                        <tr>
                            <th><?= __('screens.market.recebo') ?></th>
                            <th><?= __('screens.market.procuro') ?></th>
                            <th><?= __('screens.market.jogador') ?></th>
                            <th><?= __('screens.market.duracao') ?></th>
                            <th><?= __('screens.market.racio') ?></th>
                            <th><?= __('screens.market.disponibilidade') ?></th>
                            <th><?= __('screens.market.aceitar_btn') ?></th>
                        </tr>
                        <?php foreach ($other_offers as $offer):
                            $sell_res = ($offer['sell_wood'] > 0) ? 'wood' : (($offer['sell_stone'] > 0) ? 'stone' : 'iron');
                            $sell_amt = $offer['sell_' . $sell_res];
                            $buy_res = ($offer['buy_wood'] > 0) ? 'wood' : (($offer['buy_stone'] > 0) ? 'stone' : 'iron');
                            $buy_amt = $offer['buy_' . $buy_res];
                            $ratio = round($buy_amt / $sell_amt, 2);
                            $ratio_img = ($ratio <= 1.0) ? 'ratio_green' : (($ratio <= 1.5) ? 'ratio_yellow' : 'ratio_red');
                            ?>
                            <tr>
                                <td><img src="graphic/<?= $buy_res == 'stone' ? 'lehm' : ($buy_res == 'wood' ? 'holz' : 'eisen') ?>.png"> <?= number_format($buy_amt, 0, ',', '.') ?></td>
                                <td><img src="graphic/<?= $sell_res == 'stone' ? 'lehm' : ($sell_res == 'wood' ? 'holz' : 'eisen') ?>.png"> <?= number_format($sell_amt, 0, ',', '.') ?></td>
                                <td>
                                    <a href="game.php?village=<?= $village['id'] ?>&screen=info_player&id=<?= $offer['seller_userid'] ?>">
                                        <?= htmlspecialchars($offer['username'] ?? __('screens.market.unknown')) ?>
                                    </a>
                                </td>
                                <td><?= format_time($offer['duration']) ?></td>
                                <td align="center">
                                    <img src="graphic/<?= $ratio_img ?>.png" title="Rácio: <?= $ratio ?>"> <?= $ratio ?>
                                </td>
                                <td><?= $offer['multi'] ?> <?= __('screens.market.offers') ?></td>
                                <td>
                                    <form action="game.php?village=<?= $village['id'] ?>&screen=market&mode=other_offer&action=accept_offer&id=<?= $offer['id'] ?>&h=<?= $user['hkey'] ?? '' ?>" method="post">
                                        <input type="text" name="amount" size="3" value="1">
                                        (<?= $offer['multi'] ?>)
                                        <input type="submit" value="<?= __('screens.market.accept') ?>" class="btn">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p><?= __('screens.market.no_offers') ?></p>
                <?php endif; ?>

            <?php elseif ($active_mode === 'premium'): ?>
                <!-- MODE: PREMIUM EXCHANGE - Based on Screenshot -->
                <h3><?= __('screens.market.premium_exchange') ?></h3>
                <p>
                    <?= __('screens.market.premium_exchange_desc') ?? 'Utilize a Troca Premium para trocar pontos premium por recursos e vice-versa.' ?> <a href="javascript:void(0)" onclick="ShowPremiumExchangeInfo()"><?= __('screens.common.learn_more') ?? 'Descobre mais' ?></a> <i>i</i>.
                </p>

                <?php if (isset($_GET['msg'])): ?>
                    <div  class="bold text-green mb-10 p-5" style="border: 1px solid green; background: #e0ffe0;">
                        <?php if ($_GET['msg'] === 'success_buy') echo 'Compra realizada com sucesso!'; ?>
                        <?php if ($_GET['msg'] === 'success_sell') echo 'Venda realizada com sucesso!'; ?>
                    </div>
                <?php endif; ?>

                <table class="vis premium-exchange" width="100%">
                    <tr>
                        <th width="150"  style="background: none;"></th>
                        <th><img src="graphic/icons/wood.png"> <?= __('screens.market.wood') ?></th>
                        <th><img src="graphic/icons/stone.png"> <?= __('screens.market.clay') ?></th>
                        <th><img src="graphic/icons/iron.png"> <?= __('screens.market.iron') ?></th>
                    </tr>
                    <tr>
                        <td class="premium-label"><b><?= __('screens.market.stock') ?></b></td>
                        <td align="center"  class="text-red bold"><?= number_format($stock['wood']) ?></td>
                        <td align="center"  class="text-red bold"><?= number_format($stock['stone']) ?></td>
                        <td align="center"  class="text-red bold"><?= number_format($stock['iron']) ?></td>
                    </tr>
                    <tr>
                        <td class="premium-label"><b><?= __('screens.market.capacity') ?></b></td>
                        <td align="center"><?= number_format($stock['wood_capacity']) ?></td>
                        <td align="center"><?= number_format($stock['stone_capacity']) ?></td>
                        <td align="center"><?= number_format($stock['iron_capacity']) ?></td>
                    </tr>
                    <tr>
                        <td class="premium-label"><b><?= __('screens.market.rate') ?></b></td>
                        <td align="center"><img src="graphic/icons/wood.png"> <?= $rates['wood'] ?> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> 1</td>
                        <td align="center"><img src="graphic/icons/stone.png"> <?= $rates['stone'] ?> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> 1</td>
                        <td align="center"><img src="graphic/icons/iron.png"> <?= $rates['iron'] ?> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> 1</td>
                    </tr>
                     <tr>
                        <td class="premium-label"><b><?= __('screens.market.premium_buy') ?></b></td>
                        <td align="center">
                            <input type="text" id="buy_wood" class="pe-input" data-res="wood" data-type="buy" size="5" placeholder="0"> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> <span id="calc_pp_wood">0</span>
                        </td>
                        <td align="center">
                            <input type="text" id="buy_stone" class="pe-input" data-res="stone" data-type="buy" size="5" placeholder="0"> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> <span id="calc_pp_stone">0</span>
                        </td>
                        <td align="center">
                            <input type="text" id="buy_iron" class="pe-input" data-res="iron" data-type="buy" size="5" placeholder="0"> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> <span id="calc_pp_iron">0</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="premium-label"><b><?= __('screens.market.premium_sell') ?></b></td>
                        <td align="center">
                            <input type="text" id="sell_wood" class="pe-input" data-res="wood" data-type="sell" size="5" placeholder="0"> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> <span id="calc_earn_wood">0</span>
                        </td>
                        <td align="center">
                            <input type="text" id="sell_stone" class="pe-input" data-res="stone" data-type="sell" size="5" placeholder="0"> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> <span id="calc_earn_stone">0</span>
                        </td>
                        <td align="center">
                            <input type="text" id="sell_iron" class="pe-input" data-res="iron" data-type="sell" size="5" placeholder="0"> &harr; <img src="graphic/new/premium/coinbag_15x15.png"> <span id="calc_earn_iron">0</span>
                        </td>
                    </tr>
                </table>
                <div align="right"  class="mt-5">
                    <input type="button" value="<?= __('screens.market.calculate_best_offer') ?? 'Calcular melhor oferta' ?>" class="btn" onclick="CalculateBestOffer()">
                </div>

                <br>
                <div class="vis"  style="padding: 0;">
                    <div  class="p-5" style="background: #e3c485; border-bottom: 1px solid #7d510f;">
                        <b><?= __('screens.market.average_price') ?? 'Média de preço' ?> de <img src="graphic/new/premium/coinbag_15x15.png"> (<?= __('screens.market.last_7_days') ?? 'últimos 7 dias' ?>)</b>
                    </div>
                    <div  class="p-10" style="height: 180px; background: #f4e4bc; position: relative;">
                        <!-- Chart Legend -->
                        <div  style="position: absolute; right: 20px; top: 10px; font-size: 10px;">
                            <span  style="display:inline-block; width:10px; height:10px; background:#7d510f;"></span> <?= __('screens.market.rate') ?>
                        </div>
                        
                        <!-- Chart Area -->
                        <div  style="position: absolute; left: 40px; top: 20px; border-left: 2px solid #7d510f; border-bottom: 2px solid #7d510f; width: calc(100% - 60px); height: 120px;">
                            <!-- Grid Lines -->
                            <div  class="w-100" style="position: absolute; bottom: 50%; border-top: 1px dashed #dcb67d;"></div>
                            
                            <!-- Resource Curves (Conceptual) -->
                            <svg width="100%" height="100%" preserveAspectRatio="none"  style="position:absolute; bottom:0;">
                                <!-- Price Curve -->
                                <path d="M0,120 Q50,60 100,20" stroke="#7d510f" stroke-width="2" fill="none" vector-effect="non-scaling-stroke" />
                                
                                <!-- Current Stock Points -->
                                <?php 
                                    $wood_x = ($stock['wood'] / $stock['wood_capacity']) * 100;
                                    $wood_y = 120 - (($rates['wood'] / 112) * 120);
                                    $stone_x = ($stock['stone'] / $stock['stone_capacity']) * 100;
                                    $stone_y = 120 - (($rates['stone'] / 112) * 120);
                                    $iron_x = ($stock['iron'] / $stock['iron_capacity']) * 100;
                                    $iron_y = 120 - (($rates['iron'] / 112) * 120);
                                ?>
                                <circle cx="<?= $wood_x ?>%" cy="<?= $wood_y ?>" r="5" fill="#8d5932" stroke="#fff" stroke-width="1" />
                                <circle cx="<?= $stone_x ?>%" cy="<?= $stone_y ?>" r="5" fill="#cc5500" stroke="#fff" stroke-width="1" />
                                <circle cx="<?= $iron_x ?>%" cy="<?= $iron_y ?>" r="5" fill="#333333" stroke="#fff" stroke-width="1" />
                            </svg>
                            
                            <!-- Y-Axis Labels -->
                            <div  style="position: absolute; left: -35px; top: 0; font-size: 9px;">112</div>
                            <div  style="position: absolute; left: -35px; bottom: 0; font-size: 9px;">56</div>
                        </div>
                        
                        <!-- X-Axis Labels -->
                        <div  style="position: absolute; left: 40px; bottom: 15px; width: calc(100% - 60px); display: flex; justify-content: space-between; font-size: 9px;">
                            <span>0% Stock</span>
                            <span>50%</span>
                            <span>100% Stock</span>
                        </div>
                    </div>
                    <div  class="p-5 text-center" style="background: #f4e4bc; font-size: 0.8em; border-top: 1px solid #7d510f;">
                        <span  style="color: #8d5932;">■ <?= __('screens.market.wood') ?></span> &nbsp; <span  style="color: #cc5500;">■ <?= __('screens.market.clay') ?></span> &nbsp; <span  style="color: #333333;">■ <?= __('screens.market.iron') ?></span>
                    </div>
                </div>

                <script>
                const rates = <?= json_encode($rates) ?>;

                $('.pe-input').on('input', function() {
                    const val = parseInt($(this).val()) || 0;
                    const res = $(this).data('res');
                    const type = $(this).data('type');
                    const rate = rates[res === 'stone' ? 'stone' : (res === 'wood' ? 'wood' : 'iron')];
                    
                    if (type === 'buy') {
                        $(`#calc_pp_${res}`).text(Math.ceil(val / rate));
                    } else {
                        $(`#calc_earn_${res}`).text(Math.floor(val / rate));
                    }
                });

                function CalculateBestOffer() {
                    const buys = { 
                        wood: parseInt($('#buy_wood').val()) || 0,
                        stone: parseInt($('#buy_stone').val()) || 0,
                        iron: parseInt($('#buy_iron').val()) || 0
                    };
                    const sells = {
                        wood: parseInt($('#sell_wood').val()) || 0,
                        stone: parseInt($('#sell_stone').val()) || 0,
                        iron: parseInt($('#sell_iron').val()) || 0
                    };

                    let totalPP = 0;
                    let totalEarn = 0;
                    let items = [];

                    for (let res in buys) {
                        if (buys[res] > 0) {
                            let cost = Math.ceil(buys[res] / rates[res]);
                            totalPP += cost;
                            items.push({ 
                                type: 'buy', 
                                res: res, 
                                amount: buys[res], 
                                best: cost * rates[res],
                                pp: cost 
                            });
                        }
                    }
                    for (let res in sells) {
                        if (sells[res] > 0) {
                            let earn = Math.floor(sells[res] / rates[res]);
                            totalEarn += earn;
                            items.push({ 
                                type: 'sell', 
                                res: res, 
                                amount: sells[res], 
                                best: earn * rates[res],
                                pp: earn 
                            });
                        }
                    }

                    if (items.length === 0) return;

                    ShowReviewExchangeOffer(items, totalPP - totalEarn);
                }

                function ShowReviewExchangeOffer(items, finalPP) {
                    const trans = {
                        title: "<?= __('screens.market.review_exchange_offer') ?>",
                        your_order: "<?= __('screens.market.your_order') ?>",
                        best_match: "<?= __('screens.market.best_match') ?>",
                        cost: "<?= __('screens.market.exchange_cost') ?>",
                        confirm: "<?= __('screens.common.confirm') ?? 'Confirmar' ?>",
                        cancel: "<?= __('screens.common.cancel') ?? 'Cancelar' ?>",
                        buy: "<?= __('screens.market.buy_res') ?>",
                        sell: "<?= __('screens.market.sell_res') ?>"
                    };

                    const resIcons = {
                        wood: 'graphic/icons/wood.png',
                        stone: 'graphic/icons/stone.png',
                        iron: 'graphic/icons/iron.png'
                    };

                    let itemsHtml = '';
                    items.forEach(item => {
                        let icon = `<img src="${resIcons[item.res]}">`;
                        let label = item.type === 'buy' ? trans.buy.replace('{res}', icon) : trans.sell.replace('{res}', icon);
                        
                        itemsHtml += `
                            <tr>
                                <td  class="p-10" style="border-bottom: 1px solid #7d510f;">${label} ${item.amount} por <img src="graphic/new/premium/coinbag_15x15.png"> ${item.pp}</td>
                                <td  class="p-10" style="border-bottom: 1px solid #7d510f; background: #e5d5ad;">${label} ${item.best} por <img src="graphic/new/premium/coinbag_15x15.png"> ${item.pp}</td>
                            </tr>
                        `;
                    });

                    let modalHtml = `
                        <div id="review-modal"  class="w-100" style="position:fixed; top:0; left:0; height:100%; background:rgba(0,0,0,0.7); z-index:11000; display:flex; align-items:center; justify-content:center;">
                            <div  style="background:#f4e4bc; border:2px solid #7d510f; width:500px; padding:20px; box-shadow: 0 0 20px rgba(0,0,0,0.5); border-radius:5px;">
                                <h2  style="color:#7d510f; margin-top:0;">${trans.title}</h2>
                                
                                <table width="100%"  style="border-collapse: collapse;">
                                    <tr>
                                        <th align="left"  class="p-5" style="background:#c1a264;">${trans.your_order}</th>
                                        <th align="left"  class="p-5" style="background:#c1a264;">${trans.best_match}</th>
                                    </tr>
                                    ${itemsHtml}
                                </table>
                                
                                <p  class="mt-20 bold">${trans.cost} <img src="graphic/new/premium/coinbag_15x15.png"> ${Math.abs(finalPP)}</p>
                                
                                <div  class="text-center" style="margin-top:30px;">
                                    <button class="btn btn-confirm-yes bold" id="confirm-exchange"  style="padding:8px 25px;">${trans.confirm}</button>
                                    <button class="btn btn-confirm-no bold" onclick="$('#review-modal').remove()"  style="padding:8px 25px; margin-left:10px;">${trans.cancel}</button>
                                </div>
                            </div>
                        </div>
                    `;

                    $('body').append(modalHtml);

                    $('#confirm-exchange').on('click', function() {
                        $(this).prop('disabled', true).text('...');
                        
                        // Submit all items
                        // For simplicity in this engine, we'll loop or send a combined request.
                        // I'll implement a combined action in MarketScreen.php if needed, 
                        // but for now let's use a hidden form to submit.
                        
                        let form = $('<form action="game.php?village=<?= $village['id'] ?>&screen=market&mode=premium&action=multi&h=<?= $user['hkey'] ?>" method="post"></form>');
                        items.forEach((item, idx) => {
                            form.append(`<input type="hidden" name="items[${idx}][type]" value="${item.type}">`);
                            form.append(`<input type="hidden" name="items[${idx}][res]" value="${item.res}">`);
                            form.append(`<input type="hidden" name="items[${idx}][amount]" value="${item.best}">`);
                        });
                        $('body').append(form);
                        form.submit();
                    });
                }

                function ShowPremiumExchangeInfo() {
                    const info = <?= json_encode(__('screens.market.premium_exchange_info')) ?>;
                    
                    let html = `
                        <div id="premium-info-modal"  class="w-100" style="position:fixed; top:0; left:0; height:100%; background:rgba(0,0,0,0.7); z-index:10000; display:flex; align-items:center; justify-content:center;">
                            <div  style="background:#f4e4bc url(;"graphic/index/main_bg.jpg'); border:2px solid #7d510f; width:600px; max-height:80%; overflow-y:auto; padding:20px; position:relative; box-shadow: 0 0 20px rgba(0,0,0,0.5); border-radius:5px;">
                                <a href="javascript:void(0)" onclick="$('#premium-info-modal').remove()"  class="bold" style="position:absolute; top:10px; right:15px; font-size:24px; color:#7d510f; text-decoration:none;">&times;</a>
                                
                                <h2  style="color:#7d510f; border-bottom:1px solid #7d510f; padding-bottom:10px; margin-top:0;">${info.title}</h2>
                                <p><b>${info.intro}</b></p>
                                
                                <h3  class="mt-20" style="color:#7d510f;">${info.capacity_title}</h3>
                                <p>${info.capacity_body}</p>
                                
                                <h3  class="mt-20" style="color:#7d510f;">${info.request_title}</h3>
                                <p>${info.request_body}</p>
                                
                                <h3  class="mt-20" style="color:#7d510f;">${info.exchange_title}</h3>
                                <p>${info.exchange_body}</p>
                                
                                <h3  class="mt-20" style="color:#7d510f;">${info.fees_title}</h3>
                                <p>${info.fees_body}</p>
                                
                                <div  class="text-center" style="margin-top:30px;">
                                    <button class="btn" onclick="$('#premium-info-modal').remove()"  style="padding:5px 20px;"><?= __('screens.common.ok') ?? 'OK' ?></button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('body').append(html);
                    
                    // Close on escape
                    $(document).one('keydown', function(e) {
                        if (e.keyCode === 27) $('#premium-info-modal').remove();
                    });
                    
                    // Close on click outside
                    $('#premium-info-modal').on('click', function(e) {
                        if (e.target === this) $(this).remove();
                    });
                }
                </script>

            <?php endif; ?>

        </td>
    </tr>
</table>

<!-- Market Villages Modal -->
<div id="market_villages_modal"
     class="w-100" style="display:none; position:fixed; z-index:9999; left:0; top:0; height:100%; background-color:rgba(0,0,0,0.6);">
    <div id="market_modal_container"
         class="p-10" style="background-color: #f7eed3; border: 2px solid #804000; width: 500px; margin: 100px auto; position: relative; box-shadow: 0px 0px 15px #000;">
        <div id="market_modal_header"
             class="p-5 bold mb-10" style="background-color: #c1a264; border: 1px solid #7d510f; color: #fff;">
            <span><?= __('screens.market.your_villages') ?? 'As suas aldeias' ?></span>
            <span onclick="closeMarketVillagesModal()"
                 class="float-right pointer" style="color: #5c0d0d; background: #e3d5b3; border: 1px solid #804000; padding: 0 5px;">X</span>
        </div>
        <div id="market_modal_content"  class="p-10" style="max-height: 400px; overflow-y: auto;">
            <p  class="text-center"><?= __('screens.place.loading') ?? 'A carregar...' ?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showMarketVillagesModal() {
        var modal = document.getElementById('market_villages_modal');
        var content = document.getElementById('market_modal_content');
        
        modal.style.display = 'block';
        content.innerHTML = '<p  class="text-center"><?= addslashes(__('screens.place.loading') ?? 'A carregar...') ?></p>';

        fetch('game.php?village=<?= $village['id'] ?>&screen=popup&mode=villages')
            .then(response => response.text())
            .then(html => {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var table = doc.querySelector('table');
                if (table) {
                    content.innerHTML = '';
                    content.appendChild(table);
                    
                    // Add click handler mapping
                    var links = content.querySelectorAll('a');
                    links.forEach(function (link) {
                        link.addEventListener('click', function (e) {
                            e.preventDefault();
                            var onclick = this.getAttribute('onclick');
                            var x, y;
                            
                            if (onclick) {
                                var xMatch = onclick.match(/insertNumId\('x',\s*'(\d+)'\)/);
                                var yMatch = onclick.match(/insertNumId\('y',\s*'(\d+)'\)/);
                                if (xMatch && yMatch) {
                                    x = xMatch[1];
                                    y = yMatch[1];
                                }
                            }
                            
                            if (!x || !y) {
                                var text = this.textContent;
                                var match = text.match(/(\d+)\|(\d+)/);
                                if (match) {
                                    x = match[1];
                                    y = match[2];
                                }
                            }
                            
                            if (x && y) {
                                $('#market_destination_input').val(x + '|' + y).trigger('input');
                                closeMarketVillagesModal();
                            }
                        });
                    });
                } else {
                    content.innerHTML = '<p  class="text-center" style="color: #999;"><?= addslashes(__('screens.market.no_other_villages') ?? 'Nenhuma outra aldeia') ?></p>';
                }
            })
            .catch(err => {
                console.error(err);
                content.innerHTML = '<p  class="text-center text-red">Erro ao carregar aldeias.</p>';
            });
    }

    function closeMarketVillagesModal() {
        document.getElementById('market_villages_modal').style.display = 'none';
    }

    // Close modal when clicking outside
    document.getElementById('market_villages_modal').addEventListener('click', function (e) {
        if (e.target.id === 'market_villages_modal') {
            closeMarketVillagesModal();
        }
    });
</script>