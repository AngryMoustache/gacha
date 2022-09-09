<?php

namespace App\Providers;

use App\Auth;
use App\Models;
use App\Observers;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('custom-auth', function () {
            return new Auth;
        });
    }

    public function boot()
    {
        Models\User::observe(Observers\UserObserver::class);
        Models\Currency::observe(Observers\CurrencyObserver::class);

        Collection::macro('transpose', function () {
            return new static(array_map(
                fn (...$items) => $items,
                ...$this->values()->toArray()
            ));
        });
    }
}
