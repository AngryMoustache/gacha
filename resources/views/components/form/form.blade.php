<form {{ $attributes->merge([
    'wire:submit' => 'submit',
]) }}>
    {{ $slot }}
</form>
