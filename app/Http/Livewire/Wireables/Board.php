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

    public function parse()
    {
        $this->destroy();
        $this->drop();
    }

    public function matches()
    {
        $horizontal = $this->matrix->map(function ($row) {
            return $this->checkRowForMatches($row);
        });

        $vertical = $this->matrix->transpose()->map(function ($row) {
            return $this->checkRowForMatches($row);
        });

        return $horizontal->concat($vertical)->flatten();
    }

    public function destroy($stones = null)
    {
        Collection::wrap($stones ?? $this->matches())->each(function ($stone) {
            $this->matrix[$stone->y][$stone->x] = null;
        });
    }

    public function drop()
    {
        $this->loop(function ($y, $x, $stone) {
            if (! $stone) {
                $this->dropStoneAt($y, $x);
            }
        });
    }

    public function checkRowForMatches($row)
    {
        $matches = collect();
        $hits = collect();

        foreach ($row as $key => $stone) {
            $found = $stone;
            if ($found->value !== $matches->last()?->value) {
                $matches = collect();
            }

            $matches->push($stone);
            if ($matches->count() >= 3 && ($row[$key + 1] ?? null) !== $found) {
                $hits->push($matches);
            }
        }

        return $hits;
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

    public function dropStoneAt($y, $x)
    {
        if ($y === 0) {
            $this->matrix[$y][$x] = $this->newStoneAt($y, $x, 'slate');
        } else {
            $this->matrix[$y][$x] = $this->matrix[$y - 1][$x];
            $this->matrix[$y - 1][$x]->y++;

            $this->dropStoneAt($y - 1, $x);
        }
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
