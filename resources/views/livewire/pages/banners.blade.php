<div class="grid gap-4 p-4">
    @foreach ($banners as $banner)
        <x-card class="p-4">
            <x-headers.title>{{ $banner->name }}</x-headers.title>
            <div class="flex gap-4">
                <img src="{{ $banner->attachment->format('thumb') }}">
                <div>
                    <x-headers.subtitle>Available heroes</x-headers.subtitle>
                    <ul class="pt-4">
                        @foreach ($banner->heroes as $hero)
                            <li>{{ $hero->name }}</li>
                        @endforeach
                    </ul>

                    Pull cost: {{ $banner->pull_cost }}<br>
                    You have: <x-ui.currency :currency="$user->currency($banner->needed_currency)" />

                    <x-form.button wire:click.prevent="pull({{ $banner->id }})">
                        Pull 1 time
                    </x-form.button>

                    <x-form.button wire:click.prevent="pullTen({{ $banner->id }})">
                        Pull 10 times
                    </x-form.button>
                </div>
            </div>
        </x-card>
    @endforeach
</div>
