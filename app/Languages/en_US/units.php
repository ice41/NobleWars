<?php

/**
 * English (US) - Units Translation
 * 
 * All 13 unit names and descriptions
 */
return [
    'spear' => [
        'name' => 'Spearman',
        'description' => 'The Spearman is the simplest and most basic defensive unit. It is effective against cavalry, but completely useless against axes. In the early game, they are used for farming due to their faster movement speed than the Swordsman and greater looting capacity than the Axe.',
    ],
    'sword' => [
        'name' => 'Swordsman',
        'description' => 'The Swordsman is another defensive unit. They are effective against Axemen, but not very effective against Light Cavalry (one Light Cavalry can kill about five Swordsmen).',
    ],
    'axe' => [
        'name' => 'Axeman',
        'description' => 'The Axeman is a strong offensive unit. Like madmen they attack their opponents\' villages. They crush an army of Spearmen with ease. They are less effective against Swordsmen.',
    ],
    'archer' => [
        'name' => 'Archer',
        'description' => 'The Archer is a defensive unit. It is good against several units, but ineffective against mounted archers.',
    ],
    'monk' => [
        'name' => 'Monk',
        'description' => 'The Monk is a defensive unit. It is the best unit to defend a village - but also expensive.',
    ],
    'spy' => [
        'name' => 'Scout',
        'description' => 'The Scout is a unit recruited in the stables, necessary to spy on other players. In old worlds, researching scout levels affects the amount of information it provides.',
    ],
    'light' => [
        'name' => 'Light Cavalry',
        'description' => 'Light Cavalry (LC) - a unit produced in Stables, very useful for farming as it has the highest loot capacity and is very fast. Light cavalry is an offensive army, works best against Swordsmen and Heavy Cavalry. Works best with mounted archers, creating a fast attack and the strongest in configuration. Its Achilles heel is the fight against Spearmen, who easily deal with them without major losses. Therefore, it is not recommended to build an off with only light cavalry.',
    ],
    'marcher' => [
        'name' => 'Mounted Archer',
        'description' => 'Offensive unit recruited in the stables. Expensive, but worth it if the enemy has many archers. This unit is very versatile, can successfully replace an army of light cavalry and axes. With the maximum number of this unit in the offensive village (approx. 4000) we can destroy defenses composed of 3000 Spearmen and Swordsmen and 8000 Archers, with level 20 wall. The next advantage of such an offensive army is speed, the mounted archer is faster than the axeman.',
    ],
    'heavy' => [
        'name' => 'Heavy Cavalry',
        'description' => 'The Heavy Cavalry is the elite of your troops. It wields a sharp sword and is protected by strong armor. It is a defensive unit (sometimes used as an offensive unit), recruited in the Stable. It is very expensive to produce, but it pays off because it moves twice as fast as the Swordsman. This can make a big difference when you need to send support quickly. Its disadvantage is the high demand for population in the Farm. Heavy Cavalry is slower than Light Cavalry and carries less loot. Weak in defense against cavalry, but very effective against axemen. Recruiting it requires most of the Iron resource, a disadvantage is that it takes a long time to train.',
    ],
    'ram' => [
        'name' => 'Ram',
        'description' => 'A siege unit produced in the Workshop. Useful when attacking an enemy with a high defensive wall, as it damages it before the rest of the troops clash. Rams must be sent along with other offensive troops.',
    ],
    'catapult' => [
        'name' => 'Catapult',
        'description' => 'Catapult - a siege unit produced in the Workshop. It is expensive, but destroys the levels of a target enemy building (except Storage and Church) when attacked. Catapults are less effective at knocking down an opponent\'s Wall than Rams. It\'s not worth using them to destroy a wall, because the catapult destroys the building after the fight and the ram in the process. Catapults are great for destroying a village and slowing down the development of a besieged player. It is better to attack the wall, because you will have to rebuild the wall first, then buildings and troops.',
    ],
    'knight' => [
        'name' => 'Paladin',
        'description' => 'Paladin - appears in the game in 3.0 styles. In addition, in worlds from style 4.0 onwards, it was styled as a hero - it gains experience and, during the fight, can find items that increase its defense or attack statistics. These items are applied to it in a special Pedestal tab - Armory. Appoint a new warrior to the position of knight and name him. In addition, the knight speeds up the army that goes with him to the field for 10 minutes, but only if there is help for another village. Each player can only have one knight.',
    ],
    'snob' => [
        'name' => 'Noble',
        'description' => 'Noble - (commonly known as fatty) - unit produced in the Palace. An attack containing nobles is the only way to capture villages. After attacking a village, it decreases morale (its initial value = 100). The number of points by which it is reduced depends on the world configuration. Normally, the minimum value is 20 and the maximum is 35 (unless the world configuration says otherwise). If it reaches 0 or less, the village is captured. Sending more nobles in a single attack does not decrease morale by more than one noble. It doesn\'t matter who reduces morale - the village will be taken by the player whose attack reduces morale below zero. If you want to dominate another player quickly, a good tactic is to send one noble after another. In most cases, sending four nobles is enough to conquer. The noble also slows down the army that follows it.',
    ],
    'militia' => [
        'name' => 'Militia',
        'description' => 'Citizens who arm themselves to defend the village. Reduces resource production by 50%.',
    ],
    'popup' => [
        'costs' => 'Costs',
        'pop' => 'Population',
        'speed' => 'Speed',
        'loot' => 'Loot capacity',
        'minutes_per_field' => '{minutes} Minutes per field',
        'att' => 'Attack power',
        'def' => 'Defense power',
        'def_cav' => 'Defense against cavalry',
        'def_archer' => 'Defense against archers',
        'requirements' => 'Building levels required to recruit this unit',
        'level' => 'Level',
        'no_requirements' => 'Unit available without requirements.',
    ],
];
