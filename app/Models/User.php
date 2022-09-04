<?php

namespace App\Models;

use App\Facades\Auth;
use App\Models\Traits\HandleCurrency;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HandleCurrency;

    protected $fillable = [
        'username',
        'email',
        'password',
        'stamina',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    protected $with = [
        'currencies',
    ];

    public function loginAs()
    {
        Auth::loginAs($this);
    }
}
