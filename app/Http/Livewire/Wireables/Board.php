<?php

namespace App\Http\Livewire\Wireables;

use App\Enums\Stone;
use Illuminate\Support\Collection;
use Livewire\Wireable;

class Board implements Wireable
{
    public Collection $matrix;

    public function __construct(
        public int $width = 5,
        public int $height = 5
    ) {
        $this->matrix = (new Collection)->pad($this->height * $this->width, []);
    }

    public function fill()
    {
        $this->matrix = $this->matrix->map(function ($stone, $key) {
            $y = (int) floor($key / $this->height);
            $x = (int) floor($key % $this->width);

            return $this->newStoneAt($x, $y);
        });
    }

    public function newStoneAt($x, $y, $type = null)
    {
        return (object) [
            'key' => rand(0, 999999),
            'value' => $type ?? Stone::random()->value,
            'x' => $x,
            'y' => $y,
        ];
    }

    public function toLivewire()
    {
        return [
            'width' => $this->width,
            'height' => $this->height,
            'matrix' => $this->matrix->toArray(),
        ];
    }

    public static function fromLivewire($value)
    {
        $board = new self($value['width'], $value['height']);
        $board->matrix = collect($value['matrix'])->map(fn ($stone) => (object) $stone);

        return $board;
    }
}
