<?php

namespace App\Rambo;

use AngryMoustache\Rambo\Fields\AttachmentField;
use AngryMoustache\Rambo\Fields\IDField;
use AngryMoustache\Rambo\Fields\SelectField;
use AngryMoustache\Rambo\Fields\TextField;
use AngryMoustache\Rambo\Resource;
use App\Enums\Rarity;

class Hero extends Resource
{
    public $displayName = 'name';

    public function fields()
    {
        return [
            IDField::make(),

            TextField::make('name')
                ->rules('required'),

            AttachmentField::make('preview_id', 'Preview')
                ->rules('required'),

            AttachmentField::make('picture_id', 'Picture')
                ->hideFrom('index')
                ->rules('required'),

            AttachmentField::make('background_id', 'Background')
                ->hideFrom('index')
                ->rules('required'),

            SelectField::make('rarity')
                ->nullable()
                ->options(Rarity::list())
                ->hideFrom(['show', 'index'])
                ->rules('required'),
        ];
    }
}
