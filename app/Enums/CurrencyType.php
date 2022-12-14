<?php

namespace App\Enums;

enum CurrencyType: string
{
    case STAMINA = 'stamina';
    case BATTLE_PASS = 'battle-pass';
    case GEMS = 'gems';
    case BANNER_TICKETS = 'banner-tickets';

    public static function list()
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'name')
        );
    }
}
