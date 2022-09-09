<div class="m-4">
    <x-card>
        <x-form.button wire:click="parse">Parse</x-form.button>
    </x-card>

    <div x-data="game" class="relative">
        @foreach ($board->matrix as $row)
            @foreach ($row as $stone)
                <x-game.stone :stone="$stone" />
            @endforeach
        @endforeach
    </div>

    <script>
        function game () {
            return {
                board: @entangle('board'),
                // init () {
                //     @this.parse()
                // }
            }
        }
    </script>

    <style>
        .stone {

        }
    </style>
</div>
