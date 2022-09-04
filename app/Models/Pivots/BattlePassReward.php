<?php

namespace App\Models\Pivots;

use App\Facades\Auth;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class BattlePassReward extends Pivot
{
    public $with = [
        'reward',
        'claims',
    ];

    public function reward()
    {
        return $this->morphTo('reward');
    }

    public function claims()
    {
        return $this->belongsToMany(User::class, null, 'battle_pass_reward_id');
    }

    public function claim()
    {
        match ($this->reward_type) {
            Currency::class => $this->claimCurrency(),
        };

        DB::table('battle_pass_reward_user')->insert([
            'battle_pass_reward_id' => $this->id,
            'user_id' => Auth::current()->id,
        ]);
    }

    private function claimCurrency()
    {
        Auth::current()->addCurrency($this->reward->working_title, $this->amount);
    }
}
