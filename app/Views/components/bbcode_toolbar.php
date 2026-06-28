<?php $prefix = $prefix ?? ''; ?>
<div id="<?= $prefix ?>bb_bar" class="bb-bar-container" style="text-align:left; overflow:visible; margin-bottom: 10px;">
    <!-- Standard BB-Codes -->
    <a id="<?= $prefix ?>bb_button_bold" title="<?= __('screens.common.bold') ?? 'Negrito' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[b]', '[/b]'); } return false;">
        <span class="bb-icon" style="background-position: 0px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_italic" title="<?= __('screens.common.italic') ?? 'Itálico' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[i]', '[/i]'); } return false;">
        <span class="bb-icon" style="background-position: -20px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_underline" title="<?= __('screens.common.underline') ?? 'Sublinhado' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[u]', '[/u]'); } return false;">
        <span class="bb-icon" style="background-position: -40px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_strikethrough" title="<?= __('screens.common.strikethrough') ?? 'Tachado' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[s]', '[/s]'); } return false;">
        <span class="bb-icon" style="background-position: -60px 0px;"></span>
    </a>

    <span class="bb-sep">|</span>

    <a id="<?= $prefix ?>bb_button_player" title="<?= __('screens.common.player') ?? 'Jogador' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[player]', '[/player]'); } return false;">
        <span class="bb-icon" style="background-position: -80px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_tribe" title="<?= __('screens.common.tribe') ?? 'Tribo' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[ally]', '[/ally]'); } return false;">
        <span class="bb-icon" style="background-position: -100px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_coord" title="<?= __('screens.common.coords') ?? 'Coordenadas' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[coord]', '[/coord]'); } return false;">
        <span class="bb-icon" style="background-position: -120px 0px;"></span>
    </a>

    <span class="bb-sep">|</span>

    <a id="<?= $prefix ?>bb_button_quote" title="<?= __('screens.common.quote') ?? 'Citação' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[quote=Author]', '[/quote]'); } return false;">
        <span class="bb-icon" style="background-position: -140px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_url" title="<?= __('screens.common.link') ?? 'Link' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[url]', '[/url]'); } return false;">
        <span class="bb-icon" style="background-position: -160px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_img" title="<?= __('screens.common.image') ?? 'Imagem' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[img]', '[/img]'); } return false;">
        <span class="bb-icon" style="background-position: -180px 0px;"></span>
    </a>

    <span class="bb-sep">|</span>

    <a id="<?= $prefix ?>bb_button_color" title="<?= __('screens.common.color') ?? 'Cor' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.togglePopup('<?= $prefix ?>bb_color_picker', this); } return false;">
        <span class="bb-icon" style="background-position: -200px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_size" title="<?= __('screens.common.font_size') ?? 'Tamanho da fonte' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.togglePopup('<?= $prefix ?>bb_sizes', this); } return false;">
        <span class="bb-icon" style="background-position: -220px 0px;"></span>
    </a>

    <span class="bb-sep">|</span>

    <a id="<?= $prefix ?>bb_button_report_display" title="<?= __('screens.common.report') ?? 'Relatório' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[report_display]', '[/report_display]'); } return false;">
        <span class="bb-icon" style="background-position: -240px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_spoiler" title="<?= __('screens.common.spoiler') ?? 'Spoiler' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[spoiler]', '[/spoiler]'); } return false;">
        <span class="bb-icon" style="background-position: -260px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_table" title="<?= __('screens.common.table') ?? 'Tabela' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.insert('[table][**]head1[||]head2[/**][*]text1[|]text2[/*][/table]', ''); } return false;">
        <span class="bb-icon" style="background-position: -280px 0px;"></span>
    </a>

    <span class="bb-sep">|</span>

    <a id="<?= $prefix ?>bb_button_units" title="<?= __('screens.common.units') ?? 'Unidades' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.togglePopup('<?= $prefix ?>bb_units_popup', this); } return false;">
        <span class="bb-icon" style="background-position: -300px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_building" title="<?= __('screens.common.buildings') ?? 'Edifícios' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.togglePopup('<?= $prefix ?>bb_buildings_popup', this); } return false;">
        <span class="bb-icon" style="background-position: -320px 0px;"></span>
    </a>
    <a id="<?= $prefix ?>bb_button_emoji" title="<?= __('screens.common.emoji') ?? 'Emoji' ?>" href="#"
        onclick="if (typeof BBCodes !== 'undefined') { BBCodes.setTarget($('#<?= $textareaId ?>')); BBCodes.togglePopup('<?= $prefix ?>bb_emoji_popup', this); } return false;">
        <span class="bb-icon" style="background-position: -360px 0px;"></span>
    </a>

    <!-- Popups -->
    
    <!-- Font Size Menu -->
    <table id="<?= $prefix ?>bb_sizes" class="bb-popup bb-popup-table" style="display: none; width: 150px;">
        <tbody>
            <tr>
                <td style="padding: 5px;">
                    <a href="#" onclick="BBCodes.insert('[size=6]', '[/size]'); $('.bb-popup').hide(); return false;"><?= __('screens.common.size_very_small') ?? 'Muito pequeno' ?></a><br>
                    <a href="#" onclick="BBCodes.insert('[size=7]', '[/size]'); $('.bb-popup').hide(); return false;"><?= __('screens.common.size_small') ?? 'Pequeno' ?></a><br>
                    <a href="#" onclick="BBCodes.insert('[size=9]', '[/size]'); $('.bb-popup').hide(); return false;"><?= __('screens.common.size_normal') ?? 'Normal' ?></a><br>
                    <a href="#" onclick="BBCodes.insert('[size=12]', '[/size]'); $('.bb-popup').hide(); return false;"><?= __('screens.common.size_large') ?? 'Grande' ?></a><br>
                    <a href="#" onclick="BBCodes.insert('[size=20]', '[/size]'); $('.bb-popup').hide(); return false;"><?= __('screens.common.size_very_large') ?? 'Muito grande' ?></a><br>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Color Picker Popup -->
    <div id="<?= $prefix ?>bb_color_picker" class="bb-popup" style="display: none; width: 200px;">
        <div class="bb-popup-header">
            <strong><?= __('screens.common.color_picker') ?? 'Seletor de Cores' ?></strong>
            <a onclick="$('#<?= $prefix ?>bb_color_picker').hide(); return false;" href="#" class="bb-popup-close">×</a>
        </div>
        <div style="padding: 10px;">
            <div class="color-picker-colors"></div>
            <div class="color-picker-tones"></div>
            <div class="color-picker-preview"><?= __('screens.common.text') ?? 'Texto' ?></div>
            <input class="color-picker-hex" type="text" size="7" style="display:none;">
            <div style="text-align:center; margin-top:5px;">
                <input value="OK" class="btn" onclick="BBCodes.colorPickerOk('<?= $prefix ?>bb_color_picker'); return false;" type="button" style="display:none;">
            </div>
        </div>
    </div>

    <!-- Units Popup -->
    <div id="<?= $prefix ?>bb_units_popup" class="bb-popup" style="display: none; width: 220px;">
        <div class="bb-popup-header">
            <strong><?= __('screens.common.units') ?? 'Unidades' ?></strong>
            <a onclick="$('#<?= $prefix ?>bb_units_popup').hide(); return false;" href="#" class="bb-popup-close">×</a>
        </div>
        <div style="padding: 10px; text-align: center;">
            <?php 
            $units = ['spear', 'sword', 'axe', 'archer', 'spy', 'light', 'marcher', 'heavy', 'ram', 'catapult', 'knight', 'snob', 'militia'];
            foreach ($units as $u): ?>
                <a href="#" onclick="BBCodes.insert('[unit]<?= $u ?>[/unit]', ''); $('#<?= $prefix ?>bb_units_popup').hide(); return false;" title="<?= $u ?>">
                    <img src="/graphic/unit/unit_<?= $u ?>.png" alt="<?= $u ?>" style="margin: 2px;">
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Buildings Popup -->
    <div id="<?= $prefix ?>bb_buildings_popup" class="bb-popup" style="display: none; width: 280px;">
        <div class="bb-popup-header">
            <strong><?= __('screens.common.buildings') ?? 'Edifícios' ?></strong>
            <a onclick="$('#<?= $prefix ?>bb_buildings_popup').hide(); return false;" href="#" class="bb-popup-close">×</a>
        </div>
        <div style="padding: 10px; text-align: center;">
            <?php 
            $buildings = ['main', 'barracks', 'stable', 'garage', 'church', 'snob', 'smith', 'place', 'statue', 'market', 'wood', 'stone', 'iron', 'farm', 'storage', 'hide', 'wall'];
            foreach ($buildings as $b): ?>
                <a href="#" onclick="BBCodes.insert('[building]<?= $b ?>[/building]', ''); $('#<?= $prefix ?>bb_buildings_popup').hide(); return false;" title="<?= $b ?>">
                    <img src="/graphic/buildings/<?= $b ?>.png" alt="<?= $b ?>" style="margin: 2px;">
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Emoji Popup -->
    <div id="<?= $prefix ?>bb_emoji_popup" class="bb-popup" style="display: none; width: 280px;">
        <div class="bb-popup-header">
            <strong>Emoji</strong>
            <a onclick="$('#<?= $prefix ?>bb_emoji_popup').hide(); return false;" href="#" class="bb-popup-close">×</a>
        </div>
        <div style="padding: 10px; max-height: 200px; overflow-y: auto; text-align: center;">
            <?php
            $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '🤯', '🤠', '🥳', '😎', '🤓', '🧐', '😕', '😟', '🙁', '😮', '😯', '😲', '😳', '🥺', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣', '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬', '😈', '👿', '💀', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖', '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟'];
            foreach ($emojis as $e) {
                echo '<a href="#" onclick="BBCodes.insert(\'' . $e . '\', \'\'); return false;" style="font-size: 20px; text-decoration: none; margin: 2px; display: inline-block;">' . $e . '</a>';
            }
            ?>
        </div>
    </div>
