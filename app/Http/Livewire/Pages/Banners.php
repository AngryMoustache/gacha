<?php

namespace App\Http\Livewire\Pages;

use App\Facades\Auth;
use App\Http\Livewire\Page;
use App\Models\Banner as ModelsBanner;

class Banners extends Page
{
    public function mount($parameters)
    {
        $this->user = Auth::current();
        $this->banners = ModelsBanner::current()->get();
    }
}
