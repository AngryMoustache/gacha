<?php

namespace App\Models;

use AngryMoustache\Media\Models\Attachment;
use App\Enums\CurrencyType;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'name',
        'attachment_id',
        'start_date',
        'end_date',
        'pull_cost',
        'needed_currency',
        'needed_tickets',
    ];

    public $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'needed_currency' => CurrencyType::class,
        'needed_tickets' => CurrencyType::class,
    ];

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function heroes()
    {
        return $this->belongsToMany(Hero::class);
    }

    public function scopeCurrent($query)
    {
        return $query
            ->whereDate('start_date', '<', today())
            ->whereDate('end_date', '>', today());
    }
}
