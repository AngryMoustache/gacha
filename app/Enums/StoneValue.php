<?php

namespace App\Enums;

enum StoneValue: string
{
    case RED = 'red';
    case BLUE = 'blue';
    case GREEN = 'green';
    case PURPLE = 'purple';
    case YELLOW = 'yellow';

    // case PINK = 'pink';
    // case SLATE = 'slate';
    // case ORANGE = 'orange';
    // case LIME = 'lime';
    // case EMERALD = 'emerald';

    public static function random()
    {
        return collect(self::cases())->random();
    }
}