</div>

<style>
    .bb-bar-container {
        position: relative;
    }
    .bb-icon {
        display: inline-block;
        background: url(/graphic/bbcodes/bbcodes.webp) no-repeat;
        width: 20px;
        height: 20px;
        margin-right: 2px;
        margin-bottom: 3px;
        vertical-align: middle;
    }
    .bb-sep {
        margin: 0 5px;
        color: #7d510f;
        font-weight: bold;
    }
    .bb-popup {
        position: absolute;
        z-index: 1000;
        background: #f4e4bc;
        border: 2px solid #7d510f;
        box-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }
    .bb-popup-header {
        background: #c1a264;
        color: white;
        padding: 5px 10px;
        cursor: move;
        position: relative;
        font-size: 12px;
    }
    .bb-popup-close {
        position: absolute;
        right: 10px;
        top: 3px;
        color: white;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }
    .bb-popup-table {
        background: #f4e4bc;
        border: 2px solid #7d510f;
        white-space: nowrap;
        font-size: 11px;
    }
    .bb-popup-table a {
        text-decoration: none;
        color: black;
        display: block;
        padding: 2px 5px;
    }
    .bb-popup-table a:hover {
        background: #c1a264;
        color: white;
    }
    .color-picker-colors div, .color-picker-tones div {
        width: 15px;
        height: 15px;
        float: left;
        margin: 1px;
        cursor: pointer;
        border: 1px solid #000;
    }
    .color-picker-preview {
        clear: both;
        margin-top: 10px;
        padding: 5px;
        border: 1px solid #7d510f;
        text-align: center;
        background: white;
    }
