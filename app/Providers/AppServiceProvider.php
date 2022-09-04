<?php

namespace App\Providers;

use App\Auth;
use App\Facades\Auth as FacadesAuth;
use App\Models;
use App\Observers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->alias(Auth::class, 'custom-auth');
        $this->app->bind(Auth::class, fn () => new Auth());
    }

    public function boot()
    {
        Models\User::observe(Observers\UserObserver::class);
        Models\Currency::observe(Observers\CurrencyObserver::class);

        View::composer('*', function ($view) {
            $view->with('user', FacadesAuth::current());
        });
    }
}
