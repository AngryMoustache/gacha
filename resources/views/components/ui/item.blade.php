<x-ui.tooltip class="flex">
    <img class="w-8 h-8" src="{{ $item->icon?->format('thumb') }}">

    @if (isset($amount) && $amount > 1)
        x{{ number_format($amount, 0, ',', '.') }}
    @endif

    <x-slot name="tooltip">
        <strong class="text-lg">{{ $item->name }}</strong>
        {!! $item->description !!}
    </x-slot>
</x-ui.tooltip>
