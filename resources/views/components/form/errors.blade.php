@if ($errors?->isNotEmpty())
    <div wire:loading.remove {{ $attributes->merge([
        'class' => 'text-red-500',
    ]) }}>
        @foreach ($errors as $error)
            {{ $error }}
            @if (! $loop->last)<br>@endif
        @endforeach
    </div>
@endif
