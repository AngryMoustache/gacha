<?php

namespace App\Models;

use App\Models\Traits\HandleCurrency;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HandleCurrency;

    public const LOGIN_SESSION = 'logged-in-as';

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

    public static function current()
    {
        return self::find(session(self::LOGIN_SESSION));
    }

    public function loginAs()
    {
        session([self::LOGIN_SESSION => $this->id]);

        $this->last_login_at = now();
        $this->saveQuietly();
    }
}
