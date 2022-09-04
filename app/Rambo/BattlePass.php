<?php

namespace App\Rambo;

use AngryMoustache\Rambo\Fields\AttachmentField;
use AngryMoustache\Rambo\Fields\IDField;
use AngryMoustache\Rambo\Fields\SlugField;
use AngryMoustache\Rambo\Fields\TextField;
use AngryMoustache\Rambo\Resource;

class BattlePass extends Resource
{
    public $displayName = 'name';

    public function fields()
    {
        return [
            IDField::make(),

            TextField::make('name')
                ->rules('required'),

            SlugField::make('slug')
                ->hideFrom(['index']),

            AttachmentField::make('attachment_id', 'Main Attachment')
                ->rules('required'),

            TextField::make('start_date')
                ->type('date')
                ->sortable()
                ->rules('required'),

            TextField::make('end_date')
                ->type('date')
                ->sortable()
                ->rules('required'),
        ];
    }
}
