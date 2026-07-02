<!-- Quest Header -->
<div
    style="display: flex; align-items: center; margin-bottom: 20px; padding: 15px; background: linear-gradient(180deg, #8B4513 0%, #6b3410 100%); border-radius: 5px; border: 2px solid #5c3c1f;">
    <div style="flex: 1;">
        <h3 style="margin: 0; color: white; font-size: 18px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
            <?= __('quests.categories.construction') ?>
        </h3>
        <p style="margin: 5px 0 0 0; color: #f4e4bc; font-size: 13px;">
            <?= __('quests.questlines.path_of_conquest_1') ?>
        </p>
    </div>
    <img src="graphic/quests_new/questline_1.png"
        style="width: 60px; height: 60px; border-radius: 50%; border: 3px solid #f4e4bc;" />
</div>

<!-- Quest Description -->
<div
    style="padding: 15px; background: rgba(255,255,255,0.6); border-radius: 5px; margin-bottom: 15px; border: 1px solid #d4a574;">
    <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #3c2610; font-style: italic;">
        Todos os edifícios têm um nível máximo - edifícios de recursos como o Timber Camp têm alguns dos mais altos,
        enquanto outros edifícios podem ter um nível máximo muito mais baixo. Vamos continuar a expandir nossos
        edifícios de recursos!
    </p>
</div>

<!-- Quest Tasks -->
<div style="margin-bottom: 15px;">
    <!-- Task 1 -->
    <div
        style="display: flex; align-items: center; padding: 12px; background: linear-gradient(180deg, #f4e4bc 0%, #e9d0a9 100%); border-radius: 5px; margin-bottom: 8px; border: 2px solid #8B4513;">
        <div style="flex: 1;">
            <strong style="color: #3c2610; font-size: 14px;">Melhore Bosque</strong>
            <p style="margin: 3px 0 0 0; font-size: 12px; color: #5c3c1f;">Expanda Bosque para o nível 20.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div
                style="position: relative; width: 150px; height: 20px; background: #ddd; border-radius: 10px; overflow: hidden; border: 1px solid #999;">
                <div
                    style="position: absolute; left: 0; top: 0; bottom: 0; width: 80%; background: linear-gradient(180deg, #8B0000 0%, #5c0000 100%);">
                </div>
                <div
                    style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 11px; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
                    16/20
                </div>
            </div>
            <img src="graphic/buildings/wood.png" style="width: 30px; height: 30px;" />
        </div>
    </div>

    <!-- Task 2 -->
    <div
        style="display: flex; align-items: center; padding: 12px; background: linear-gradient(180deg, #f4e4bc 0%, #e9d0a9 100%); border-radius: 5px; margin-bottom: 8px; border: 2px solid #8B4513;">
        <div style="flex: 1;">
            <strong style="color: #3c2610; font-size: 14px;">Melhore Poço de Argila</strong>
            <p style="margin: 3px 0 0 0; font-size: 12px; color: #5c3c1f;">Expanda Poço de Argila para o nível 20.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div
                style="position: relative; width: 150px; height: 20px; background: #ddd; border-radius: 10px; overflow: hidden; border: 1px solid #999;">
                <div
                    style="position: absolute; left: 0; top: 0; bottom: 0; width: 80%; background: linear-gradient(180deg, #8B0000 0%, #5c0000 100%);">
                </div>
                <div
                    style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 11px; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
                    16/20
                </div>
            </div>
            <img src="graphic/buildings/stone.png" style="width: 30px; height: 30px;" />
        </div>
    </div>

    <!-- Task 3 -->
    <div
        style="display: flex; align-items: center; padding: 12px; background: linear-gradient(180deg, #f4e4bc 0%, #e9d0a9 100%); border-radius: 5px; border: 2px solid #8B4513;">
        <div style="flex: 1;">
            <strong style="color: #3c2610; font-size: 14px;">Melhore Mina de Ferro</strong>
            <p style="margin: 3px 0 0 0; font-size: 12px; color: #5c3c1f;">Expanda Mina de Ferro para o nível 20.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div
                style="position: relative; width: 150px; height: 20px; background: #ddd; border-radius: 10px; overflow: hidden; border: 1px solid #999;">
                <div
                    style="position: absolute; left: 0; top: 0; bottom: 0; width: 80%; background: linear-gradient(180deg, #8B0000 0%, #5c0000 100%);">
                </div>
                <div
                    style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 11px; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
                    16/20
                </div>
            </div>
            <img src="graphic/buildings/iron.png" style="width: 30px; height: 30px;" />
        </div>
    </div>
</div>

<!-- Knight Image -->
<div style="position: absolute; bottom: 20px; left: 20px; pointer-events: none;">
    <img src="graphic/paladin.png" style="height: 200px; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.5));" />
</div>