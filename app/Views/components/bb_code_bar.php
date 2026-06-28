<!-- BB Code Editor Bar -->
<div class="bb_bar" style="background-color: #f4e4bc; padding: 5px; border: 1px solid #c0a070; margin-bottom: 5px;">
    <button type="button" class="bb_button" onclick="insertBBCode('b')" title="Negrito">
        <strong>B</strong>
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('i')" title="Itálico">
        <em>I</em>
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('u')" title="Sublinhado">
        <u>U</u>
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('s')" title="Riscado">
        <s>S</s>
    </button>

    <span style="margin: 0 5px;">|</span>

    <button type="button" class="bb_button" onclick="insertBBCode('quote')" title="Citação">
        💬 Quote
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('code')" title="Código">
        &lt;/&gt; Code
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('list')" title="Lista">
        ≡ List
    </button>

    <span style="margin: 0 5px;">|</span>

    <button type="button" class="bb_button" onclick="insertBBCode('url')" title="Link">
        🔗 URL
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('player')" title="Jogador">
        👤 Player
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('tribe')" title="Tribo">
        🛡️ Tribe
    </button>
    <button type="button" class="bb_button" onclick="insertBBCode('coord')" title="Coordenadas">
        📍 Coord
    </button>

    <span style="margin: 0 5px;">|</span>

    <select onchange="insertColor(this.value); this.selectedIndex=0;" class="bb_select">
        <option value="">Cor</option>
        <option value="red" style="color: red;">Vermelho</option>
        <option value="blue" style="color: blue;">Azul</option>
        <option value="green" style="color: green;">Verde</option>
        <option value="yellow" style="color: #DAA520;">Amarelo</option>
        <option value="orange" style="color: orange;">Laranja</option>
        <option value="purple" style="color: purple;">Roxo</option>
        <option value="brown" style="color: brown;">Castanho</option>
        <option value="black" style="color: black;">Preto</option>
        <option value="gray" style="color: gray;">Cinzento</option>
    </select>

    <select onchange="insertSize(this.value); this.selectedIndex=0;" class="bb_select">
        <option value="">Tamanho</option>
        <option value="8">Muito pequeno</option>
        <option value="10">Pequeno</option>
        <option value="12">Normal</option>
        <option value="14">Grande</option>
        <option value="18">Muito grande</option>
        <option value="24">Enorme</option>
    </select>
</div>

<style>
    .bb_button {
        background-color: #fff;
        border: 1px solid #c0a070;
        padding: 3px 8px;
        margin: 0 2px;
        cursor: pointer;
        font-size: 12px;
    }

    .bb_button:hover {
        background-color: #f0e0c0;
    }

    .bb_button:active {
        background-color: #e0d0b0;
    }

    .bb_select {
        background-color: #fff;
        border: 1px solid #c0a070;
        padding: 3px 5px;
        margin: 0 2px;
        font-size: 12px;
        cursor: pointer;
    }

    .quote {
        background-color: #f9f9f9;
        border-left: 3px solid #c0a070;
        padding: 10px;
        margin: 10px 0;
        font-style: italic;
    }

    .code {
        background-color: #f4f4f4;
        border: 1px solid #ddd;
        padding: 10px;
        margin: 10px 0;
        font-family: 'Courier New', monospace;
        overflow-x: auto;
    }
</style>

<script>
    // Get the active textarea (set this ID when including the BB bar)
    var activeTextarea = '<?= $textareaId ?? "content" ?>';

    function insertBBCode(tag) {
        var textarea = document.getElementById(activeTextarea);
        if (!textarea) return;

        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selectedText = textarea.value.substring(start, end);
        var beforeText = textarea.value.substring(0, start);
        var afterText = textarea.value.substring(end);

        var insertText = '';

        switch (tag) {
            case 'b':
            case 'i':
            case 'u':
            case 's':
                insertText = '[' + tag + ']' + (selectedText || 'texto') + '[/' + tag + ']';
                break;
            case 'quote':
                insertText = '[quote]' + (selectedText || 'texto citado') + '[/quote]';
                break;
            case 'code':
                insertText = '[code]' + (selectedText || 'código') + '[/code]';
                break;
            case 'list':
                insertText = '[list]\n[*]Item 1\n[*]Item 2\n[*]Item 3\n[/list]';
                break;
            case 'url':
                var url = prompt('Insira o URL:', 'http://');
                if (url) {
                    insertText = '[url=' + url + ']' + (selectedText || 'link') + '[/url]';
                }
                break;
            case 'player':
                var player = prompt('Nome do jogador:', selectedText || '');
                if (player) {
                    insertText = '[player]' + player + '[/player]';
                }
                break;
            case 'tribe':
                var tribe = prompt('Nome da tribo:', selectedText || '');
                if (tribe) {
                    insertText = '[tribe]' + tribe + '[/tribe]';
                }
                break;
            case 'coord':
                var coord = prompt('Coordenadas (xxx|yyy):', selectedText || '500|500');
                if (coord) {
                    insertText = '[coord]' + coord + '[/coord]';
                }
                break;
        }

        if (insertText) {
            textarea.value = beforeText + insertText + afterText;
            textarea.focus();

            // Set cursor position after inserted text
            var newPos = start + insertText.length;
            textarea.setSelectionRange(newPos, newPos);
        }
    }

    function insertColor(color) {
        if (!color) return;

        var textarea = document.getElementById(activeTextarea);
        if (!textarea) return;

        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selectedText = textarea.value.substring(start, end);
        var beforeText = textarea.value.substring(0, start);
        var afterText = textarea.value.substring(end);

        var insertText = '[color=' + color + ']' + (selectedText || 'texto') + '[/color]';

        textarea.value = beforeText + insertText + afterText;
        textarea.focus();

        var newPos = start + insertText.length;
        textarea.setSelectionRange(newPos, newPos);
    }

    function insertSize(size) {
        if (!size) return;

        var textarea = document.getElementById(activeTextarea);
        if (!textarea) return;

        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selectedText = textarea.value.substring(start, end);
        var beforeText = textarea.value.substring(0, start);
        var afterText = textarea.value.substring(end);

        var insertText = '[size=' + size + ']' + (selectedText || 'texto') + '[/size]';

        textarea.value = beforeText + insertText + afterText;
        textarea.focus();

        var newPos = start + insertText.length;
        textarea.setSelectionRange(newPos, newPos);
    }
</script>