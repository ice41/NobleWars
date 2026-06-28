<h2>Grupos de Aldeias</h2>

<?php if (!empty($error)): ?>
    <div class="error_box" style="padding: 10px; margin-bottom: 15px; background-color: #ffd2d2; border: 1px solid #d29191; color: #a02020; font-weight: bold; border-radius: 4px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success_box" style="padding: 10px; margin-bottom: 15px; background-color: #d2ffd2; border: 1px solid #91d291; color: #20a020; font-weight: bold; border-radius: 4px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($mode === 'edit'): ?>
    <!-- EDIT MODE: Assign villages to a group -->
    <h3>Editar Grupo: <span style="color: #6c4616;"><?= htmlspecialchars($group['name']) ?></span></h3>
    <p><a href="game.php?village=<?= $village['id'] ?>&amp;screen=groups_bar">&laquo; Voltar para a lista de grupos</a></p>

    <form action="game.php?village=<?= $village['id'] ?>&amp;screen=groups_bar&amp;mode=edit&amp;id=<?= $group['id'] ?>&amp;action=save&amp;h=<?= htmlspecialchars($hkey ?? '') ?>" method="post">
        <table class="vis" width="100%">
            <thead>
                <tr>
                    <th width="30">
                        <input type="checkbox" onclick="toggleAllVillages(this);" style="cursor: pointer;" />
                    </th>
                    <th>Aldeia</th>
                    <th>Grupo Atual</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($villages)): ?>
                    <tr>
                        <td colspan="3" align="center">Não possui outras aldeias.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($villages as $v): ?>
                        <?php
                        $is_in_group = ($v['group_id'] == $group['id']);
                        $other_group_name = '';
                        if ($v['group_id'] > 0 && !$is_in_group) {
                            $other_grp = $this->db->fetch(
                                "SELECT name FROM village_groups WHERE id = ?",
                                [$v['group_id']]
                            );
                            if ($other_grp) {
                                $other_group_name = $other_grp['name'];
                            }
                        }
                        ?>
                        <tr>
                            <td align="center">
                                <input type="checkbox" name="villages[]" value="<?= $v['id'] ?>" class="village-checkbox" <?= $is_in_group ? 'checked' : '' ?> style="cursor: pointer;" />
                            </td>
                            <td>
                                <a href="game.php?village=<?= $v['id'] ?>&amp;screen=overview">
                                    <?= htmlspecialchars($v['name']) ?> (<?= $v['x'] ?>|<?= $v['y'] ?>) K<?= $v['continent'] ?>
                                </a>
                            </td>
                            <td>
                                <?php if ($is_in_group): ?>
                                    <span style="color: green; font-weight: bold;">Este Grupo</span>
                                <?php elseif ($v['group_id'] > 0): ?>
                                    <span style="color: #666;"><?= htmlspecialchars($other_group_name) ?></span>
                                <?php else: ?>
                                    <span style="color: #999; font-style: italic;">Nenhum</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <br />
        <input type="submit" value="Guardar Alterações" class="btn" style="padding: 5px 15px; font-weight: bold; cursor: pointer;" />
    </form>

    <script type="text/javascript">
    function toggleAllVillages(master) {
        var checkboxes = document.getElementsByClassName('village-checkbox');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = master.checked;
        }
    }
    </script>

<?php else: ?>
    <!-- LIST MODE: List and Create Groups -->
    <table class="vis" width="100%">
        <thead>
            <tr>
                <th>Nome do Grupo</th>
                <th width="150" style="text-align: center;">Quantidade de Aldeias</th>
                <th width="150" style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($groups)): ?>
                <tr>
                    <td colspan="3" align="center" style="padding: 10px;">Não tem nenhum grupo criado. Crie um grupo abaixo para começar a organizar as suas aldeias!</td>
                </tr>
            <?php else: ?>
                <?php foreach ($groups as $g): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($g['name']) ?></strong>
                        </td>
                        <td align="center">
                            <?= (int)$g['village_count'] ?>
                        </td>
                        <td align="center">
                            <a href="game.php?village=<?= $village['id'] ?>&amp;screen=groups_bar&amp;mode=edit&amp;id=<?= $g['id'] ?>">Editar Aldeias</a>
                            | 
                            <a href="game.php?village=<?= $village['id'] ?>&amp;screen=groups_bar&amp;action=delete&amp;id=<?= $g['id'] ?>&amp;h=<?= htmlspecialchars($hkey ?? '') ?>" onclick="return confirm('Tem a certeza que deseja eliminar este grupo? As aldeias do grupo não serão apagadas, apenas removidas do grupo.');" style="color: #a02020;">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <br /><br />
    <div class="vis" style="padding: 15px; border: 1px solid #dfd1af; background-color: #f7eed3;">
        <h3>Criar Novo Grupo</h3>
        <form action="game.php?village=<?= $village['id'] ?>&amp;screen=groups_bar&amp;action=create&amp;h=<?= htmlspecialchars($hkey ?? '') ?>" method="post">
            <label for="group_name"><strong>Nome do Grupo:</strong></label>
            <input type="text" id="group_name" name="name" maxlength="30" placeholder="ex: ataque, defesa, mista..." required style="padding: 5px; width: 250px; margin-left: 10px;" />
            <input type="submit" value="Criar Grupo" class="btn" style="padding: 5px 15px; margin-left: 10px; font-weight: bold; cursor: pointer;" />
        </form>
    </div>
<?php endif; ?>
