<div class="grid gap-4 m-4">
    <x-card>
        <x-ui.currency :currency="$user->currency(Currency::BATTLE_PASS)" />

        <x-router.link to="">
            Back to dashboard
        </x-router.link>
    </x-card>

    <div class="flex gap-4">
        <x-card class="w-1/3">
            <img src="{{ $battlePass->attachment?->path() }}" class="w-full">
        </x-card>

        <x-card class="w-2/3">
            <ul>
                @for ($i = 1; $i <= 50; $i++)
                    <li wire:click.prevent="claimReward({{ $i }})">
                        Level {{ $i }}
                        @if ($battlePass->hasRewardsAt($i))
                            @foreach ($battlePass->getRewardsFor($i) as $reward)
                                <x-ui.item
                                    :item="$reward->reward"
                                    :amount="$reward->amount"
                                />
                            @endforeach
                        @endif
                    </li>
                @endfor
            </ul>
        </x-card>
    </div>
</div>
