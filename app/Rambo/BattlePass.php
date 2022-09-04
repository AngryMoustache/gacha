<?php

namespace App\Rambo;

use AngryMoustache\Rambo\Fields\AttachmentField;
use AngryMoustache\Rambo\Fields\IDField;
use AngryMoustache\Rambo\Fields\SelectField;
use AngryMoustache\Rambo\Fields\SlugField;
use AngryMoustache\Rambo\Fields\TextField;
use AngryMoustache\Rambo\Resource;
use App\Enums\CurrencyType;

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

            SelectField::make('needed_currency')
                ->nullable()
                ->options(CurrencyType::list())
                ->hideFrom(['show', 'index'])
                ->rules('required'),

            TextField::make('levels_amount')
                ->rules('required'),

            TextField::make('per_level_requirement')
                ->rules('required'),

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
