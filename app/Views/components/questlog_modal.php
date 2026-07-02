<!-- Questlog Modal -->
<div id="questlogModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 10000; align-items: center; justify-content: center;">
    <div
        style="position: relative; width: 820px; max-height: 90vh; margin: 20px auto; background: url('graphic/new/popup/content_background.webp'); background-size: cover; border-image: url('graphic/new/popup/border.webp') 30 round; border-width: 30px; border-style: solid; box-shadow: 0 4px 30px rgba(0,0,0,0.8); overflow: hidden;">

        <!-- Close Button -->
        <button onclick="closeQuestlogModal()"
            style="position: absolute; top: 5px; right: 5px; background: url('graphic/index/login_close.png') no-repeat center; background-size: contain; border: none; width: 24px; height: 24px; cursor: pointer; opacity: 0.9; z-index: 10001;"
            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'"></button>

        <!-- Header Image -->
        <div
            style="width: 100%; height: 100px; background: url('graphic/quests_new/questline_1.png') center/cover; border-bottom: 3px solid #5c3c1f;">
        </div>

        <!-- Tabs -->
        <div
            style="display: flex; background: linear-gradient(180deg, #8B4513 0%, #6b3410 100%); border-bottom: 2px solid #3c2610; padding: 5px 10px;">
            <div class="quest-tab active" onclick="switchQuestTab('main')"
                style="flex: 1; text-align: center; padding: 8px 15px; margin: 0 3px; background: linear-gradient(180deg, #a0522d 0%, #8B4513 100%); color: white; font-weight: bold; font-size: 13px; cursor: pointer; border-radius: 3px 3px 0 0; border: 1px solid #5c3c1f;">
                <?= __('quests.tabs.main_quests') ?>
            </div>
            <div class="quest-tab" onclick="switchQuestTab('tribe')"
                style="flex: 1; text-align: center; padding: 8px 15px; margin: 0 3px; background: linear-gradient(180deg, #7a5c3f 0%, #5c3c1f 100%); color: #ddd; font-weight: bold; font-size: 13px; cursor: pointer; border-radius: 3px 3px 0 0; border: 1px solid #3c2610;">
                <?= __('quests.tabs.tribe_quest') ?>
            </div>
            <div class="quest-tab" onclick="switchQuestTab('rewards')"
                style="flex: 1; text-align: center; padding: 8px 15px; margin: 0 3px; background: linear-gradient(180deg, #7a5c3f 0%, #5c3c1f 100%); color: #ddd; font-weight: bold; font-size: 13px; cursor: pointer; border-radius: 3px 3px 0 0; border: 1px solid #3c2610;">
                <?= __('quests.tabs.rewards') ?> (2)
            </div>
        </div>

        <!-- Content Area -->
        <div style="display: flex; min-height: 450px; max-height: 500px; overflow: hidden;">

            <!-- Left Sidebar - Quest Categories -->
            <div
                style="width: 250px; background: rgba(0,0,0,0.3); border-right: 2px solid #5c3c1f; overflow-y: auto; padding: 10px;">

                <!-- Construction -->
                <div class="quest-category active" onclick="selectQuestCategory('construction')"
                    style="margin-bottom: 5px; cursor: pointer; border: 2px solid #8B4513; background: linear-gradient(180deg, #f4e4bc 0%, #e9d0a9 100%); border-radius: 3px; overflow: hidden;">
                    <div
                        style="position: relative; height: 80px; background: url('graphic/quests_new/questline_1.png') center/cover;">
                        <div
                            style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: 5px; color: white; font-weight: bold; font-size: 12px; text-align: center;">
                            <?= __('quests.categories.construction') ?>
                        </div>
                    </div>
                    <div
                        style="padding: 8px; background: #f4e4bc; text-align: center; font-size: 11px; color: #5c3c1f;">
                        <?= __('quests.questlines.path_of_conquest_1') ?>
                    </div>
                </div>

                <!-- Looting -->
                <div class="quest-category" onclick="selectQuestCategory('looting')"
                    style="margin-bottom: 5px; cursor: pointer; border: 2px solid #666; background: linear-gradient(180deg, #ddd 0%, #ccc 100%); border-radius: 3px; overflow: hidden; opacity: 0.7;">
                    <div
                        style="position: relative; height: 80px; background: url('graphic/quests_new/questline_2.png') center/cover;">
                        <div
                            style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: 5px; color: white; font-weight: bold; font-size: 12px; text-align: center;">
                            <?= __('quests.categories.looting') ?>
                        </div>
                    </div>
                    <div style="padding: 8px; background: #ddd; text-align: center; font-size: 11px; color: #666;">
                        <?= __('quests.questlines.victory') ?>
                    </div>
                </div>

                <!-- Diplomacy -->
                <div class="quest-category" onclick="selectQuestCategory('diplomacy')"
                    style="margin-bottom: 5px; cursor: pointer; border: 2px solid #666; background: linear-gradient(180deg, #ddd 0%, #ccc 100%); border-radius: 3px; overflow: hidden; opacity: 0.7;">
                    <div
                        style="position: relative; height: 80px; background: url('graphic/quests_new/questline_5.png') center/cover;">
                        <div
                            style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: 5px; color: white; font-weight: bold; font-size: 12px; text-align: center;">
                            <?= __('quests.categories.diplomacy') ?>
                        </div>
                    </div>
                    <div style="padding: 8px; background: #ddd; text-align: center; font-size: 11px; color: #666;">
                        <?= __('quests.questlines.make_contacts') ?>
                    </div>
                </div>

                <!-- Premium -->
                <div class="quest-category" onclick="selectQuestCategory('premium')"
                    style="margin-bottom: 5px; cursor: pointer; border: 2px solid #666; background: linear-gradient(180deg, #ddd 0%, #ccc 100%); border-radius: 3px; overflow: hidden; opacity: 0.7;">
                    <div
                        style="position: relative; height: 80px; background: url('graphic/quests_new/questline_8.png') center/cover;">
                        <div
                            style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: 5px; color: white; font-weight: bold; font-size: 12px; text-align: center;">
                            <?= __('quests.categories.premium') ?>
                        </div>
                    </div>
                    <div style="padding: 8px; background: #ddd; text-align: center; font-size: 11px; color: #666;">
                        <?= __('quests.questlines.inventory') ?>
                    </div>
                </div>

                <!-- Recruitment -->
                <div class="quest-category" onclick="selectQuestCategory('recruitment')"
                    style="margin-bottom: 5px; cursor: pointer; border: 2px solid #666; background: linear-gradient(180deg, #ddd 0%, #ccc 100%); border-radius: 3px; overflow: hidden; opacity: 0.7;">
                    <div
                        style="position: relative; height: 80px; background: url('graphic/quests_new/questline_9.png') center/cover;">
                        <div
                            style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: 5px; color: white; font-weight: bold; font-size: 12px; text-align: center;">
                            <?= __('quests.categories.recruitment') ?>
                        </div>
                    </div>
                    <div style="padding: 8px; background: #ddd; text-align: center; font-size: 11px; color: #666;">
                        <?= __('quests.questlines.build_army_5') ?>
                    </div>
                </div>

                <!-- Relics -->
                <div class="quest-category" onclick="selectQuestCategory('relics')"
                    style="margin-bottom: 5px; cursor: pointer; border: 2px solid #666; background: linear-gradient(180deg, #ddd 0%, #ccc 100%); border-radius: 3px; overflow: hidden; opacity: 0.7;">
                    <div
                        style="position: relative; height: 80px; background: url('graphic/quests_new/questline_11.png') center/cover;">
                        <div
                            style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); padding: 5px; color: white; font-weight: bold; font-size: 12px; text-align: center;">
                            <?= __('quests.categories.relics') ?>
                        </div>
                    </div>
                    <div style="padding: 8px; background: #ddd; text-align: center; font-size: 11px; color: #666;">
                        <?= __('quests.questlines.find_relic') ?>
                    </div>
                </div>

            </div>

            <!-- Right Content - Quest Details -->
            <div id="questContent" style="flex: 1; padding: 20px; overflow-y: auto; background: rgba(244,228,188,0.3);">
                <!-- Content will be loaded here dynamically -->
                <?php include __DIR__ . '/components/questlog_content.php'; ?>
            </div>
        </div>

    </div>
</div>