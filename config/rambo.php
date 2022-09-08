<?php

use AngryMoustache\Rambo\Resources\Administrator;
use AngryMoustache\Rambo\Resources\Attachment;
use App\Rambo;

return [
    'admin-route' => 'admin',
    'admin-guard' => 'rambo',
    'resources' => [
        Attachment::class,
        Administrator::class,
        Rambo\Currency::class,
        Rambo\BattlePass::class,
        Rambo\Hero::class,
        Rambo\Banner::class,
    ],
    'navigation' => [
        'General' => [
            Administrator::class,
            Attachment::class,
        ],
        Rambo\Currency::class,
        Rambo\BattlePass::class,
        Rambo\Hero::class,
        Rambo\Banner::class,
    ],
    'cropper' => [
        'formats' => [
            \AngryMoustache\Media\Formats\Thumb::class => 'Thumb',
        ],
    ],
];
