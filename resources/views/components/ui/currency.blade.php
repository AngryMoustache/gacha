<x-ui.tooltip class="flex">
    {{ number_format($currency->pivot->amount, 0, ',', '.') }}
    @if ($currency->maximum)
        / {{ number_format($currency->maximum, 0, ',', '.') }}
    @endif

    <img class="w-8 h-8" src="{{ $currency->icon?->format('thumb') }}">


    <x-slot name="tooltip">
        <strong class="text-lg">{{ $currency->name }}</strong>
        {!! $currency->description !!}
    </x-slot>
</x-ui.tooltip>
