<?php

namespace App\Http\Livewire\Pages;

use App\Http\Livewire\Page;
use App\Http\Livewire\Wireables\Board;

class TestGame extends Page
{
    public Board $board;

    public function mount($parameters)
    {
        parent::mount($parameters);

        $this->board = new Board;
        $this->board->fill();
    }

    public function parse()
    {
        $this->board->parse();
    }
}
