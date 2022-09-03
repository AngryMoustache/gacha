<div>
    <div
        wire:loading
        wire:target="navigate"
        class="fixed z-50 top-0 bottom-0 left-0 right-0 backdrop-blur"
    >
        <div
            wire:loading.delay
            wire:target="navigate"
        >
            Loading beep boop
        </div>
    </div>

    <livewire:is
        :wire:key="$page"
        :component="$page"
    >

    <script>
        (() => {
            window.Livewire.on('redirect-to', () => {
                // @this.function_name(item);
                console.log(@this)
            });
        })()
    </script>
</div>
