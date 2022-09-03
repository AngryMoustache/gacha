<?php

use AngryMoustache\Rambo\Resources\Administrator;
use AngryMoustache\Rambo\Resources\Attachment;
use App\Rambo\Currency;

return [
    'admin-route' => 'admin',
    'admin-guard' => 'rambo',
    'resources' => [
        Attachment::class,
        Administrator::class,
        Currency::class,
    ],
    'navigation' => [
        'General' => [
            Administrator::class,
            Attachment::class,
        ],
        Currency::class,
    ],
    'cropper' => [
        'formats' => [
            \AngryMoustache\Media\Formats\Thumb::class => 'Thumb',
        ],
    ],
];
