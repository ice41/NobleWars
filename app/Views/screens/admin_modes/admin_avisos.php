<?php
$tab = $_GET['tab'] ?? 'announcements';
$is_standalone_admin = (strpos($_SERVER['REQUEST_URI'], 'admin.php') !== false);
$adminBaseUrl = $is_standalone_admin ? 'admin.php?action=dashboard' : 'game.php?village=' . $village['id'] . '&screen=admin';
?>

<h2><i class="fas fa-bullhorn"></i> Comunicações Globais</h2>
<p  style="color: #5c3a1e;">Gira os anúncios internos, as notícias públicas e envie mensagens coletivas para todos os jogadores do servidor.</p>

<!-- Tabs Navigation -->
<div class="diamond-tabs-container mb-20"  style="display: flex; border-bottom: 2px solid #8b5a2b; gap: 5px;">
    <a href="<?= $adminBaseUrl ?>&mode=avisos&tab=announcements" class="diamond-tab <?= $tab === 'announcements' ? 'active' : '' ?>">
        <i class="fas fa-bullhorn"></i> Avisos aos Jogadores
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=avisos&tab=news" class="diamond-tab <?= $tab === 'news' ? 'active' : '' ?>">
        <i class="fas fa-newspaper"></i> Notícias do Servidor
    </a>
    <a href="<?= $adminBaseUrl ?>&mode=avisos&tab=massmail" class="diamond-tab <?= $tab === 'massmail' ? 'active' : '' ?>">
        <i class="fas fa-paper-plane"></i> Mensagem Global (Mass Mail)
    </a>
</div>

