<?php

namespace App\Http\Livewire\Pages;

use App\Facades\Auth;
use App\Http\Livewire\Page;
use App\Models\BattlePass as ModelsBattlePass;
use App\Models\Currency;

class BattlePass extends Page
{
    public ModelsBattlePass $battlePass;

    public function mount()
    {
        $this->user = Auth::current();
        $this->battlePass = ModelsBattlePass::current()
            ->with('rewards')
            ->first();
    }

    public function claimReward($level)
    {
        if (! $this->battlePass->canClaim($level)) {
            // TODO: flash warning
            return;
        }

        $this->battlePass
            ->getRewardsFor($level)
            ->each(fn ($reward) => $reward->claim());

        // TODO: flash item get

        $this->battlePass->refresh();
    }
}
