<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Login extends Component
{
    public array $fields = [];

    public ?Collection $messages;

    public function submit()
    {
        $this->messages = null;
        $validator = Validator::make($this->fields, [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        $errors = $validator->errors();
        if ($errors->isNotEmpty()) {
            $this->messages = collect($errors->toArray())->flatten();
            return;
        }

        $username = $this->fields['username'] ?? null;
        $user = User::where('username', $username)->first();
        $check = password_verify($this->fields['password'] ?? null, $user?->password);
        if (! $check) {
            $this->messages = collect(['Could not log you in with those credentials.']);
            return;
        }

        $user->loginAs();

        return redirect()->to('/');
    }
}
