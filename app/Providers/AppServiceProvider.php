<?php

namespace App\Providers;

use App\Models;
use App\Observers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Models\User::observe(Observers\UserObserver::class);
        Models\Currency::observe(Observers\CurrencyObserver::class);
    }
}
