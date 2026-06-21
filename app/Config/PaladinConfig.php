<?php

namespace App\Config;

/**
 * Paladin Configuration
 * Defines paladin item bonuses and inventory coordinates
 * Migrated from original config.php
 */
class PaladinConfig
{
    /**
     * Get paladin item bonuses
     * Format: [attack_bonus, defense_bonus, item_name]
     */
    public static function getBonuses()
    {
        return [
            'unit_spear' => [1.3, 1.2, 'Alabarda de Guan Yu'],
            'unit_sword' => [1.4, 1.3, 'Espada Longa de Ullrich'],
            'unit_axe' => [1.4, 1.3, 'Machado de Guerra de Thogard'],
            'unit_archer' => [1.3, 1.2, 'Arco Longo de Nimrod'],
            'unit_spy' => [1, 1, 'Telescópio de Kalid'],
            'unit_light' => [1.3, 1.2, 'Lança de Miezko'],
            'unit_marcher' => [1.3, 1.2, 'Arco Composto de Nimrod'],
            'unit_heavy' => [1.3, 1.2, 'Estandarte de Baptiste'],
            'unit_ram' => [1, 1, 'Estrela da Manhã de Carol'],
            'unit_catapult' => [1, 10, 'Fogueira de Aletheia'],
            'unit_snob' => [1.3, 1.2, 'Cetro de Vasco'],
        ];
    }

    /**
     * Get item coordinates for inventory image map
     * Format: polygon coordinates for clickable areas
     */
    public static function getItemCoordinates()
    {
        return [
            'unit_spear' => '115,15,110,410,125,410,130,15',
            'unit_sword' => '329,225,365,254,438,233,365,205',
            'unit_axe' => '130,260,190,260,190,330,165,330,165,410,155,410,155,330,130,330',
            'unit_archer' => '196,159,192,409,247,348,248,234',
            'unit_spy' => '407,273,342,293,332,276,390,260',
            'unit_light' => '240,58,249,316,265,316,261,54',
            'unit_marcher' => '495,250,550,212,522,390,486,353',
            'unit_heavy' => '100,15,80,80,70,410,100,410,90,100',
            'unit_ram' => '351,152,450,155,450,214,425,214,417,183,356,173',
            'unit_catapult' => '50,15,30,130,50,130,75,15',
            'unit_snob' => '415,273,391,291,475,305,481,280',
        ];
    }

    /**
     * Get item position coordinates for inventory display
     * Format: [left_px, top_px] for absolute positioning
     */
    public static function getItemPositions()
    {
        return [
            'unit_spear' => [110, 15],
            'unit_sword' => [329, 205],
            'unit_axe' => [130, 260],
            'unit_archer' => [192, 159],
            'unit_spy' => [332, 260],
            'unit_light' => [240, 54],
            'unit_marcher' => [486, 212],
            'unit_heavy' => [70, 15],
            'unit_ram' => [351, 152],
            'unit_catapult' => [30, 15],
            'unit_snob' => [391, 273],
        ];
    }
}
