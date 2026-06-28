<div class="train-screen">
    <h2><?= __('screens.train.title') ?></h2>

    <div class="resources-display">
        <span><?= __('screens.recruitment.wood') ?>: <?= floor($resources['wood']) ?></span>
        <span><?= __('screens.recruitment.clay') ?>: <?= floor($resources['stone']) ?></span>
        <span><?= __('screens.recruitment.iron') ?>: <?= floor($resources['iron']) ?></span>
        <span><?= __('screens.train.free_population') ?>:
            <?= $resources['max_farm'] - $village['r_bh'] ?>/<?= $resources['max_farm'] ?></span>
    </div>

    <?php foreach ($buildings as $building): ?>
        <?php if ($village[$building] > 0 && !empty($availableUnits[$building])): ?>
            <div class="building-section">
                <h3>
                    <?php
                    $buildingNames = [
                        'barracks' => __('screens.train.barracks'),
                        'stable' => __('screens.train.stable'),
                        'garage' => __('screens.train.garage')
                    ];
                    echo $buildingNames[$building] . ' (' . __('screens.common.level') . ' ' . $village[$building] . ')';
                    ?>
                </h3>

                <?php if (!empty($recruitmentQueues[$building])): ?>
                    <div class="recruitment-queue">
                        <h4><?= __('screens.train.recruitment_queue') ?></h4>
                        <table>
                            <thead>
                                <tr>
                                    <th><?= __('screens.recruitment.unit') ?></th>
                                    <th><?= __('screens.train.quantity') ?></th>
                                    <th><?= __('screens.train.completion') ?></th>
                                    <th><?= __('screens.train.actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recruitmentQueues[$building] as $recruit): ?>
                                    <tr>
                                        <td><?= $availableUnits[$building][$recruit['unit']]['name'] ?? $recruit['unit'] ?></td>
                                        <td><?= $recruit['num_unit'] - floor($recruit['num_finished']) ?></td>
                                        <td><?= date('H:i:s', $recruit['time_finished']) ?></td>
                                        <td>
                                            <a href="?action=cancel_recruit&id=<?= $recruit['id'] ?>" class="cancel-link">
                                                <?= __('screens.train.cancel_refund') ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="recruitment-form">
                    <h4><?= __('screens.common.recruit_units') ?></h4>
                    <form method="post" action="?action=recruit_units">
                        <input type="hidden" name="building" value="<?= $building ?>" />
                        <input type="hidden" name="village" value="<?= $village['id'] ?>" />

                        <table class="units-table">
                            <thead>
                                <tr>
                                    <th><?= __('screens.recruitment.unit') ?></th>
                                    <th><?= __('screens.recruitment.cost') ?></th>
                                    <th><?= __('screens.recruitment.population') ?></th>
                                    <th><?= __('screens.recruitment.time') ?></th>
                                    <th><?= __('screens.train.available') ?></th>
                                    <th><?= __('screens.common.recruit') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($availableUnits[$building] as $unitKey => $unit): ?>
                                    <tr>
                                        <td><strong><?= $unit['name'] ?></strong></td>
                                        <td>
                                            <span class="resource-cost">
                                                🪵 <?= $unit['wood'] ?>
                                                🧱 <?= $unit['stone'] ?>
                                                ⚔️ <?= $unit['iron'] ?>
                                            </span>
                                        </td>
                                        <td><?= $unit['pop'] ?></td>
                                        <td><?= gmdate('H:i:s', $unit['time']) ?></td>
                                        <td><?= $currentUnits[$unitKey] ?? 0 ?></td>
                                        <td>
                                            <input type="number" name="units[<?= $unitKey ?>]" min="0" max="1000" value="0"
                                                class="recruit-input" />
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <button type="submit" class="btn-recruit"><?= __('screens.common.recruit') ?></button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (empty($availableUnits)): ?>
        <p class="no-buildings"><?= __('screens.train.no_military_buildings') ?></p>
    <?php endif; ?>
</div>

<style>
    .train-screen {
        padding: 20px;
    }

    .resources-display {
        display: flex;
        gap: 20px;
        padding: 15px;
        background: #f5f5f5;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .resources-display span {
        font-weight: bold;
    }

    .building-section {
        margin-bottom: 30px;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
    }

    .building-section h3 {
        margin-top: 0;
        color: #333;
    }

    .recruitment-queue {
        margin-bottom: 20px;
        padding: 10px;
        background: #fff3cd;
        border-radius: 5px;
    }

    .recruitment-queue table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .recruitment-queue th,
    .recruitment-queue td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .cancel-link {
        color: #f44336;
        text-decoration: none;
    }

    .units-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .units-table th,
    .units-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .units-table th {
        background: #f5f5f5;
        font-weight: bold;
    }

    .resource-cost {
        font-size: 12px;
    }

    .recruit-input {
        width: 80px;
        padding: 5px;
    }

    .btn-recruit {
        margin-top: 15px;
        padding: 10px 20px;
        background: #4CAF50;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-recruit:hover {
        background: #45a049;
    }

    .no-buildings {
        padding: 20px;
        text-align: center;
        color: #999;
    }
</style>