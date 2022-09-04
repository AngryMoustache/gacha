<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Auth extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'custom-auth';
    }
}
