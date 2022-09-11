<?php

namespace App\Http\Middleware;

use App\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class CheckLoggedIn
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        Auth::currentOrRedirect();

        return $next($request);
    }
}
