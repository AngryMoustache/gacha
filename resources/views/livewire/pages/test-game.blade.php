<div class="grid m-4 gap-4">
    <x-card>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
        <x-form.button wire:click="parse">Parse</x-form.button>
    </x-card>

    <x-card x-data="game">
        <div class="relative">
            <template x-for="row in board.matrix">
                <template x-for="stone in row">
                    <template x-if="stone">
                        <div
                            :key="stone.key"
                            :class="'absolute m-1 w-16 h-16 bg-' + stone.value + '-500 rounded-lg'"
                            :style="'top: ' + (stone.y * 4.25) + 'rem; left: ' + (stone.x * 4.25) + 'rem'"
                        ></div>
                    </template>
                </template>
            </template>
        </div>
    </x-card>

    <script>
        function game () {
            return {
                board: @json($board),
                init () {
                    const matches = this.checkMatches()
                    this.clearStones(matches)
                    this.dropStones(matches)
                },

                clearStones (stones) {
                    stones.forEach((stone) => {
                        let newStone = JSON.parse(JSON.stringify(stone))
                        delete this.board.matrix[stone.y][stone.x]
                        if (! newStone) return

                        newStone.value = 'slate'
                        newStone.x = -newStone.x - 1

                        this.board.matrix[newStone.y][newStone.x] = newStone
                    })
                },

                dropStones () {
                    this.board.matrix.flat().forEach((stone) => {
                        this.dropStone(stone)
                    })
                },

                dropStone (stone) {
                    // Slide left
                },

                checkMatches () {
                    let board = this.board.matrix

                    // Results array
                    let hits = []

                    // Horizontal matches
                    for (let h = 0; h < board.length; h++) {
                        hits.push(this.checkRow(board[h], h))
                    }

                    // Vertical matches
                    board = board[0].map((_, colIndex) => board.map(row => row[colIndex]))
                    for (let h = 0; h < board.length; h++) {
                        hits.push(this.checkRow(board[h], h))
                    }

                    return hits.flat()
                },

                checkRow (row, y) {
                    let foundType = null
                    let matches = []
                    let hits = []

                    for (let w = 0; w < row.length; w++) {
                        foundType = row[w].value
                        if (foundType !== matches[matches.length - 1]?.value) {
                            matches = []
                        }

                        matches.push(row[w])
                        if (matches.length >= 3 && row[w + 1] !== foundType) {
                            hits.push(matches)
                        }
                    }

                    return hits.flat()
                },
            }
        }
    </script>
</div>
