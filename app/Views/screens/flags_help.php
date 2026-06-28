<div class="flags-help-container">
    <?php foreach ($flag_types as $type => $info): ?>
        <div class="flag-help-item">
            <div class="flag-help-icon">
                <img src="/graphic/flags/medium/<?= $info['icon'] ?>_1.png" alt="<?= $info['name'] ?>"
                    onerror="this.src='/graphic/flags/flag_disabled.png'">
            </div>
            <div class="flag-help-content">
                <h4><?= $info['name'] ?></h4>
                <p><?= $info['description'] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>