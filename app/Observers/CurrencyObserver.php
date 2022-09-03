<?php

namespace App\Observers;

use App\Models\Currency;
use App\Models\User;

class CurrencyObserver
{
    public function created(Currency $currency)
    {
        $users = User::withoutGlobalScopes()->get();
        $users->each(function (user $user) use ($currency) {
            $user->currencies()->attach([$currency->id => [
                'amount' => 0,
            ]]);
        });
    }
}
