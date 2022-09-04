<?php

namespace App;

use App\Models\User;

class Auth
{
    public const LOGIN_SESSION = 'current-user';
    public User $user;

    public function current()
    {
        return $this->user ??= User::find(session(self::LOGIN_SESSION));
    }

    public function refresh()
    {
        return $this->user = $this->current()?->refresh();
    }

    public function loginAs($user)
    {
        session([self::LOGIN_SESSION => $user->id]);

        $user->last_login_at = now();
        $user->saveQuietly();

        $this->user = $user;
    }
}
