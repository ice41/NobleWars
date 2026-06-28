<h2><i class="fas fa-newspaper"></i> <?= __('admin.news.title') ?></h2>
<p style="color: #5c3a1e;"><?= __('admin.news.desc') ?></p>

<div class="admin-card">
    <h3><i class="fas fa-plus-circle"></i> <?= __('admin.news.add_news') ?></h3>
    <form action="<?= $adminBaseUrl ?>&mode=news&action=add" method="post">
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
                        style="width: 100%; max-width: 600px; margin-top: 5px;" required></textarea>
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

<div class="admin-card">
    <h3><i class="fas fa-list"></i> <?= __('admin.news.published_news') ?></h3>
    <table class="vis" width="100%">
        <tr>
            <th width="150"><?= __('admin.news.col_date') ?></th>
            <th><?= __('admin.news.col_text') ?></th>
            <th width="100"><?= __('admin.news.col_actions') ?></th>
        </tr>
        <?php if (!empty($news)): ?>
            <?php $bbParser = new \App\Helpers\BBCodeParser(); ?>
            <?php foreach ($news as $item): ?>
                <tr>
                    <td><?= date('d.m.Y H:i', $item['time'] ?? time()) ?></td>
                    <td><?= $bbParser->parse($item['text'] ?? '') ?></td>
                    <td align="center">
                        <a href="#" onclick="editNews(<?= $item['id'] ?>); return false;" class="btn"
                            style="padding: 2px 8px; font-size: 10px; background: #ff9800; border-color: #e65100; color: white;">
                            <i class="fas fa-edit"></i> <?= __('admin.rules.btn_edit') ?>
                        </a>
                        <a href="<?= $adminBaseUrl ?>&mode=news&action=del&id=<?= $item['id'] ?>"
                            onclick="return confirm('<?= addslashes(__('admin.news.del_confirm')) ?>')" class="btn"
                            style="padding: 2px 8px; font-size: 10px; background: #8b0000;">
                            <i class="fas fa-trash"></i> <?= __('admin.news.btn_del') ?>
                        </a>
                    </td>
                </tr>
                <tr id="edit-<?= $item['id'] ?>" style="display:none;">
                    <td colspan="3" style="background: #fcf8e3; padding: 10px; border: 1px solid #fbeed5;">
                        <form action="<?= $adminBaseUrl ?>&mode=news&action=edit&id=<?= $item['id'] ?>" method="post">
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
                                        <button type="submit" class="btn" style="background: #4caf50; border-color: #388e3c; color: white;"><i class="fas fa-save"></i> <?= __('admin.rules.btn_save') ?></button>
                                        <button type="button" class="btn" style="background: #555; border-color: #333; color: white;" onclick="document.getElementById('edit-<?= $item['id'] ?>').style.display='none';"><i class="fas fa-times"></i> <?= __('admin.rules.btn_cancel') ?></button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" align="center" style="padding: 20px;">
                    <i class="fas fa-info-circle" style="color: #999; font-size: 24px;"></i><br>
                    <?= __('admin.news.no_news') ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script>
    function editNews(id) {
        var row = document.getElementById('edit-' + id);
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    }
</script>