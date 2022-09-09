<?php

namespace App\Enums;

enum Stone: string
{
    case RED = 'red';
    case BLUE = 'blue';
    case GREEN = 'green';
    case PURPLE = 'purple';
    case YELLOW = 'yellow';

    public static function random()
    {
        return collect(self::cases())->random();
    }
}
