<?php

namespace App\Http\Livewire\Pages;

use App\Facades\Auth;
use App\Http\Livewire\Page;

class Dashboard extends Page
{
    public function mount($parameters)
    {
        $this->user = Auth::current();
    }
}
