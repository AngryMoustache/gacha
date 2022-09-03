<?php

namespace App\Observers;

use App\Models\Currency;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        $currencies = Currency::withoutGlobalScopes()->get();
        $currencies->each(function (Currency $currency) use ($user) {
            $user->currencies()->attach([$currency->id => [
                'amount' => 0,
            ]]);
        });
    }
}
