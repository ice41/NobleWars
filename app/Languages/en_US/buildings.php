<?php

/**
 * English (US) - Buildings Translation
 * 
 * All 17 building names and descriptions
 */
return [
    'main' => [
        'name' => 'Main',
        'description' => 'The Main coordinates all construction activities. The higher the level, the faster you build.',
    ],
    'barracks' => [
        'name' => 'Barracks',
        'description' => 'In the Barracks you can recruit infantry units.',
    ],
    'stable' => [
        'name' => 'Stable',
        'description' => 'In the Stable you can recruit cavalry units.',
    ],
    'garage' => [
        'name' => 'Workshop',
        'description' => 'In the Workshop you can build siege machines.',
    ],
    'church' => [
        'name' => 'Church',
        'description' => 'The Church allows you to recruit monks and influence nearby villages.',
    ],
    'church_f' => [
        'name' => 'First Church',
        'description' => 'The First Church allows you to influence nearby villages. You can only have one First Church on your account.',
    ],
    'snob' => [
        'name' => 'Academy',
        'description' => 'In the Academy you can mint gold coins to recruit nobles.',
    ],
    'smith' => [
        'name' => 'Smithy',
        'description' => 'In the Smithy you can research improvements for your troops.',
    ],
    'place' => [
        'name' => 'Rally Point',
        'description' => 'All troops are at the rally point. Here you can give orders and move troops. The higher the level, the faster troops move.',
    ],
    'statue' => [
        'name' => 'Statue',
        'description' => 'At the Statue you can recruit a paladin.',
    ],
    'market' => [
        'name' => 'Market',
        'description' => 'At the Market you can trade resources with other players.',
    ],
    'wood' => [
        'name' => 'Timber Camp',
        'description' => 'The Timber Camp produces wood. The higher the level, the more wood is produced per hour.',
    ],
    'stone' => [
        'name' => 'Clay Pit',
        'description' => 'The Clay Pit produces clay. The higher the level, the more clay is produced per hour.',
    ],
    'iron' => [
        'name' => 'Iron Mine',
        'description' => 'The Iron Mine produces iron. The higher the level, the more iron is produced per hour.',
    ],
    'farm' => [
        'name' => 'Farm',
        'description' => 'The Farm increases the population available to recruit troops.',
    ],
    'storage' => [
        'name' => 'Warehouse',
        'description' => 'The Warehouse increases the storage capacity for resources.',
    ],
    'hide' => [
        'name' => 'Hiding Place',
        'description' => 'The Hiding Place protects resources from being looted.',
    ],
    'wall' => [
        'name' => 'Wall',
        'description' => 'The Wall increases the basic defense of your village.',
    ],
    'watchtower' => [
        'name' => 'Watchtower',
        'description' => 'The Watchtower detects incoming attacks and provides information about their composition.',
        'faq' => [
            'title' => 'Frequently Asked Questions',
            'q1' => 'How do I know if an attack passes through the radius of my watchtower?',
            'a1' => 'Attacks marked by your watchtowers will have an "eye" icon next to the command. The attack will be marked as soon as it passes through the range of your watchtower.',
            'q2' => 'I just conquered a new village. Will my watchtower identify incoming attacks?',
            'a2' => 'Only attacks sent while you own the village will definitely be identified. Any command sent before you conquered the village will likely not be identified — you can check it by looking for the "eye" icon next to the command.',
            'q3' => "I just built a new watchtower and it's not identifying incoming attacks!",
            'a3' => 'Only attacks sent after you build the watchtower will definitely be identified. Any command sent before you build the watchtower may not be identified. As always, you can check by looking for the "eye" icon next to the command!',
            'q4' => "I'm trying to test the watchtower to see how it works, but my tribe mates' attacks are marked with or without the watchtower and I can't see the \"eye\" before they reach my watchtower's range!",
            'a4' => 'To test your watchtower, temporarily stop sharing commands with the player helping you test it. Sharing commands means all attacks are visible and automatically identified, so there\'s nothing left for the watchtower to identify!',
            'q5' => 'My watchtower only identified the attack when it was about to happen!',
            'a5' => 'Watchtowers will only identify an attack when it enters their range. If the village being attacked is near the edge of your radius, it will only be identified shortly before the attack happens! You may need to upgrade the watchtower or build a new one to expand your coverage!',
        ],
        'related_articles' => [
            'title' => 'Related Articles',
            'main' => 'Main',
            'barracks' => 'Barracks',
            'stable' => 'Stable',
            'garage' => 'Workshop',
            'church' => 'Church',
        ]
    ],
    'popup' => [
        'max_level' => 'Maximum development level:',
        'requirements' => 'Building levels required',
        'level' => 'Level',
        'costs' => 'Costs',
        'pop_and_total' => 'Population / Total',
    ],
];
