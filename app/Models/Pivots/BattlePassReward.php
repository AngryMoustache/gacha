<?php

namespace App\Models\Pivots;

use App\Facades\Auth;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BattlePassReward extends Pivot
{
    public $with = [
        'reward',
    ];

    public function reward()
    {
        return $this->morphTo('reward');
    }

    public function claim()
    {
        match ($this->reward_type) {
            Currency::class => $this->claimCurrency(),
        };
    }

    private function claimCurrency()
    {
        Auth::current()->addCurrency($this->reward->working_title, $this->amount);
    }
}
