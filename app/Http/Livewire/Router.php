<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class Router extends Component
{
    // Route mapper
    public array $router = [
        '' => Pages\Dashboard::class,
        'battle-pass/{battlePass}' => Pages\BattlePass::class,
        'banners' => Pages\Banners::class,
    ];

    public array $page;
    public string $location;

    public array $pages = [];

    protected $listeners = [
        'redirect-to' => 'mount',
    ];

    public function mount(string $location = '')
    {
        foreach ($this->router as $route => $target) {
            $this->pages[$route] = $target;
            if (Str::contains($route, '{')) {
                $parameter = Str::of($route)->between('{', '}');
                $model = (string) $parameter->ucfirst()->prepend('App\\Models\\');

                $model::pluck('slug')->each(function ($slug) use ($target, $parameter, $route) {
                    $route = Str::replace("{{$parameter}}", $slug, $route);
                    $this->pages[$route] = [
                        'route' => $route,
                        'component' => $target::getName(),
                        'parameters' => [(string) $parameter => $slug],
                    ];
                });
            } else {
                $this->pages[$route] = [
                    'route' => $route,
                    'component' => $target::getName(),
                    'parameters' => [],
                ];
            }
        }

        $this->navigate($location);
    }

    private function navigate($location)
    {
        $this->location = $location; // Update browser URL
        $this->page = ($this->pages[$location] ?? abort(404));
    }
}
