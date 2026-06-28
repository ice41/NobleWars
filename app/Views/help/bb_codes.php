<?php
// BB Codes Help Content
?>
<h1><?= __('help.bb_codes.title', 'BB-Codes') ?></h1>
<p><?= __('help.bb_codes.intro', 'BB-Codes são códigos especiais usados para formatar textos em mensagens, fóruns de tribo e perfis de jogadores.') ?></p>

<style>
    .bb-example-row {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
        border-bottom: 1px solid #cfaa7d;
        padding-bottom: 15px;
    }
    .bb-example-col {
        flex: 1;
        min-width: 250px;
    }
    .bb-example-col h4 {
        margin-top: 0;
        color: #5c0909;
        margin-bottom: 10px;
    }
    .bb-preview-box {
        background-color: #fff5e1;
        border: 1px solid #7d510f;
        padding: 15px;
        border-radius: 4px;
        min-height: 50px;
    }
    .bb-quote {
        border-left: 4px solid #7d510f;
        background-color: #f4ead4;
        padding: 10px;
        margin: 5px 0;
        font-style: italic;
    }
    .bb-quote-author {
        font-weight: bold;
        color: #5c0909;
        margin-bottom: 5px;
        font-style: normal;
    }
    .bb-spoiler {
        border: 1px solid #7d510f;
        background-color: #f4ead4;
    }
    .bb-spoiler-title {
        background-color: #e2c07c;
        padding: 5px 10px;
        font-weight: bold;
        cursor: pointer;
        user-select: none;
    }
    .bb-spoiler-content {
        padding: 10px;
        background-color: #fff5e1;
    }
    .bbcodetable {
        border-collapse: collapse;
        width: 100%;
        background-color: #f4ead4;
        margin: 10px 0;
    }
    .bbcodetable th {
        background-color: #cfaa7d;
        color: #5c0909;
        padding: 6px 10px;
        border: 1px solid #7d510f;
        text-align: left;
    }
    .bbcodetable td {
        padding: 6px 10px;
        border: 1px solid #7d510f;
    }
</style>

<div class="bb-codes-container">

    <!-- 1. Bold, Italic, Underline, Strikethrough -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>1. <?= __('help.bb_codes.format_title', 'Formatação de Texto (Bold, Italic, Underline, Strikethrough)') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[b]Texto em Negrito[/b]
[i]Texto em Itálico[/i]
[u]Texto Sublinhado[/u]
[s]Texto Tachado[/s]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <b>Texto em Negrito</b><br>
                <i>Texto em Itálico</i><br>
                <u>Texto Sublinhado</u><br>
                <s>Texto Tachado</s>
            </div>
        </div>
    </div>

    <!-- 2. Colors -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>2. <?= __('help.bb_codes.color_title', 'Cores (Color)') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[color=red]Texto Vermelho[/color]
