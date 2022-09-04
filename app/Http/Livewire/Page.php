<?php

namespace App\Http\Livewire;

use App\Facades\Auth;
use App\Models\User;
use Livewire\Component;

class Page extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = Auth::current();
    }

    public function redirectTo($location)
    {
        $this->dispatchBrowserEvent('router-loading');
        $this->emitTo('router', 'redirect-to', $location);
    }
}