<!-- ============================================== -->
<!-- TAB 1: ANNOUNCEMENTS (AVISOS AOS JOGADORES)    -->
<!-- ============================================== -->
<?php if ($tab === 'announcements'): ?>
    <div class="admin-card mb-20" >
        <h3><i class="fas fa-plus-circle"></i> <?= __('admin.news.add_aviso') ?></h3>
        <form action="<?= $adminBaseUrl ?>&mode=avisos&tab=announcements&action=add" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="150"><strong><?= __('admin.news.aviso_title') ?></strong></td>
                    <td>
                        <input type="text" name="title"  class="w-100" style="max-width: 500px;" required>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.news.aviso_msg') ?></strong></td>
                    <td>
                        <?php
                        $textareaId = 'aviso_textarea';
                        $prefix = 'aa_';
                        include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                        ?>
                        <textarea id="aviso_textarea" name="message" rows="5"
                             class="w-100 mt-5" style="max-width: 600px;" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.news.aviso_type') ?></strong></td>
                    <td>
                        <select name="type">
                            <option value="info"><?= __('admin.news.type_info') ?></option>
                            <option value="warning"><?= __('admin.news.type_warning') ?></option>
                            <option value="error"><?= __('admin.news.type_error') ?></option>
                            <option value="success"><?= __('admin.news.type_success') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong><?= __('admin.news.active') ?></strong></td>
                    <td>
                        <input type="checkbox" name="active" value="1" checked> <?= __('admin.news.show_players') ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" class="btn"
                             style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-save"></i>
                            <?= __('admin.news.btn_create_aviso') ?></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="admin-card"  style="margin-bottom: 30px;">
        <h3><i class="fas fa-list"></i> <?= __('admin.news.existing_avisos') ?></h3>
        <table class="vis" width="100%">
            <tr>
                <th width="80"><?= __('admin.news.col_status') ?></th>
                <th width="100"><?= __('admin.news.col_type') ?></th>
                <th width="200"><?= __('admin.news.col_title') ?></th>
                <th><?= __('admin.news.col_msg') ?></th>
                <th width="120"><?= __('admin.news.col_created') ?></th>
                <th width="150"><?= __('admin.news.col_actions') ?></th>
            </tr>
            <?php if (!empty($announcements)): ?>
                <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
                <?php foreach ($announcements as $announcement): ?>
                    <tr>
                        <td align="center">
                            <?php if ($announcement['active']): ?>
                                <span  class="text-green bold"><?= __('admin.news.status_active') ?></span>
                            <?php else: ?>
                                <span  style="color: #999;"><?= __('admin.news.status_inactive') ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $typeLabels = [
                                'info' => '<span  style="color: #0066cc;">ℹ Info</span>',
                                'warning' => '<span  style="color: #ff9900;">⚠ Aviso</span>',
                                'error' => '<span  style="color: #cc0000;">✖ Erro</span>',
                                'success' => '<span  style="color: #009900;">✓ Sucesso</span>'
                            ];
                            echo $typeLabels[$announcement['type']] ?? 'Info';
                            ?>
                        </td>
                        <td><strong><?= htmlspecialchars($announcement['title']) ?></strong></td>
                        <td><?= $bbParser->parse($announcement['message']) ?></td>
                        <td><?= date('d.m.Y H:i', $announcement['created_at']) ?></td>
                        <td align="center">
                            <a href="<?= $adminBaseUrl ?>&mode=avisos&tab=announcements&action=toggle&id=<?= $announcement['id'] ?>" class="btn"
                                style="padding: 2px 8px; font-size: 10px; background: #0066cc;">
                                <i class="fas fa-power-off"></i>
                                <?= $announcement['active'] ? __('admin.news.btn_deactivate') : __('admin.news.btn_activate') ?>
                            </a>
                            <a href="#" onclick="editAviso(<?= $announcement['id'] ?>); return false;" class="btn"
                                style="padding: 2px 8px; font-size: 10px; background: #ff9800; border-color: #e65100; color: white;">
                                <i class="fas fa-edit"></i> <?= __('admin.rules.btn_edit') ?>
                            </a>
                            <a href="<?= $adminBaseUrl ?>&mode=avisos&tab=announcements&action=del&id=<?= $announcement['id'] ?>"
                                onclick="return confirm('<?= addslashes(__('admin.news.del_aviso_confirm')) ?>')" class="btn"
                                style="padding: 2px 8px; font-size: 10px; background: #8b0000;">
                                <i class="fas fa-trash"></i> <?= __('admin.news.btn_del') ?>
                            </a>
                        </td>
                    </tr>
                    <tr id="edit-aviso-<?= $announcement['id'] ?>" style="display:none;">
                        <td colspan="6"  class="p-10" style="background: #fcf8e3; border: 1px solid #fbeed5;">
                            <form action="<?= $adminBaseUrl ?>&mode=avisos&tab=announcements&action=edit&id=<?= $announcement['id'] ?>" method="post">
                                <table class="vis" width="100%">
                                    <tr>
                                        <td width="120"><strong><?= __('admin.news.aviso_title') ?></strong></td>
                                        <td>
                                            <input type="text" name="title" value="<?= htmlspecialchars($announcement['title']) ?>" style="width: 100%; max-width: 500px;" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= __('admin.news.aviso_msg') ?></strong></td>
                                        <td>
                                            <?php
                                            $textareaId = 'edit_aviso_textarea_' . $announcement['id'];
                                            $prefix = 'aa_edit_' . $announcement['id'] . '_';
                                            include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                                            ?>
                                            <textarea id="edit_aviso_textarea_<?= $announcement['id'] ?>" name="message" rows="5"
                                                style="width: 100%; max-width: 600px; margin-top: 5px;" required><?= htmlspecialchars($announcement['message']) ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= __('admin.news.aviso_type') ?></strong></td>
                                        <td>
                                            <select name="type">
                                                <option value="info" <?= $announcement['type'] === 'info' ? 'selected' : '' ?>><?= __('admin.news.type_info') ?></option>
                                                <option value="warning" <?= $announcement['type'] === 'warning' ? 'selected' : '' ?>><?= __('admin.news.type_warning') ?></option>
                                                <option value="error" <?= $announcement['type'] === 'error' ? 'selected' : '' ?>><?= __('admin.news.type_error') ?></option>
                                                <option value="success" <?= $announcement['type'] === 'success' ? 'selected' : '' ?>><?= __('admin.news.type_success') ?></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= __('admin.news.active') ?></strong></td>
                                        <td>
                                            <input type="checkbox" name="active" value="1" <?= $announcement['active'] ? 'checked' : '' ?>> <?= __('admin.news.show_players') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" class="btn"  style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-save"></i> <?= __('admin.rules.btn_save') ?></button>
                                            <button type="button" class="btn"  style="background: #555; border-color: #333; color: white;" onclick="document.getElementById('edit-aviso-<?= $announcement['id'] ?>').style.display='none';"><i class="fas fa-times"></i> <?= __('admin.rules.btn_cancel') ?></button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" align="center"  style="padding: 20px;">
                        <i class="fas fa-info-circle"  style="color: #999; font-size: 24px;"></i><br>
                        <?= __('admin.news.no_avisos') ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <!-- Notes / Documentation -->
    <div class="admin-card">
        <h3><i class="fas fa-info-circle"></i> <?= __('admin.news.note_title') ?></h3>
        <p><?= __('admin.news.note_1') ?></p>
        <p><?= __('admin.news.note_2') ?></p>
    </div>
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 2: SERVER NEWS (NOTÍCIAS DO SERVIDOR)      -->
<!-- ============================================== -->
<?php if ($tab === 'news'): ?>
    <div class="admin-card mb-20" >
        <h3><i class="fas fa-plus-circle"></i> <?= __('admin.news.add_news') ?></h3>
        <form action="<?= $adminBaseUrl ?>&mode=avisos&tab=news&action=add_news" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="150"><strong><?= __('admin.news.news_text') ?></strong></td>
                    <td>
                        <?php
                        $textareaId = 'news_textarea';
                        $prefix = 'an_';
                        include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                        ?>
                        <textarea id="news_textarea" name="text" rows="5"
                             class="w-100 mt-5" style="max-width: 600px;" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" class="btn"
                             style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-save"></i>
                            <?= __('admin.news.btn_publish') ?></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div class="admin-card"  style="margin-bottom: 30px;">
        <h3><i class="fas fa-newspaper"></i> <?= __('admin.news.published_news') ?></h3>
        <table class="vis" width="100%">
            <tr>
                <th width="150"><?= __('admin.news.col_date') ?></th>
                <th><?= __('admin.news.col_text') ?></th>
                <th width="150"><?= __('admin.news.col_actions') ?></th>
            </tr>
            <?php if (!empty($news)): ?>
                <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
                <?php foreach ($news as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['data'] ?? date('d.m.Y H:i')) ?></td>
                        <td><?= $bbParser->parse($item['text'] ?? '') ?></td>
                        <td align="center">
                            <a href="#" onclick="editNews(<?= $item['id'] ?>); return false;" class="btn"
                                style="padding: 2px 8px; font-size: 10px; background: #ff9800; border-color: #e65100; color: white;">
                                <i class="fas fa-edit"></i> <?= __('admin.rules.btn_edit') ?>
                            </a>
                            <a href="<?= $adminBaseUrl ?>&mode=avisos&tab=news&action=del_news&id=<?= $item['id'] ?>"
                                onclick="return confirm('<?= addslashes(__('admin.news.del_confirm')) ?>')" class="btn"
                                style="padding: 2px 8px; font-size: 10px; background: #8b0000;">
                                <i class="fas fa-trash"></i> <?= __('admin.news.btn_del') ?>
                            </a>
                        </td>
                    </tr>
                    <tr id="edit-news-<?= $item['id'] ?>" style="display:none;">
                        <td colspan="3"  class="p-10" style="background: #fcf8e3; border: 1px solid #fbeed5;">
                            <form action="<?= $adminBaseUrl ?>&mode=avisos&tab=news&action=edit_news&id=<?= $item['id'] ?>" method="post">
                                <table class="vis" width="100%">
                                    <tr>
                                        <td width="120"><strong><?= __('admin.news.news_text') ?></strong></td>
                                        <td>
                                            <?php
                                            $textareaId = 'edit_news_textarea_' . $item['id'];
                                            $prefix = 'an_edit_' . $item['id'] . '_';
                                            include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                                            ?>
                                            <textarea id="edit_news_textarea_<?= $item['id'] ?>" name="text" rows="5"
                                                style="width: 100%; max-width: 600px; margin-top: 5px;" required><?= htmlspecialchars($item['text'] ?? '') ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" class="btn"  style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-save"></i> <?= __('admin.rules.btn_save') ?></button>
                                            <button type="button" class="btn"  style="background: #555; border-color: #333; color: white;" onclick="document.getElementById('edit-news-<?= $item['id'] ?>').style.display='none';"><i class="fas fa-times"></i> <?= __('admin.rules.btn_cancel') ?></button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" align="center"  style="padding: 20px;">
                        <i class="fas fa-info-circle"  style="color: #999; font-size: 24px;"></i><br>
                        <?= __('admin.news.no_news') ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
