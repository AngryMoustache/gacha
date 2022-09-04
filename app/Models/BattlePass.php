<?php

namespace App\Models;

use AngryMoustache\Media\Models\Attachment;
use App\Enums\CurrencyType;
use App\Facades\Auth;
use App\Models\Pivots\BattlePassReward;
use Illuminate\Database\Eloquent\Model;

class BattlePass extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'attachment_id',
        'start_date',
        'end_date',
    ];

    public $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function rewards()
    {
        return $this->hasMany(BattlePassReward::class);
    }

    public function scopeCurrent($query)
    {
        return $query
            ->whereDate('start_date', '<', today())
            ->whereDate('end_date', '>', today());
    }

    public function hasRewardsAt($level): bool
    {
        return !! $this->getRewardsFor($level)->count();
    }

    public function getRewardsFor($level)
    {
        return $this->rewards->where('level_req', $level);
    }

    public function canClaim($level)
    {
        return Auth::current()
            ->currency(CurrencyType::BATTLE_PASS)
            ->has($level * 1000);
    }
}
