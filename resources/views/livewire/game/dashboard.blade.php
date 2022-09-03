<div>
    <x-card class="m-4 p-4">
        <ul>
            @foreach ($user->currencies as $currency)
                <li class="flex">
                    <x-ui.currency :currency="$currency" />
                </li>
            @endforeach
        </ul>

        <x-router.link to="battle-pass/season-one">
            Show me the battle pass
        </x-router.link>
    </x-card>
</div>
