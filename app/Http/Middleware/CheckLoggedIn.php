<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckLoggedIn
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (! User::current()) {
            return redirect(route('auth.login'));
        }

        return $next($request);
    }
}
