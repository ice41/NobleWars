<?php
// Versions and Updates Help View loaded from JSON
$json_path = __DIR__ . '/../../Config/changelog.json';
$changelog = [];
if (file_exists($json_path)) {
    $changelog = json_decode(file_get_contents($json_path), true);
}
?>
<h1>Versões e Atualizações</h1>
<p>Confira o histórico de atualizações e mudanças no jogo.</p>

<style>
    /* Simple styles for the collapsible sections */
    .version-details {
        margin-bottom: 5px;
        border: 1px solid #7d510f;
        background-color: #f4ead4;
    }

    .version-summary {
        padding: 10px;
        cursor: pointer;
        font-weight: bold;
        background-color: #e2c07c;
        list-style: none;
    }

    .version-summary:hover {
        background-color: #cfaa7d;
    }

    .version-summary::-webkit-details-marker {
        display: none;
    }

    .version-content {
        padding: 15px;
        background-color: #fff5e1;
        border-top: 1px solid #cfaa7d;
    }
</style>

<div class="versions-container">
    <?php if (empty($changelog)): ?>
        <p>Nenhuma atualização registada.</p>
    <?php else: ?>
        <?php foreach ($changelog as $entry): ?>
            <?php if ($entry['version'] === 'Desenvolvimento / Development' || strpos($entry['version'], 'Desenvolvimento') !== false): ?>
                <div class="version-content" style="border: 1px solid #7d510f; background-color: #fff5e1; margin-bottom: 5px; padding: 15px;">
                    <?php if (!empty($entry['sections'])): ?>
                        <?php foreach ($entry['sections'] as $sec): ?>
                            <h4 style="margin-top: 0;"><?= htmlspecialchars($sec['title']) ?></h4>
                            <ul>
                                <?php foreach ($sec['items'] as $item): ?>
                                    <li><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <details class="version-details" <?= !empty($entry['open']) ? 'open' : '' ?>>
                    <summary class="version-summary"><?= htmlspecialchars($entry['version']) ?></summary>
                    <div class="version-content">
                        <?php if (!empty($entry['sections'])): ?>
                            <?php foreach ($entry['sections'] as $sec): ?>
                                <h4><?= htmlspecialchars($sec['title']) ?></h4>
                                <ul>
                                    <?php foreach ($sec['items'] as $item): ?>
                                        <li><?= htmlspecialchars($item) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </details>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>