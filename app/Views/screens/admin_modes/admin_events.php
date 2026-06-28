<?php
/**
 * Admin view for Events management
 */

// Convert current end date string (DD.MM.YYYY HH:MM) to datetime-local format (YYYY-MM-DDTHH:MM)
$currentEnd = $config['event_horde_end'] ?? '';
$dateValue = '';
if (!empty($currentEnd)) {
    $parts = explode(' ', $currentEnd);
    if (count($parts) == 2) {
        $dateParts = explode('.', $parts[0]);
        if (count($dateParts) == 3) {
            $dateValue = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0] . 'T' . $parts[1];
        }
    }
}

$currentSpringEnd = $config['event_spring_end'] ?? '';
$springDateValue = '';
if (!empty($currentSpringEnd)) {
    $parts = explode(' ', $currentSpringEnd);
    if (count($parts) == 2) {
        $dateParts = explode('.', $parts[0]);
        if (count($dateParts) == 3) {
            $springDateValue = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0] . 'T' . $parts[1];
        }
    }
}
?>
<div class="admin-card">
    <div class="admin-card-header">
        <i class="fas fa-calendar-alt"></i> Gestão de Eventos do Mundo
    </div>
    <div class="admin-card-body">
        <?php if (isset($message)): ?>
            <div class="admin-alert success">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="admin-alert error">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <p>Selecione e configure os eventos ativos para este mundo.</p>
    </div>
</div>

<!-- Horde Event Section -->
<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header" style="background: #5c3a1e; color: #fff;">
        <i class="fas fa-skull"></i> Evento: Ataque da Horda
    </div>
    <div class="admin-card-body">
        <form action="<?= $adminBaseUrl ?>&mode=events" method="post">
            <table class="admin-table">
                <tr>
                    <td width="250"><strong>Estado do Evento:</strong></td>
                    <td>
                        <select name="event_horde_active" class="admin-input">
                            <option value="1" <?= ($config['event_horde_active'] ?? false) ? 'selected' : '' ?>>Ativado</option>
                            <option value="0" <?= !($config['event_horde_active'] ?? false) ? 'selected' : '' ?>>Desativado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data e Hora de Fim:</strong><br><small>O evento será encerrado automaticamente nesta data.</small></td>
                    <td>
                        <input type="datetime-local" name="event_horde_end_date" value="<?= $dateValue ?>" class="admin-input">
                    </td>
                </tr>
                <tr>
                    <td><strong>Data de Fim Atual:</strong></td>
                    <td>
                        <span class="admin-badge <?= ($config['event_horde_active'] ?? false) ? 'success' : 'error' ?>">
                            <?= htmlspecialchars($config['event_horde_end'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 20px; text-align: right;">
                <button type="submit" name="save_horde_config" class="admin-btn primary">
                    <i class="fas fa-save"></i> Atualizar Ataque da Horda
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Spring Festival Event Section -->
<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header" style="background: #2d7a2d; color: #fff;">
        <i class="fas fa-seedling"></i> Evento: Festival de Primavera
    </div>
    <div class="admin-card-body">
        <form action="<?= $adminBaseUrl ?>&mode=events" method="post">
            <table class="admin-table">
                <tr>
                    <td width="250"><strong>Estado do Evento:</strong></td>
                    <td>
                        <select name="event_spring_active" class="admin-input">
                            <option value="1" <?= ($config['event_spring_active'] ?? false) ? 'selected' : '' ?>>Ativado</option>
                            <option value="0" <?= !($config['event_spring_active'] ?? false) ? 'selected' : '' ?>>Desativado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data e Hora de Fim:</strong><br><small>O evento será encerrado automaticamente nesta data.</small></td>
                    <td>
                        <input type="datetime-local" name="event_spring_end_date" value="<?= $springDateValue ?>" class="admin-input">
                    </td>
                </tr>
                <tr>
                    <td><strong>Data de Fim Atual:</strong></td>
                    <td>
                        <span class="admin-badge <?= ($config['event_spring_active'] ?? false) ? 'success' : 'error' ?>">
                            <?= htmlspecialchars($config['event_spring_end'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 20px; text-align: right;">
                <button type="submit" name="save_spring_config" class="admin-btn primary">
                    <i class="fas fa-save"></i> Atualizar Festival de Primavera
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Horse Race Event Section -->
<?php
$currentHorseEnd = $config['event_horse_race_end'] ?? '';
$horseDateValue = '';
if (!empty($currentHorseEnd)) {
    $parts = explode(' ', $currentHorseEnd);
    if (count($parts) == 2) {
        $dateParts = explode('.', $parts[0]);
        if (count($dateParts) == 3) {
            $horseDateValue = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0] . 'T' . $parts[1];
        }
    }
}
?>
<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header" style="background: #a36f26; color: #fff;">
        <i class="fas fa-horse"></i> Evento: Corrida de Cavalos
    </div>
    <div class="admin-card-body">
        <form action="<?= $adminBaseUrl ?>&mode=events" method="post">
            <table class="admin-table">
                <tr>
                    <td width="250"><strong>Estado do Evento:</strong></td>
                    <td>
                        <select name="event_horse_race_active" class="admin-input">
                            <option value="1" <?= ($config['event_horse_race_active'] ?? false) ? 'selected' : '' ?>>Ativado</option>
                            <option value="0" <?= !($config['event_horse_race_active'] ?? false) ? 'selected' : '' ?>>Desativado</option>
                        </select>
                        <br><small style="color:red;">Atenção: Ao Desativar, a tabela da corrida e troféus de todos os jogadores será apagada!</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data e Hora de Fim:</strong><br><small>O evento será encerrado automaticamente nesta data.</small></td>
                    <td>
                        <input type="datetime-local" name="event_horse_race_end_date" value="<?= $horseDateValue ?>" class="admin-input">
                    </td>
                </tr>
                <tr>
                    <td><strong>Data de Fim Atual:</strong></td>
                    <td>
                        <span class="admin-badge <?= ($config['event_horse_race_active'] ?? false) ? 'success' : 'error' ?>">
                            <?= htmlspecialchars($config['event_horse_race_end'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Duração de cada Corrida (Horas):</strong><br><small>Tempo para a corrida dar reset (distâncias voltam a 0).</small></td>
                    <td>
                        <input type="number" name="event_horse_race_duration" value="<?= htmlspecialchars($config['event_horse_race_duration'] ?? '12') ?>" min="1" max="168" class="admin-input">
                    </td>
                </tr>
                <tr>
                    <td><strong>Data de Início das Corridas:</strong></td>
                    <td>
                        <span class="admin-badge info" style="background-color: #007bff; color: #fff; padding: 3px 8px; border-radius: 4px;">
                            <?= htmlspecialchars($config['event_horse_race_start'] ?? 'Não definido') ?>
                        </span>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 20px; text-align: right;">
                <button type="submit" name="save_horse_race_config" class="admin-btn primary">
                    <i class="fas fa-save"></i> Atualizar Corrida de Cavalos
                </button>
            </div>
        </form>
    </div>
</div>
