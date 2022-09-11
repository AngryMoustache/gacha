<?php

namespace App\Http\Livewire\Wireables;

use App\Enums\Stone;
use Illuminate\Support\Collection;
use Livewire\Wireable;

class Board implements Wireable
{
    public Collection $matrix;
    public int $score = 0;
    public int $combo = 0;
    public int $turn = 1;

    public function __construct(
        public int $width = 5,
        public int $height = 5,
        public ?Collection $types = null
    ) {
        $this->matrix = (new Collection)->pad($this->height * $this->width, []);
        $this->types ??= collect(Stone::cases())->pluck('value');
    }

    public function fill()
    {
        $this->matrix = $this->matrix->keys()->map(function ($key) {
            $x = (int) floor($key % $this->width);
            $y = (int) floor($key / $this->width);

            return $this->newStoneAt($x, $y);
        });
    }

    public function newStoneAt($x, $y, $type = null)
    {
        return (object) [
            'key' => rand(0, 999999),
            'value' => $type ?? $this->types->random(),
            'x' => $x,
            'y' => $y,
        ];
    }

    public function toLivewire()
    {
        return collect(get_object_vars($this))->map(function ($item) {
            return ($item instanceof Collection) ? $item->toArray() : $item;
        })->toArray();
    }

    public static function fromLivewire($value)
    {
        $board = new self($value['width'], $value['height']);
        $board->matrix = collect($value['matrix'])->map(fn ($stone) => (object) $stone);
        $board->score = $value['score'] ?? 0;
        $board->combo = $value['combo'] ?? 0;
        $board->turn = $value['turn'] ?? 0;
        $board->types = collect($value['types']);

        return $board;
    }
}
