<div>
    <x-card class="m-4 p-4">
        <ul>
            @foreach ($user->currencies as $currency)
                @if ($currency->pivot->amount > 0 || $currency->shown_when_empty)
                    <li class="flex">
                        <x-ui.currency :currency="$currency" />
                    </li>
                @endif
            @endforeach
        </ul>

        <x-router.link to="battle-pass/season-one">
            Show me the battle pass
        </x-router.link><br>

        <x-router.link to="battle-pass/gem-hoarder">
            Show me the gem pass
        </x-router.link>
    </x-card>
</div>
