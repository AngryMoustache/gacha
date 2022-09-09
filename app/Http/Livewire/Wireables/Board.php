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
        $this->matrix = (new Collection)
            ->pad($this->height, [])
            ->map(fn ($row) => collect($row)->pad($this->width, null));
    }

    public function fill()
    {
        $this->loop(function ($h, $w) {
            $this->matrix[$h][$w] = $this->newStoneAt($h, $w);
        });
    }

    public function loop($callback, $matrix = null)
    {
        ($matrix ?? $this->matrix)->each(function ($columns, $row) use ($callback) {
            $columns->each(function ($stone, $column) use ($callback, $row) {
                $callback($row, $column, $stone);
            });
        });
    }

    public function newStoneAt($y, $x, $stone = null)
    {
        return (object) [
            'key' => rand(0, 999999),
            'value' => $stone ?? Stone::random()->value,
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
        $board->matrix = collect($value['matrix'])->map(function ($row) {
            return collect($row)->map(fn ($stone) => (object) $stone);
        });

        return $board;
    }
}
