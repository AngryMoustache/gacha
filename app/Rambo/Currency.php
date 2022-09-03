<?php

namespace App\Rambo;

use AngryMoustache\Rambo\Fields\AttachmentField;
use AngryMoustache\Rambo\Fields\BooleanField;
use AngryMoustache\Rambo\Fields\EditorField;
use AngryMoustache\Rambo\Fields\IDField;
use AngryMoustache\Rambo\Fields\SelectField;
use AngryMoustache\Rambo\Fields\TextField;
use AngryMoustache\Rambo\Resource;
use App\Enums\CurrencyType;

class Currency extends Resource
{
    public $displayName = 'name';

    public function fields()
    {
        return [
            IDField::make(),

            TextField::make('name')
                ->rules('required'),

            SelectField::make('working_title', 'Working title')
                ->options(CurrencyType::list())
                ->hideFrom(['edit', 'show', 'index'])
                ->rules('required'),

            BooleanField::make('shown_when_empty')
                ->toggleable(),

            TextField::make('maximum')
                ->type('number'),

            AttachmentField::make('icon_id', 'Icon')
                ->rules('required'),

            EditorField::make('description')
                ->hideFrom(['index']),
        ];
    }
}