</style>

<script type="text/javascript">
(function() {
    window.BBCodes = window.BBCodes || {};
    
    // Add or update methods
    $.extend(window.BBCodes, {
        target: null,
            
        setTarget: function(el) {
            this.target = el;
        },
            
        insert: function(start, end) {
            if (!this.target || this.target.length === 0) return;
            var el = this.target[0];
            var val = el.value;
            var startPos = el.selectionStart;
            var endPos = el.selectionEnd;
            var selectedText = val.substring(startPos, endPos);
            
            el.value = val.substring(0, startPos) + start + selectedText + end + val.substring(endPos);
            el.focus();
            el.selectionStart = startPos + start.length;
            el.selectionEnd = startPos + start.length + selectedText.length;
        },
            
        togglePopup: function(id, btn) {
            var $p = $('#' + id);
            if ($p.is(':visible')) {
                $p.hide();
            } else {
                // Close all other popups
                $('.bb-popup').hide();
                
                var $btn = $(btn);
                var offset = $btn.offset();
                var $container = $btn.closest('.bb-bar-container');
                var containerOffset = $container.offset();
                if (!containerOffset) return;
                
                // Position relative to container
                var left = offset.left - containerOffset.left;
                var top = offset.top - containerOffset.top + 25;
                
                // Adjust if going off-screen (basic)
                var containerWidth = $container.width();
                var popupWidth = $p.outerWidth() || 200;
                if (left + popupWidth > containerWidth) {
                    left = containerWidth - popupWidth - 5;
                }
                
                $p.css({
                    left: left + 'px', 
                    top: top + 'px'
                }).show();
                
                if (id.indexOf('bb_color_picker') !== -1) {
                    this.initColorPicker(id);
                }
            }
        },

        colorPickerToggle: function(id, btn) {
            this.togglePopup(id, btn);
        },

        initColorPicker: function(id) {
            var self = this;
            var $p = $('#' + id);
            var $colors = $p.find('.color-picker-colors');
            var $tones = $p.find('.color-picker-tones');
            
            if ($colors.children().length > 0) return;

            // Classic palette
            var baseColors = [
                '#FF0000', '#FF8000', '#FFFF00', '#80FF00', '#00FF00', '#00FF80', '#00FFFF', '#0080FF', 
                '#0000FF', '#8000FF', '#FF00FF', '#FF0080', '#FFFFFF', '#C0C0C0', '#808080', '#000000'
            ];
            
            baseColors.forEach(function(c) {
                $('<div>').css('background', c).click(function() {
                    self.insert('[color=' + c + ']', '[/color]');
                    $p.hide();
                }).mouseover(function() {
                    $(this).css('border-color', '#fff');
                }).mouseout(function() {
                    $(this).css('border-color', '#000');
                }).appendTo($colors);
            });

            // Additional tones
            var tones = [
                '#800000', '#804000', '#808000', '#408000', '#008000', '#008040', '#008080', '#004080',
                '#000080', '#400080', '#800080', '#800040', '#404040', '#202020', '#101010', '#050505'
            ];
            
            tones.forEach(function(c) {
                $('<div>').css('background', c).click(function() {
                    self.insert('[color=' + c + ']', '[/color]');
                    $p.hide();
                }).mouseover(function() {
                    $(this).css('border-color', '#fff');
                }).mouseout(function() {
                    $(this).css('border-color', '#000');
                }).appendTo($tones);
            });
        }
    });

    // Global initializations (only once)
    if (!window.BBCodesInitialized) {
        // Close on click outside
        $(document).on('mousedown', function(e) {
            if (!$('.bb-popup').is(e.target) && $('.bb-popup').has(e.target).length === 0 && !$(e.target).closest('a[id*="bb_button"]').length) {
                $('.bb-popup').hide();
            }
        });

        $(document).ready(function() {
            if ($.fn.draggable) {
                $('.bb-popup').draggable({
                    handle: '.bb-popup-header',
                    containment: 'window'
                });
            }
        });
        
        window.BBCodesInitialized = true;
    }
})();
</script>