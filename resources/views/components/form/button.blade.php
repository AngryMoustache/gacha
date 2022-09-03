<span wire:loading.remove>
    <button {{ $attributes->merge([
        'class' => 'px-5 py-2 rounded-lg bg-cyan-500 text-white font-semibold hover:bg-cyan-700',
    ]) }}>
        {{ $slot }}
    </button>
</span>

<span wire:loading>
    <button {{ $attributes->only('class')->merge([
        'class' => 'px-5 py-2 rounded-lg bg-cyan-500 text-white font-semibold hover:bg-cyan-700 opacity-50',
    ]) }}>
        Loading...
    </button>
</span>
