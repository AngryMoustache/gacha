<?php

namespace App\Http\Livewire\Pages;

use App\Enums\Stone;
use App\Http\Livewire\Wireables\Board;
use Livewire\Component;

class TestGame extends Component
{
    public Board $board;
    public array $types;

    public function mount()
    {
        $this->types = collect(Stone::cases())->pluck('value')->toArray();
        $this->board = new Board(7, 7);
        $this->board->fill();
    }
}
