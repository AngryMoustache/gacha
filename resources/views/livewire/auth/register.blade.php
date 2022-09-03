<x-card class="w-full">
    <x-headers.title>
        Register a new account
    </x-headers.title>

    <x-form.form class="flex gap-4 flex-col">
        <x-form.input
            placeholder="Username"
            wire:model.defer="fields.username"
        />

        <x-form.input
            placeholder="E-mail"
            wire:model.defer="fields.email"
            type="email"
        />

        <x-form.input
            placeholder="Password"
            wire:model.defer="fields.password"
            type="password"
        />

        <x-form.input
            placeholder="Confirm Password"
            wire:model.defer="fields.password_confirmation"
            type="password"
        />

        <x-form.errors class="ml-2" :errors="$messages" />

        <x-form.button wire:click.prevent="submit" class="w-full">
            Register
        </x-form.button>
    </x-form.form>
</x-card>
