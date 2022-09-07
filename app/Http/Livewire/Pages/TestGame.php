<?php

namespace App\Http\Livewire\Pages;

use App\Http\Livewire\Page;

class TestGame extends Page
{
    public array $board;

    public function mount($parameters)
    {
        parent::mount($parameters);

        $this->board = [
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
        ];
    }
}
