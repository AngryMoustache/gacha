<div class="grid gap-4 m-4">
    <x-card>
        <x-ui.currency :currency="$user->currency(Currency::BATTLE_PASS)" />

        <x-router.link to="">
            Back to dashboard
        </x-router.link>
    </x-card>

    <div class="flex gap-4">
        <x-card class="w-1/3">
            <x-headers.title>{{ $battlePass->name }}</x-headers.title>
            <p>Ends {{ $battlePass->end_date->diffForHumans() }}</p>

            <br>

            <img src="{{ $battlePass->attachment?->path() }}" class="w-full">
        </x-card>

        <x-card class="w-2/3">
            <p>{{ $battlePass->nextLevelIn }} / 1000 experience to next level</p>
            <ul>
                @for ($lvl = 1; $lvl <= 50; $lvl++)
                    <li wire:click.prevent="claimReward({{ $lvl }})">
                        Level {{ $lvl }}
                        @if ($battlePass->hasRewardsAt($lvl))
                            <div class="flex">
                                @foreach ($battlePass->getRewardsFor($lvl) as $reward)
                                    <x-ui.item
                                        :item="$reward->reward"
                                        :amount="$reward->amount"
                                        :disabled="! $battlePass->hasExperience($lvl)"
                                        :checkmark="$battlePass->hasClaimed($lvl)"
                                        :glowing="$battlePass->canClaim($lvl)"
                                    />
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endfor
            </ul>
        </x-card>
    </div>
</div>
