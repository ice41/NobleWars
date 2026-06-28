<style>
    .rules-container {
        max-width: 900px;
        margin: 0 auto;
        font-family: Verdana, Arial, sans-serif;
    }

    .rules-header {
        background: linear-gradient(to bottom, #f4e4bc, #d4c4a0);
        border: 2px solid #8b6c42;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .rules-header h1 {
        margin: 0;
        color: #3b260e;
        font-size: 24px;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
    }

    .rule-section {
        background: #f8f4e8;
        border: 2px solid #8b6c42;
        border-radius: 5px;
        margin-bottom: 15px;
        overflow: hidden;
    }

    .rule-section-header {
        background: linear-gradient(to bottom, #d4c4a0, #b4a480);
        padding: 12px 15px;
        border-bottom: 2px solid #8b6c42;
        cursor: pointer;
        user-select: none;
        transition: background 0.2s;
    }

    .rule-section-header:hover {
        background: linear-gradient(to bottom, #c4b490, #a49470);
    }

    .rule-section-header h2 {
        margin: 0;
        color: #3b260e;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .rule-section-header .toggle-icon {
        font-size: 14px;
        transition: transform 0.3s;
    }

    .rule-section-header.collapsed .toggle-icon {
        transform: rotate(-90deg);
    }

    .rule-content {
        padding: 15px 20px;
        color: #3b260e;
        line-height: 1.6;
        font-size: 13px;
        max-height: 1000px;
        overflow: hidden;
        transition: max-height 0.3s ease-out, padding 0.3s ease-out;
    }

    .rule-content.collapsed {
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
    }

    .rule-content p {
        margin: 0 0 10px 0;
        white-space: pre-line;
    }

    .rule-content p:last-child {
        margin-bottom: 0;
    }

    .rules-footer {
        background: #f8f4e8;
        border: 2px solid #8b6c42;
        padding: 15px 20px;
        margin-top: 20px;
        border-radius: 5px;
        text-align: center;
        color: #666;
        font-size: 12px;
    }
</style>

<div class="rules-container">
    <div class="rules-header">
        <h1>📜 <?= __('rules.title', 'Regras Globais do Jogo') ?></h1>
        <p style="margin: 5px 0 0 0; color: #5c3a1e; font-size: 13px;">
            <?= __('rules.header_desc', 'Por favor, leia atentamente as regras e siga-as para manter um ambiente justo e agradável.') ?>
        </p>
    </div>

    <?php if (!empty($rules)): ?>
        <?php foreach ($rules as $rule): ?>
            <div class="rule-section">
                <div class="rule-section-header" onclick="toggleRule(<?= $rule['id'] ?>)">
                    <h2>
                        <span><?= htmlspecialchars($rule['section']) ?> - <?= htmlspecialchars($rule['title']) ?></span>
                        <span class="toggle-icon">▼</span>
                    </h2>
                </div>
                <div class="rule-content" id="rule-content-<?= $rule['id'] ?>">
                    <p><?= nl2br(htmlspecialchars($rule['content'])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="rule-section">
            <div class="rule-content">
                <p style="text-align: center; padding: 20px;">
                    <i class="fas fa-info-circle" style="font-size: 48px; color: #999;"></i><br><br>
                    <?= __('rules.no_rules', 'Nenhuma regra disponível no momento.') ?><br>
                    <?= __('rules.contact_admin', 'Por favor, contate a administração para mais informações.') ?>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <div class="rules-footer">
        <p>
            <strong><?= __('rules.disclaimer', 'Nota:') ?></strong> <?= __('rules.footer_desc', 'Estas regras estão sujeitas a alterações sem aviso prévio.') ?><br>
            <?= __('rules.support_desc', 'Em caso de dúvidas, entre em contato com a equipe de suporte.') ?>
        </p>
    </div>
</div>

<script>
    function toggleRule(id) {
        const content = document.getElementById('rule-content-' + id);
        const header = content.previousElementSibling;

        if (content.classList.contains('collapsed')) {
            content.classList.remove('collapsed');
            header.classList.remove('collapsed');
        } else {
            content.classList.add('collapsed');
            header.classList.add('collapsed');
        }
    }

    // Collapse all sections by default except the first one
    document.addEventListener('DOMContentLoaded', function () {
        const contents = document.querySelectorAll('.rule-content');
        contents.forEach(function (content, index) {
            if (index > 0) { // Keep first section open
                content.classList.add('collapsed');
                content.previousElementSibling.classList.add('collapsed');
            }
        });
    });
</script>