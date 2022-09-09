@if ($stone)
    <div
        wire:key="{{ $stone->key }}"
        class="absolute m-1 w-16 h-16 bg-{{ $stone->value }}-500 rounded-lg"
        style="top: {{ $stone->y * 4.25 }}rem; left: {{ $stone->x * 4.25 }}rem"
    >{{-- TODO: icon --}}</div>
@endif
