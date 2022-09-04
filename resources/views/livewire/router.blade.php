<div>
    <div
        wire:loading
        class="fixed z-50 top-0 bottom-0 left-0 right-0 backdrop-blur"
    >
        <div wire:loading.delay>
            Loading beep boop
        </div>
    </div>

    <livewire:is
        :wire:key="$page['route']"
        :component="$page['component']"
        :parameters="$page['parameters']"
    >
</div>
