<table class="content-border w-100" >
    <tr>
        <td>
            <table class="main_layout w-100" >
                <tr>
                    <td>
                        <h2>Simulador</h2>
                        <p>Simule batalhas para prever o resultado.</p>

                        <form action="game.php?village=<?= $village['id'] ?>&screen=place&mode=sim" method="post">
                            <table class="vis" width="100%">
                                <tr>
                                    <th>Unidade</th>
                                    <th>Atacante</th>
                                    <th>Defensor</th>
                                </tr>
                                <?php foreach ($units as $unit): ?>
                                    <tr>
                                        <td><img src="graphic/unit/<?= $unit ?>.png" alt="" />
                                            <?= $units_names[$unit] ?></td>
                                        <td><input type="text" name="att_<?= $unit ?>"
                                                value="<?= $_POST['att_' . $unit] ?? 0 ?>" size="5" /></td>
                                        <td><input type="text" name="def_<?= $unit ?>"
                                                value="<?= $_POST['def_' . $unit] ?? 0 ?>" size="5" /></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Muralha (<?= __('screens.common.level') ?>):</td>
                                    <td></td>
                                    <td><input type="text" name="wall" value="<?= $_POST['wall'] ?? 0 ?>" size="5" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Moral (%)</strong></td>
                                    <td><input type="text" name="moral" value="<?= $_POST['moral'] ?? 100 ?>"
                                            size="5" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Sorte (%)</strong></td>
                                    <td><input type="text" name="luck" value="<?= $_POST['luck'] ?? 0 ?>" size="5" />
                                        (-25 a 25)</td>
                                    <td></td>
                                </tr>
                            </table>

                            <br>
                            <input type="submit" name="simulate" value="Simular Batalha" class="btn" />
                        </form>

                        <?php if (isset($sim_result)): ?>
                            <h3>Resultado</h3>

                            <table class="vis" width="100%">
                                <tr>
                                    <th>Unidade</th>
                                    <th>Atacante (Perdas)</th>
                                    <th>Defensor (Perdas)</th>
                                </tr>
                                <?php foreach ($units as $unit): ?>
                                    <tr>
                                        <td><img src="graphic/unit/<?= $unit ?>.png" alt="" /> <?= $units_names[$unit] ?>
                                        </td>

                                        <!-- Attacker -->
                                        <?php
                                        $att_count = $att_units[$unit] ?? 0;
                                        $att_lost = $sim_result['napastnik_straty'][$unit] ?? 0;
                                        $att_remain = $att_count - $att_lost;
                                        ?>
                                        <td class="<?= $att_lost > 0 ? 'hidden' : '' ?>">
                                            <?= $att_count ?>
                                            <span class="error">(-<?= $att_lost ?>)</span>
                                        </td>

                                        <!-- Defender -->
                                        <?php
                                        $def_count = $def_units[$unit] ?? 0;
                                        $def_lost = $sim_result['obronca_straty'][$unit] ?? 0;
                                        $def_remain = $def_count - $def_lost;
                                        ?>
                                        <td class="<?= $def_lost > 0 ? 'hidden' : '' ?>">
                                            <?= $def_count ?>
                                            <span class="error">(-<?= $def_lost ?>)</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>

                            <p><strong>Vencedor:</strong>
                                <?= $sim_result['wygral'] == 'napastnik' ? 'Atacante' : 'Defensor' ?></p>
                            <?php if (isset($sim_result['nowe_murek'])): ?>
                                <p><strong>Nova Muralha:</strong> <?= $sim_result['nowe_murek'] ?></p>
                            <?php endif; ?>

                        <?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>