[color=#0000FF]Texto Azul[/color]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <span style="color: red;">Texto Vermelho</span><br>
                <span style="color: #0000FF;">Texto Azul</span>
            </div>
        </div>
    </div>

    <!-- 3. Size -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>3. <?= __('help.bb_codes.size_title', 'Tamanho da Fonte (Size)') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[size=9]Texto Pequeno[/size]
[size=18]Texto Grande[/size]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <span style="font-size: 9px;">Texto Pequeno</span><br>
                <span style="font-size: 18px;">Texto Grande</span>
            </div>
        </div>
    </div>

    <!-- 4. Quotes -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>4. <?= __('help.bb_codes.quote_title', 'Citação (Quote)') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[quote=Ice41]Este é um exemplo de citação.[/quote]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box" style="padding: 5px 15px;">
                <div class="bb-quote">
                    <div class="bb-quote-author">Ice41 escreveu:</div>
                    Este é um exemplo de citação.
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Links -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>5. <?= __('help.bb_codes.link_title', 'Links / URL') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[url]http://www.noblewars.com[/url]
[url=http://www.noblewars.com]Visitar Jogo[/url]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <a href="#" onclick="return false;">http://www.noblewars.com</a><br>
                <a href="#" onclick="return false;">Visitar Jogo</a>
            </div>
        </div>
    </div>

    <!-- 6. Players and Tribes -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>6. <?= __('help.bb_codes.entities_title', 'Jogadores e Tribos') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[player]Ice41[/player]
[ally]Nobles[/ally]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <a href="#" onclick="return false;"><i class="fas fa-user"></i> Ice41</a><br>
                <a href="#" onclick="return false;"><i class="fas fa-shield-alt"></i> Nobles</a>
            </div>
        </div>
    </div>

    <!-- 7. Coordinates -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>7. <?= __('help.bb_codes.coords_title', 'Coordenadas (Map Link)') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[coord]500|500[/coord]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <a href="#" onclick="return false;"><i class="fas fa-map-marker-alt"></i> Aldeia de Bárbaros (500|500) K55</a>
            </div>
        </div>
    </div>

    <!-- 8. Spoilers -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>8. <?= __('help.bb_codes.spoiler_title', 'Spoiler') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[spoiler]Este segredo foi revelado![/spoiler]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box" style="padding: 5px 15px;">
                <details class="bb-spoiler" style="margin: 5px 0;">
                    <summary class="bb-spoiler-title">Spoiler</summary>
                    <div class="bb-spoiler-content">
                        Este segredo foi revelado!
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- 9. Images -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>9. <?= __('help.bb_codes.img_title', 'Imagens (Image)') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[img]graphic/buildings/main.png[/img]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <img src="graphic/buildings/main.png" alt="Edifício Principal" style="max-height: 40px;">
            </div>
        </div>
    </div>

    <!-- 10. Reports -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>10. <?= __('help.bb_codes.report_title', 'Relatórios') ?></h4>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[report]12ab3c4d[/report]
[report_display]12ab3c4d[/report_display]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box">
                <a href="#" onclick="return false;"><i class="fas fa-file-alt"></i> Combat Report (12ab3c4d)</a><br>
                <small style="color: #666;">(A tag [report_display] carrega o conteúdo completo do relatório diretamente na página do fórum)</small>
            </div>
        </div>
    </div>

    <!-- 11. Buildings -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>11. <?= __('help.bb_codes.building_title', 'Edifícios (Building)') ?></h4>
            <p style="font-size: 0.9em; margin-bottom: 10px; color: #666;">
                <?= __('help.bb_codes.building_desc', 'Mostra o ícone gráfico de um edifício do jogo.') ?>
            </p>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[building]main[/building]
[building]barracks[/building]
[building]stable[/building]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box" style="display: flex; gap: 15px; align-items: center; min-height: 50px;">
                <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <img src="graphic/buildings/main.png" alt="Edifício Principal" style="max-height: 20px;" onerror="this.src='graphic/icons/questionmark.png'">
                    <span>main</span>
                </div>
                <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <img src="graphic/buildings/barracks.png" alt="Quartel" style="max-height: 20px;" onerror="this.src='graphic/icons/questionmark.png'">
                    <span>barracks</span>
                </div>
                <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <img src="graphic/buildings/stable.png" alt="Estábulo" style="max-height: 20px;" onerror="this.src='graphic/icons/questionmark.png'">
                    <span>stable</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 12. Units -->
    <div class="bb-example-row">
        <div class="bb-example-col">
            <h4>12. <?= __('help.bb_codes.unit_title', 'Unidades (Unit)') ?></h4>
            <p style="font-size: 0.9em; margin-bottom: 10px; color: #666;">
                <?= __('help.bb_codes.unit_desc', 'Mostra o ícone gráfico de uma unidade de tropa do jogo.') ?>
            </p>
            <pre class="code" style="margin: 0; padding: 10px; background: #222; color: #fff; font-family: monospace;">[unit]spear[/unit]
[unit]sword[/unit]
[unit]axe[/unit]</pre>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box" style="display: flex; gap: 15px; align-items: center; min-height: 50px;">
                <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <img src="graphic/unit/unit_spear.png" alt="Lanceiro" style="max-height: 20px;" onerror="this.src='graphic/icons/questionmark.png'">
                    <span>spear</span>
                </div>
                <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <img src="graphic/unit/unit_sword.png" alt="Espadachim" style="max-height: 20px;" onerror="this.src='graphic/icons/questionmark.png'">
                    <span>sword</span>
                </div>
                <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <img src="graphic/unit/unit_axe.png" alt="Bárbaro" style="max-height: 20px;" onerror="this.src='graphic/icons/questionmark.png'">
                    <span>axe</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 13. Tables -->
    <div class="bb-example-row" style="border-bottom: none; padding-bottom: 0;">
        <div class="bb-example-col">
            <h4>13. <?= __('help.bb_codes.table_title', 'Tabelas (Table)') ?></h4>
            <p style="font-size: 0.9em; margin-bottom: 10px; color: #666;">
                <?= __('help.bb_codes.table_desc', 'Permite criar tabelas formatadas. Suporta tanto tags HTML padrão quanto a sintaxe simplificada de colchetes do jogo.') ?>
            </p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <strong style="font-size: 0.85em; color: #5c0909;">Standard:</strong>
                    <pre class="code" style="margin: 5px 0 0 0; padding: 8px; background: #222; color: #fff; font-family: monospace; font-size: 0.85em;">[table]
[tr]
[th]Header 1[/th]
[th]Header 2[/th]
[/tr]
[tr]
[td]Cell 1[/td]
[td]Cell 2[/td]
[/tr]
[/table]</pre>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <strong style="font-size: 0.85em; color: #5c0909;">Shorthand:</strong>
                    <pre class="code" style="margin: 5px 0 0 0; padding: 8px; background: #222; color: #fff; font-family: monospace; font-size: 0.85em;">[table]
[**]Header 1[||]Header 2[/**]
[*]Cell 1[|]Cell 2[/*]
[/table]</pre>
                </div>
            </div>
        </div>
        <div class="bb-example-col">
            <h4><?= __('help.bb_codes.how_it_looks', 'Como Fica:') ?></h4>
            <div class="bb-preview-box" style="padding: 5px 15px;">
                <table class="bbcodetable">
                    <thead>
                        <tr>
                            <th>Header 1</th>
                            <th>Header 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cell 1</td>
                            <td>Cell 2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>