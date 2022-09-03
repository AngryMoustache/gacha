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
            $user->addCurrency(CurrencyType::STAMINA, config('game.stamina-regen', 1));
        });
    }
}
