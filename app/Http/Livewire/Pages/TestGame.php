<?php

namespace App\Http\Livewire\Pages;

use App\Enums\Stone;
use App\Facades\Auth;
use App\Http\Livewire\Wireables\Board;
use App\Models\Game;
use Livewire\Component;

class TestGame extends Component
{
    public Board $board;

    public bool $readyToLoad = false;

    protected $listeners = [
        'updateBoard'
    ];

    public function mount()
    {
        if (Auth::current()) {
            $game = Game::where('user_id', Auth::current()->id)->first();
            $this->board = Board::fromLivewire($game->data);
            $this->readyToLoad = true;
        } else {
            $this->board = new Board(7, 7);
            $this->board->fill();
        }
    }

    public function updateBoard($board, $score, $combo, $turn)
    {
        if (! Auth::current()) {
            return;
        }

        $this->board->matrix = collect($board['matrix']);
        $this->board->score = $score;
        $this->board->turn = $turn;
        if ($combo > $this->board->combo) {
            $this->board->combo = $combo;
        }

        Game::updateOrCreate(['user_id' => Auth::current()->id], [
            'data' => $this->board->toLivewire(),
        ]);
    }
}
