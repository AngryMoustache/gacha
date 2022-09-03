<?php

namespace App\Console\Commands;

use App\Enums\CurrencyType;
use App\Models\User;
use Illuminate\Console\Command;

class RegenStamina extends Command
{
    protected $signature = 'regen:stamina';

    protected $description = 'Add one stamina for all users under the limit';

    public function handle()
    {
        User::get()->each(function (User $user) {
            $stamina = $user->currency(CurrencyType::STAMINA);
            if ($stamina->pivot?->amount < $stamina->maximum) {
                $stamina->pivot->amount += config('game.stamina-regen');
                $stamina->pivot->save();
            }
        });
    }
}
