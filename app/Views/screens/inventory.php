<?php
// Inventory Screen View - Premium Split Layout (Tribal Wars style)

if (!function_exists('get_item_image')) {
    function get_item_image($item) {
        $effect_type = $item['effect_type'] ?? '';
        $icon = $item['icon'] ?? '';
        $effect_data = json_decode($item['effect_data'] ?? '{}', true);

        if (!empty($icon)) {
            return "graphic/new/inventory/" . $icon;
        }

        return "graphic/new/inventory/3001.webp"; // Default fallback
    }
}
?>

<style>
    /* Premium Inventory CSS Layout */
    .inventory-wrapper {
        background: #f4e4bc url('graphic/index/main_bg.jpg') repeat;
        border: 2px solid #7d510f;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
        border-radius: 4px;
        padding: 15px;
        font-family: Arial, sans-serif;
    }

    .inventory-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #7d510f;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .inventory-header h2 {
        font-size: 20px;
        font-weight: bold;
        color: #7d510f;
        text-shadow: 1px 1px 0px #fff;
        margin: 0;
    }

    .btn-history {
        background: #8e6224;
        color: #fff;
        border: 1px solid #4a300a;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
        padding: 6px 12px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        border-radius: 3px;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.3);
    }

    .btn-history:hover {
        background: #a3722e;
    }

    /* Tabs list */
    .inventory-tabs {
        display: flex;
        border-bottom: 1px solid #7d510f;
        margin-bottom: 15px;
        padding: 0;
        list-style: none;
        gap: 2px;
    }

    .inventory-tab-btn {
        background: #d3c29d;
        color: #5b3e10;
        border: 1px solid #7d510f;
        border-bottom: none;
        padding: 8px 16px;
        font-weight: bold;
        font-size: 13px;
        cursor: pointer;
        border-radius: 4px 4px 0 0;
    }

    .inventory-tab-btn:hover {
        background: #e4d5b2;
    }

    .inventory-tab-btn.active {
        background: #f4e4bc;
        color: #7d510f;
        border-bottom: 1px solid #f4e4bc;
        margin-bottom: -1px;
        position: relative;
        z-index: 2;
    }

    /* Columns layout */
    .inventory-cols {
        display: flex;
        gap: 15px;
    }

    /* Left col: item list grid */
    .inventory-left {
        flex: 1.2;
        background: rgba(255, 255, 255, 0.45);
        border: 1px solid #b79f72;
        border-radius: 4px;
        padding: 10px;
        min-height: 400px;
    }

    /* Right col: item preview pane */
    .inventory-right {
        flex: 0.8;
        background: #f4e4bc;
        border: 1px solid #7d510f;
        border-radius: 4px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
    }

    .item-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(76px, 1fr));
        gap: 10px;
    }

    .item-cell {
        border: 1px solid #7d510f;
        background: #efe0c0;
        border-radius: 3px;
        aspect-ratio: 1;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
        transition: all 0.15s ease-in-out;
    }

    .item-cell:hover {
        background: #fdf5d6;
        border-color: #a8721c;
        transform: scale(1.03);
    }

    .item-cell.selected {
        background: #d8be8d;
        border-color: #7d510f;
        box-shadow: 0 0 5px rgba(125, 81, 15, 0.5);
    }

    .item-cell img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }

    .item-badge {
        position: absolute;
        bottom: 2px;
        right: 2px;
        background: #7d510f;
        color: #fff;
        font-size: 10px;
        font-weight: bold;
        padding: 1px 4px;
        border-radius: 8px;
        border: 1px solid #fff;
        line-height: 1;
    }

    /* Preview content */
    .preview-placeholder {
        color: #8b7550;
        text-align: center;
        margin-top: 100px;
        font-size: 14px;
        font-style: italic;
    }

    .preview-box {
        display: none;
        width: 100%;
        text-align: center;
    }

    .preview-icon-container {
        width: 120px;
        height: 120px;
        background: #efe0c0;
        border: 2px solid #7d510f;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px auto;
        padding: 10px;
    }

    .preview-icon-container img {
        max-width: 95%;
        max-height: 95%;
        object-fit: contain;
    }

    .preview-title {
        font-size: 18px;
        font-weight: bold;
        color: #7d510f;
        margin-bottom: 8px;
        text-shadow: 1px 1px 0px #fff;
    }

    .preview-desc {
        font-size: 13px;
        color: #554433;
        margin-bottom: 20px;
        line-height: 1.4;
        background: rgba(255,255,255,0.4);
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #dfd0ab;
    }

    .preview-target-village {
        margin-bottom: 15px;
        text-align: left;
        width: 100%;
    }

    .preview-target-village label {
        display: block;
        font-weight: bold;
        font-size: 12px;
        color: #7d510f;
        margin-bottom: 5px;
    }

    .select-target-village {
        width: 100%;
        padding: 6px;
        border: 1px solid #7d510f;
        border-radius: 3px;
        background-color: #fff;
        font-size: 13px;
    }

    .btn-use-item {
        background: #4caf50;
        color: #fff;
        border: 1px solid #3d8b40;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.2);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
        margin-top: 10px;
    }

    .btn-use-item:hover {
        background: #45a049;
    }

    .btn-use-item:disabled {
        background: #b2c9b2;
        border-color: #92a892;
        cursor: not-allowed;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #f4e4bc;
        margin: 10% auto;
        padding: 15px;
        border: 2px solid #7d510f;
        width: 90%;
        max-width: 500px;
        border-radius: 4px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #7d510f;
        padding-bottom: 8px;
        margin-bottom: 12px;
    }

    .modal-header h3 {
        margin: 0;
        color: #7d510f;
    }

    .close {
        color: #7d510f;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .history-list {
        max-height: 350px;
        overflow-y: auto;
    }

    .history-item {
        background: #efe0c0;
        border: 1px solid #7d510f;
        border-radius: 3px;
        margin-bottom: 6px;
        padding: 8px;
        display: flex;
        justify-content: space-between;
        font-size: 12px;
    }
