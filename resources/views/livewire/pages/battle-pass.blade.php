<div class="grid gap-4 m-4">
    <x-card>
        <x-ui.currency :currency="$user->currency($battlePass->needed_currency)" />

        <x-router.link to="">
            Back to dashboard
        </x-router.link><br>

        <x-router.link to="battle-pass/season-one">
            Show me the battle pass
        </x-router.link><br>

        <x-router.link to="battle-pass/gem-hoarder">
            Show me the gem pass
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
            @if ($battlePass->isFinished)
                <p>{{ $battlePass->name }} completed!</p>
            @else
                <p>{{ $battlePass->nextLevelIn }} experience to level {{ $battlePass->currentLevel }}</p>
            @endif

            <ul>
                @for ($lvl = 1; $lvl <= $battlePass->levels_amount; $lvl++)
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
