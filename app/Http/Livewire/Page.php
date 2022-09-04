<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Page extends Component
{
    public function redirectTo($location)
    {
        $this->dispatchBrowserEvent('router-loading');
        $this->emitTo('router', 'redirect-to', $location);
    }
}