</style>

<div class="inventory-wrapper">
    <div class="inventory-header">
        <h2>📦 <?= __('screens.profile.inventory_title') ?></h2>
        <button class="btn-history" onclick="showHistory()">
            📜 <?= __('screens.profile.view_history') ?>
        </button>
    </div>

    <!-- Filters -->
    <ul class="inventory-tabs">
        <?php foreach ($item_types as $type => $label): ?>
            <li>
                <button class="inventory-tab-btn <?= $current_filter === $type ? 'active' : '' ?>"
                    onclick="filterItems('<?= $type ?>')">
                    <?= $label ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Layout Columns -->
    <div class="inventory-cols">
        <!-- Item Grid Column -->
        <div class="inventory-left">
            <?php if (empty($inventory_items)): ?>
                <div style="text-align: center; padding: 80px 20px; color: #7d510f; font-style: italic;">
                    <div style="font-size: 48px; margin-bottom: 10px;">📦</div>
                    <h3><?= __('screens.profile.inventory_empty') ?></h3>
                    <p><?= __('screens.profile.no_items_yet') ?></p>
                </div>
            <?php else: ?>
                <div class="item-grid">
                    <?php foreach ($inventory_items as $index => $item): ?>
                        <div class="item-cell" id="item-cell-<?= $item['inventory_id'] ?>"
                            <?php 
                                $translatedItem = $item;
                                $translatedItem['name'] = __('items.item_' . $item['item_id'] . '_name', $item['name']);
                                $translatedItem['description'] = __('items.item_' . $item['item_id'] . '_desc', $item['description']);
                            ?>
                             onclick="selectItem(<?= htmlspecialchars(json_encode($translatedItem)) ?>, '<?= get_item_image($item) ?>')">
                            <?php $itemName = __('items.item_' . $item['item_id'] . '_name', $item['name']); ?>
                            <img src="<?= get_item_image($item) ?>" alt="<?= htmlspecialchars($itemName) ?>" />
                            <div class="item-badge">x<?= $item['total_quantity'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($inventory['total_pages'] > 1): ?>
                    <div style="margin-top: 15px; font-size: 13px;">
                        <strong>Página:</strong>
                        <?php for ($i = 1; $i <= $inventory['total_pages']; $i++): ?>
                            <?php if ($i === $inventory['page']): ?>
                                ><strong><?= $i ?></strong>< 
                            <?php else: ?>
                                <a href="game.php?village=<?= $village['id'] ?>&screen=profile&mode=inventory&filter=<?= htmlspecialchars($current_filter) ?>&page=<?= $i ?>">[<?= $i ?>]</a> 
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>

        <!-- Preview Column -->
        <div class="inventory-right">
            <div class="preview-placeholder" id="preview-placeholder">
                <div style="font-size: 36px; margin-bottom: 10px;">ℹ️</div>
                <?= __('screens.profile.inventory_select_item') ?>
            </div>

            <div class="preview-box" id="preview-box">
                <div class="preview-icon-container">
                    <img id="preview-img" src="" alt="" />
                </div>
                <div class="preview-title" id="preview-name">Item Name</div>
                <div class="preview-desc" id="preview-description">Item Description</div>

                <!-- target-village-container removed as items apply to current village automatically -->

                <button class="btn-use-item" id="btn-use" onclick="useSelectedItem()">
                    <?= __('screens.profile.use') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- History Modal -->
<div id="historyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>📜 <?= __('screens.profile.inventory_history') ?></h3>
            <span class="close" onclick="closeHistory()">&times;</span>
        </div>
        <div class="history-list" id="historyList">
            <p style="text-align: center; color: #7d510f; font-style: italic;"><?= __('screens.profile.loading') ?></p>
        </div>
    </div>
</div>

<!-- Confirm Use Modal -->
<div id="confirmModal" class="modal">
    <div class="modal-content" style="max-width: 400px; text-align: center;">
        <div class="modal-header">
            <h3>Confirmação</h3>
            <span class="close" onclick="closeConfirm()">&times;</span>
        </div>
        <p style="margin: 20px 0; font-size: 14px;">Deseja realmente usar o item <strong id="confirmItemName" style="color: #7d510f;"></strong>?</p>
        <div style="margin-top: 25px; display: flex; justify-content: center; gap: 10px;">
            <button class="btn btn-default" style="padding: 8px 15px; font-weight: bold; cursor: pointer; background: #4caf50; color: white; border: 1px solid #3d8b40; border-radius: 3px;" onclick="executeUseItem()">Sim, usar item</button>
            <button class="btn btn-cancel" style="padding: 8px 15px; font-weight: bold; cursor: pointer; background: #d3c29d; color: #5b3e10; border: 1px solid #7d510f; border-radius: 3px;" onclick="closeConfirm()">Cancelar</button>
        </div>
    </div>
</div>

<script>
    let selectedInventoryId = null;
    let selectedItemName = "";

    function filterItems(type) {
        window.location.href = 'game.php?village=<?= $village['id'] ?>&screen=profile&mode=inventory&filter=' + type;
    }

    function selectItem(item, imgPath) {
        // Deselect previous
        document.querySelectorAll('.item-cell').forEach(c => c.classList.remove('selected'));

        // Highlight selected
        const cell = document.getElementById('item-cell-' + item.inventory_id);
        if (cell) {
            cell.classList.add('selected');
        }

        selectedInventoryId = item.inventory_id;
        selectedItemName = item.name;

        // Update preview content
        document.getElementById('preview-placeholder').style.display = 'none';
        document.getElementById('preview-box').style.display = 'block';
        document.getElementById('preview-img').src = imgPath;
        document.getElementById('preview-name').textContent = item.name;
        document.getElementById('preview-description').textContent = item.description;

        // The item will automatically apply to the current village or globally
        // No village selector needed
    }

    function useSelectedItem() {
        if (!selectedInventoryId) return;

        // Open confirm modal instead of browser confirm
        document.getElementById('confirmItemName').textContent = selectedItemName;
        document.getElementById('confirmModal').style.display = 'block';
    }

    function closeConfirm() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    function executeUseItem() {
        closeConfirm();

        const btn = document.getElementById('btn-use');
        const originalText = btn.textContent;
        btn.disabled = true;
        btn.textContent = '<?= __('screens.profile.using') ?>';

        const villageId = <?= $village['id'] ?>;

        fetch('game.php?village=<?= $village['id'] ?>&screen=profile&mode=inventory&action=use_item&h=<?= $hkey ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'inventory_id=' + selectedInventoryId + '&village_id=' + villageId
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof UI !== 'undefined' && UI.SuccessMessage) {
                        UI.SuccessMessage(data.message || 'Item ativado com sucesso!');
                    } else {
                        alert('✅ ' + (data.message || 'Item ativado com sucesso!'));
                    }
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof UI !== 'undefined' && UI.ErrorMessage) {
                        UI.ErrorMessage(data.error);
                    } else {
                        alert('❌ ' + data.error);
                    }
                    btn.disabled = false;
                    btn.textContent = originalText;
                }
            })
            .catch(error => {
                if (typeof UI !== 'undefined' && UI.ErrorMessage) {
                    UI.ErrorMessage('Erro ao usar o item.');
                } else {
                    alert('❌ Erro ao usar o item.');
                }
                console.error('Error:', error);
                btn.disabled = false;
                btn.textContent = originalText;
            });
    }

    function showHistory() {
        document.getElementById('historyModal').style.display = 'block';
        loadHistory();
    }

    function closeHistory() {
        document.getElementById('historyModal').style.display = 'none';
    }

    function loadHistory() {
        fetch('game.php?village=<?= $village['id'] ?>&screen=profile&mode=inventory&action=get_history&h=<?= $hkey ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayHistory(data.history);
                } else {
                    document.getElementById('historyList').innerHTML = '<p style="text-align: center; color: red;">Erro ao carregar histórico.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('historyList').innerHTML = '<p style="text-align: center; color: red;">Erro ao carregar histórico.</p>';
            });
    }

    function displayHistory(history) {
        const container = document.getElementById('historyList');

        if (history.length === 0) {
            container.innerHTML = '<p style="text-align: center; color: #7d510f; font-style: italic;">Nenhum registo no histórico.</p>';
            return;
        }

        const changeTypeLabels = {
            'add': 'Recebido',
            'use': 'Usado',
            'expire': 'Expirado',
            'remove': 'Removido'
        };

        let html = '';
        history.forEach(item => {
            const date = new Date(item.created_at);
            const formattedDate = date.toLocaleDateString('pt-PT') + ' ' + date.toLocaleTimeString('pt-PT', {hour: '2-digit', minute:'2-digit'});
            
            const changeLabel = item.change_type_translated || changeTypeLabels[item.change_type] || item.change_type;
            const sourceLabel = item.source_translated || item.source;
            
            html += `
            <div class="history-item">
                <div>
                    <strong>${item.item_name}</strong><br>
                    <small>${changeLabel} (x${item.quantity}) - <?= __('screens.profile.source', 'Origem') ?>: ${sourceLabel}</small>
                </div>
                <div style="text-align: right; color: #555;">
                    <small>${formattedDate}</small>
                </div>
            </div>
        `;
        });

        container.innerHTML = html;
    }

    window.onclick = function (event) {
        const historyModal = document.getElementById('historyModal');
        const confirmModal = document.getElementById('confirmModal');
        if (event.target == historyModal) {
            closeHistory();
        }
        if (event.target == confirmModal) {
            closeConfirm();
        }
    }
</script>