<?php

namespace App\Http\Livewire\Pages;

use App\Enums\Stone;
use App\Http\Livewire\Page;
use App\Http\Livewire\Wireables\Board;

class TestGame extends Page
{
    public Board $board;
    public array $types;

    public function mount($parameters)
    {
        parent::mount($parameters);

        $this->types = collect(Stone::cases())->pluck('value')->toArray();

        $this->board = new Board;
        $this->board->fill();
    }
}
