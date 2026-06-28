<?php
// Support Screen View
?>

<?php if ($mode == 'list'): ?>
    <h2>Suporte</h2>
    <p>
        <a class="btn" href="<?= $this->getUrl(['mode' => 'new', 'action' => 'create']) ?>">
            Abrir novo ticket
        </a>
    </p>

    <table class="vis" width="100%">
        <tr>
            <th>Assunto</th>
            <th>Data</th>
            <th>Status</th>
            <th>Última resposta</th>
        </tr>
        <?php if (empty($tickets)): ?>
            <tr>
                <td colspan="4" align="center">Nenhum ticket de suporte encontrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td>
                        <a href="<?= $this->getUrl(['mode' => 'view', 'id' => $ticket['id']]) ?>">
                            <?php
                            $icon = 'thread_read.png';
                            if ($ticket['status'] == 'closed')
                                $icon = 'thread_close.png'; // Closed
                            elseif (isset($ticket['new']) && $ticket['new'] == '1')
                                $icon = 'thread_unread.png'; // New reply
                            ?>
                            <img src="graphic/forum/<?= $icon ?>" alt="" />
                            <?= htmlspecialchars(urldecode($ticket['subject'])) ?>
                        </a>
                    </td>
                    <td><?= $ticket['date'] ?></td>
                    <td>
                        <?php
                        if ($ticket['status'] == 'closed')
                            echo 'Fechado';
                        else
                            echo 'Aberto';
                        ?>
                    </td>
                    <td>
                        <?php
                        // Logic for last reply could go here if available
                        echo $ticket['date'];
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

<?php elseif ($mode == 'new'): ?>
    <h2>Abrir novo ticket</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post"
        action="<?= $this->getUrl(['mode' => 'new', 'action' => 'create', 'h' => $this->session['hkey']]) ?>">
        <table class="vis" width="100%">
            <tr>
                <th colspan="2">Escreva um novo</th>
            </tr>
            <tr>
                <td width="100"><b>Assunto:</b></td>
                <td><input type="text" name="subject" size="40" maxlength="50" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php 
                    $textareaId = 'ticket_message';
                    include __DIR__ . '/../components/bbcode_toolbar.php'; 
                    ?>
                    <textarea id="ticket_message" name="message" cols="60" rows="10" style="width:100%; margin-top:5px;"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Enviar Ticket" />
                </td>
            </tr>
        </table>
    </form>

<?php elseif ($mode == 'view'): ?>
    <h2><?= htmlspecialchars(urldecode($ticket['subject'])) ?></h2>

    <table class="vis" width="100%">
        <?php
        // Merge original ticket as first post
        $thread = [];
        $thread[] = [
            'username' => $ticket['username'],
            'date' => $ticket['date'],
            'message' => $ticket['message']
        ];

        // Add responses
        foreach ($responses as $resp) {
            $thread[] = [
                'username' => $resp['username'],
                'date' => $resp['date'],
                'message' => $resp['message']
            ];
        }

        // Render thread
        foreach ($thread as $post):
            ?>
            <tr>
                <th colspan="2">
                    <?= htmlspecialchars($post['username']) ?> - <?= $post['date'] ?>
                </th>
            </tr>
            <tr>
                <td colspan="2" style="padding: 10px;">
                    <?= \App\Helpers\BBCodeHelper::process(urldecode($post['message']), $user['id'] ?? 0) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($ticket['status'] != 'closed'): ?>
        <br />
        <h3>Responder</h3>
        <form method="post"
            action="<?= $this->getUrl(['mode' => 'view', 'action' => 'reply', 'id' => $ticket['id'], 'h' => $this->session['hkey']]) ?>">
            <table class="vis" width="100%">
                <tr>
                    <td colspan="2">
                        <?php 
                        $textareaId = 'reply_message';
                        $prefix = 'reply_';
                        include __DIR__ . '/../components/bbcode_toolbar.php'; 
                        ?>
                        <textarea id="reply_message" name="message" cols="60" rows="10" style="width:100%; margin-top:5px;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Responder" />
                    </td>
                </tr>
            </table>
        </form>
    <?php else: ?>
        <br />
        <h3>Tópico fechado!</h3>
    <?php endif; ?>

<?php endif; ?>