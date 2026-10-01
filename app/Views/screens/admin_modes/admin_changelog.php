<?php
// Changelog JSON Editor view for the Admin panel
// The logic is handled by App\Controllers\Screens\Traits\AdminChangelogMode

// Fetch success or error messages from session if set
$message = $_SESSION['admin_success'] ?? null;
unset($_SESSION['admin_success']);
$error = $_SESSION['admin_error'] ?? null;
unset($_SESSION['admin_error']);

// $changelog, $action_changelog, $entry_id, $edit_entry are already populated by the trait!
?>

<h2><i class="fas fa-history"></i> Editor de Changelog</h2>
<p  style="color: #5c3a1e;">Gerencie as versões e o histórico de atualizações exibido na página de ajuda (`help.php?mode=changelog`). Os dados são armazenados diretamente no arquivo JSON do motor.</p>

<?php if ($message): ?>
    <div class="success p-10"  style="margin: 10px 0; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error p-10"  style="margin: 10px 0; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if ($action_changelog === 'edit' || $action_changelog === 'new'): ?>
    <?php
    $form_title = $action_changelog === 'edit' ? "Editar Versão" : "Adicionar Nova Versão";
    $v_title = $edit_entry ? $edit_entry['version'] : '';
    $v_open = $edit_entry ? $edit_entry['open'] : false;
    
    // Section 0 (PT)
    $sec_title_0 = $edit_entry && isset($edit_entry['sections'][0]) ? $edit_entry['sections'][0]['title'] : 'Updates PT:';
    $sec_items_0 = $edit_entry && isset($edit_entry['sections'][0]) ? implode("\n", $edit_entry['sections'][0]['items']) : '';
    
    // Section 1 (EN)
    $sec_title_1 = $edit_entry && isset($edit_entry['sections'][1]) ? $edit_entry['sections'][1]['title'] : 'Updates EN:';
    $sec_items_1 = $edit_entry && isset($edit_entry['sections'][1]) ? implode("\n", $edit_entry['sections'][1]['items']) : '';
    ?>
    <div class="admin-card">
        <h3><i class="fas fa-edit"></i> <?= $form_title ?></h3>
        <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post">
            <input type="hidden" name="action_changelog" value="save" />
            <?php if ($action_changelog === 'edit'): ?>
                <input type="hidden" name="entry_id" value="<?= $entry_id ?>" />
            <?php endif; ?>
            
            <table class="vis" width="100%">
                <tr>
                    <td width="200"><strong>Título / Versão:</strong></td>
                    <td><input type="text" name="version" value="<?= htmlspecialchars($v_title) ?>" style="width: 80%; padding: 5px;" placeholder="Ex: Versão Alpha 1.8.6 (Atual)/Alpha Version 1.8.6 (Current)" required /></td>
                </tr>
                <tr>
                    <td><strong>Iniciar Aberto (open):</strong></td>
                    <td><input type="checkbox" name="open" value="1" <?= $v_open ? 'checked' : '' ?> /> <small  style="color: #666;">Se marcado, esta versão começará expandida na lista de changelogs.</small></td>
                </tr>
                
                <!-- Portuguese Section -->
                <tr>
                    <td colspan="2"><hr  style="border: 0; border-top: 1px solid #cfaa7d; margin: 15px 0;" /></td>
                </tr>
                <tr>
                    <td><strong>Título Seção (PT):</strong></td>
                    <td><input type="text" name="sec_title_0" value="<?= htmlspecialchars($sec_title_0) ?>" style="width: 40%; padding: 5px;" placeholder="Ex: Updates PT:" /></td>
                </tr>
                <tr>
                    <td><strong>Atualizações (PT):</strong><br/><small  style="color: #666;">(Um item por linha)</small></td>
                    <td><textarea name="sec_items_0" rows="6"  class="p-5" style="width: 80%; font-family: sans-serif;"><?= htmlspecialchars($sec_items_0) ?></textarea></td>
                </tr>
                
                <!-- English Section -->
                <tr>
                    <td colspan="2"><hr  style="border: 0; border-top: 1px solid #cfaa7d; margin: 15px 0;" /></td>
                </tr>
                <tr>
                    <td><strong>Título Seção (EN):</strong></td>
                    <td><input type="text" name="sec_title_1" value="<?= htmlspecialchars($sec_title_1) ?>" style="width: 40%; padding: 5px;" placeholder="Ex: Updates EN:" /></td>
                </tr>
                <tr>
                    <td><strong>Atualizações (EN):</strong><br/><small  style="color: #666;">(Um item por linha)</small></td>
                    <td><textarea name="sec_items_1" rows="6"  class="p-5" style="width: 80%; font-family: sans-serif;"><?= htmlspecialchars($sec_items_1) ?></textarea></td>
                </tr>
            </table>
            
            <div  class="mt-20 text-center">
                <button type="submit" class="btn"  style="background: #4caf50; border-color: #388e3c; color: white; padding: 8px 25px; margin-right: 10px;">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <?php
                $backUrl = preg_replace('/&action_changelog=[^&]*/', '', $_SERVER['REQUEST_URI']);
                $backUrl = preg_replace('/&entry_id=[^&]*/', '', $backUrl);
                ?>
                <a href="<?= htmlspecialchars($backUrl) ?>" class="btn btn-default" style="padding: 8px 25px; text-decoration: none; display: inline-block;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
<?php else: ?>
    <!-- List all entries -->
    <div  class="mb-20">
        <?php
        $newUrl = $_SERVER['REQUEST_URI'] . '&action_changelog=new';
        ?>
        <a href="<?= htmlspecialchars($newUrl) ?>" class="btn" style="background: #2b4a1c; border-color: #1e3e15; color: white; padding: 8px 20px; text-decoration: none; display: inline-block;">
            <i class="fas fa-plus"></i> Adicionar Nova Versão
        </a>
    </div>

    <div class="admin-card">
        <table class="vis" width="100%">
            <thead>
                <tr>
                    <th>Versão</th>
                    <th>Estado</th>
                    <th>Secções Registadas</th>
                    <th width="200">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($changelog)): ?>
                    <tr>
                        <td colspan="4" align="center">Nenhum changelog registado no arquivo json.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($changelog as $id => $entry): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($entry['version']) ?></strong></td>
                            <td>
                                <?php if ($entry['open']): ?>
                                    <span  class="text-green bold">Aberto (open)</span>
                                <?php else: ?>
                                    <span  style="color: #666;">Fechado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $sec_titles = [];
                                if (!empty($entry['sections'])) {
                                    foreach ($entry['sections'] as $sec) {
                                        $sec_titles[] = htmlspecialchars($sec['title']);
                                    }
                                }
                                echo !empty($sec_titles) ? implode(", ", $sec_titles) : 'Nenhuma';
                                ?>
                            </td>
                            <td>
                                <?php
                                $editUrl = $_SERVER['REQUEST_URI'] . '&action_changelog=edit&entry_id=' . $id;
                                ?>
                                <a href="<?= htmlspecialchars($editUrl) ?>" class="btn btn-default" style="padding: 3px 10px; text-decoration: none; display: inline-block; margin-right: 5px;">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                
                                <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post" style="display: inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir esta versão?');">
                                    <input type="hidden" name="action_changelog" value="delete" />
                                    <input type="hidden" name="entry_id" value="<?= $id ?>" />
                                    <button type="submit" class="btn btn-cancel"  style="padding: 3px 10px; margin: 0; background: #d9534f; border-color: #d43f3a; color: white;">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
