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
        'maximum',
    ];

    public $casts = [
        'working_title' => CurrencyType::class,
    ];

    public function icon()
    {
        return $this->belongsTo(Attachment::class);
    }
}
