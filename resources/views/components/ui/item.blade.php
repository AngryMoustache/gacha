<x-ui.tooltip class="flex m-2">
    <div class="
        flex w-16 h-16 relative cursor-pointer
        @if (isset($glowing) && $glowing) border-4 border-green-500 @endif
    ">
        <img class="
            w-full @if (isset($disabled) && $disabled) opacity-50 @endif
        " src="{{ $item->icon?->format('thumb') }}">

        @if (isset($amount) && $amount > 1)
            <span style="background-color: rgba(0, 0, 0, .5)" class="
                absolute bottom-0 right-0 left-0
                text-xs text-center text-white
            ">
                x{{ number_format($amount, 0, ',', '.') }}
            </span>
        @endif

        @if (isset($checkmark) && $checkmark)
            <span style="background-color: rgba(0, 0, 0, .5)" class="
                absolute bottom-0 top-0 right-0 left-0
                text-3xl flex justify-center items-center
            ">
                ✔
            </span>
        @endif
    </div>

    <x-slot name="tooltip">
        <strong class="text-lg">{{ $item->name }}</strong>
        {!! $item->description !!}
    </x-slot>
</x-ui.tooltip>