<?php endif; ?>

<!-- ============================================== -->
<!-- TAB 3: MASS MAIL (MENSAGEM GLOBAL)             -->
<!-- ============================================== -->
<?php if ($tab === 'massmail'): ?>
    <?php if (!empty($massmailError)): ?>
        <div class="admin-alert error mb-15" ><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($massmailError) ?></div>
    <?php endif; ?>
    <?php if (!empty($massmailSuccess)): ?>
        <div class="admin-alert success mb-15" ><i class="fas fa-check-circle"></i> <?= htmlspecialchars($massmailSuccess) ?></div>
    <?php endif; ?>

    <div class="admin-card mb-20" >
        <h3><i class="fas fa-envelope-open-text"></i> <?= __('admin.massmail.title') ?></h3>
        <p><?= __('admin.massmail.desc') ?></p>
    </div>

    <div class="admin-card"  style="margin-bottom: 30px;">
        <h3><i class="fas fa-paper-plane"></i> <?= __('admin.massmail.compose') ?></h3>
        <form action="<?= $adminBaseUrl ?>&mode=avisos&tab=massmail" method="post">
            <table class="vis" width="100%">
                <tr>
                    <td width="150"><strong><?= __('admin.massmail.subject') ?></strong></td>
                    <td>
                        <input type="text" name="subject"  class="w-100" style="max-width: 600px;"
                            placeholder="<?= __('admin.massmail.subject_placeholder') ?>" required />
                    </td>
                </tr>
                <tr>
                    <td width="150" valign="top">
                        <strong><?= __('admin.massmail.message') ?></strong><br><small><?= __('admin.massmail.bb_codes') ?></small>
                    </td>
                    <td>
                        <?php
                        $textareaId = 'message';
                        $prefix = 'amm_';
                        include dirname(dirname(__DIR__)) . '/components/bbcode_toolbar.php';
                        ?>

                        <textarea id="message" name="message" rows="10"
                             class="w-100 mt-5" style="max-width: 600px;"
                            placeholder="<?= __('admin.massmail.message_placeholder') ?>" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button type="submit" name="send_massmail" class="btn bold"
                             style="padding: 10px 20px; background: #2e7d32; border-color: #1b5e20; color: white;">
                            <i class="fas fa-paper-plane"></i> <?= __('admin.massmail.send_btn') ?>
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php endif; ?>

<script>
    function editAviso(id) {
        var row = document.getElementById('edit-aviso-' + id);
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    }

    function editNews(id) {
        var row = document.getElementById('edit-news-' + id);
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    }
</script>

<style>
.diamond-tab {
    display: inline-block;
    padding: 10px 20px;
    background: #e6dfd3;
    border: 1px solid #8b5a2b;
    border-bottom: none;
    border-radius: 4px 4px 0 0;
    color: #5c3a1e;
    text-decoration: none;
    font-weight: bold;
    font-size: 12px;
    transition: all 0.2s ease-in-out;
}
.diamond-tab:hover {
    background: #d4cbb8;
}
.diamond-tab.active {
    background: #8b5a2b;
    color: #F4E4BC;
}
</style>