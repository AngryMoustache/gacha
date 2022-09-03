<x-card class="w-full">
    <x-headers.title>
        Login with an existing account
    </x-headers.title>

    <x-form.form class="flex gap-4 flex-col">
        <x-form.input
            placeholder="Username"
            wire:model.defer="fields.username"
        />

        <x-form.input
            placeholder="Password"
            wire:model.defer="fields.password"
            type="password"
        />

        <x-form.errors class="ml-2" :errors="$messages" />

        <x-form.button wire:click.prevent="submit" class="w-full">
            Login
        </x-form.button>
    </x-form.form>
</x-card>
