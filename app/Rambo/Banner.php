<?php

namespace App\Rambo;

use AngryMoustache\Rambo\Fields\AttachmentField;
use AngryMoustache\Rambo\Fields\HabtmField;
use AngryMoustache\Rambo\Fields\IDField;
use AngryMoustache\Rambo\Fields\SelectField;
use AngryMoustache\Rambo\Fields\TextField;
use AngryMoustache\Rambo\Resource;
use App\Enums\CurrencyType;
use App\Enums\Rarity;

class Banner extends Resource
{
    public $displayName = 'name';

    public function fields()
    {
        return [
            IDField::make(),

            TextField::make('name')
                ->rules('required'),

            AttachmentField::make('attachment_id', 'Attachment')
                ->rules('required'),

            HabtmField::make('heroes')
                ->resource(Hero::class)
                ->hideFrom('index'),

            TextField::make('pull_cost')
                ->type('number')
                ->sortable()
                ->rules('required'),

            SelectField::make('needed_currency')
                ->nullable()
                ->options(CurrencyType::list())
                ->hideFrom(['show', 'index'])
                ->rules('required'),

            SelectField::make('needed_tickets')
                ->nullable()
                ->options(CurrencyType::list())
                ->hideFrom(['show', 'index']),

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
