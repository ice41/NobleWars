<div class="rules-container">
    <div class="rules-header">
        <h1>📜 <?= __('rules.title', 'Regras Globais do Jogo') ?></h1>
        <p class="rules-header-desc">
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
                <p class="text-center rules-empty-p">
                    <i class="fas fa-info-circle rules-empty-icon"></i><br><br>
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