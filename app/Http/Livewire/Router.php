<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Game;
use Livewire\Component;

class Router extends Component
{
    // Route mapper
    public array $pages = [
        'dashboard' => Game\Dashboard::class,
        'battle-pass' => Game\BattlePass::class,
    ];

    public string $page;
    public string $location;

    protected $listeners = [
        'redirect-to' => 'mount',
    ];

    public function mount(string $location = '')
    {
        $this->navigate($location);
    }

    private function navigate($location)
    {
        $this->page = ($this->pages[$location] ?? key($this->pages))::getName();
        $this->location = $location; // Update browser URL
    }
}
