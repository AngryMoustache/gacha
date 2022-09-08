<?php

namespace App\Models;

use AngryMoustache\Media\Models\Attachment;
use App\Enums\Rarity;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'name',
        'preview_id',
        'picture_id',
        'background_id',
        'rarity',
    ];

    public $casts = [
        'rarity' => Rarity::class,
    ];

    public function preview()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function picture()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function background()
    {
        return $this->belongsTo(Attachment::class);
    }
}
