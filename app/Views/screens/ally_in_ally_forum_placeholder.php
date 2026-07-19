<!-- Forum Action Placeholder - Under Development -->

<h3><?= __('screens.ally_forum.tribe_forum') ?: 'Fórum da Tribo' ?></h3>

<div class="info_box text-center"
     style="padding: 30px; margin: 20px 0; background-color: #fff8e0; border: 2px solid #f0d080;">
    <h2  class="mb-15" style="color: #804000;">🚧 <?= __('screens.ally_forum.feature_under_development') ?: 'Funcionalidade em Desenvolvimento' ?></h2>

    <?php if ($action === 'new_topic'): ?>
        <p  class="mb-20" style="font-size: 14px;">
            <?= __('screens.ally_forum.new_topic_dev_msg') ?: 'A funcionalidade de <strong>criar novos tópicos</strong> está atualmente em desenvolvimento.' ?>
        </p>
    <?php elseif ($action === 'new_poll'): ?>
        <p  class="mb-20" style="font-size: 14px;">
            <?= __('screens.ally_forum.new_poll_dev_msg') ?: 'A funcionalidade de <strong>criar sondagens</strong> está atualmente em desenvolvimento.' ?>
        </p>
    <?php else: ?>
        <p  class="mb-20" style="font-size: 14px;">
            <?= __('screens.ally_forum.search_dev_msg') ?: 'A funcionalidade de <strong>pesquisa no fórum</strong> está atualmente em desenvolvimento.' ?>
        </p>
    <?php endif; ?>
    <p  style="color: #666; font-size: 13px; margin-bottom: 25px;">
        <em><?= __('screens.ally_forum.feature_soon_msg') ?: 'Esta funcionalidade será implementada em breve.' ?></em>
    </p>

    <a href="game.php?village=<?= $village['id'] ?>&screen=ally&mode=forum" class="btn"
        style="display: inline-block; padding: 8px 20px; background-color: #f0e0c0; border: 1px solid #c0a070; text-decoration: none; color: #000; border-radius: 3px;">
        « <?= __('screens.ally_forum.back_to_forum') ?: 'Voltar ao fórum' ?>
    </a>
</div>

<br>

<table class="vis" width="100%">
    <tr>
        <td  class="text-center" style="padding: 15px; color: #666;">
            <em><?= __('screens.ally_forum.future_update_msg') ?: 'O sistema de fórum completo (tópicos, respostas, sondagens e pesquisa) será implementado numa atualização futura.' ?></em>
        </td>
    </tr>
</table>