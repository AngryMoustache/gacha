<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Register extends Component
{
    public array $fields = [];

    public ?Collection $messages;

    public function submit()
    {
        $this->messages = null;
        $validator = Validator::make($this->fields, [
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email|unique:users',
        ]);

        $errors = $validator->errors();
        if ($errors->isNotEmpty()) {
            $this->messages = collect($errors->toArray())->flatten();
            return;
        }

        $data = $this->fields;
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $user = new User($data);
        $user->save();
        $user->loginAs();

        return redirect()->to('/');
    }
}
