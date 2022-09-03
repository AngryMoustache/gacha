<?php

namespace App\Models;

use AngryMoustache\Media\Models\Attachment;
use App\Enums\CurrencyType;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'working_title',
        'description',
        'icon_id',
        'shown_when_empty',
        'maximum',
    ];

    public $casts = [
        'working_title' => CurrencyType::class,
        'shown_when_empty' => 'boolean',
    ];

    public function icon()
    {
        return $this->belongsTo(Attachment::class);
    }
}
