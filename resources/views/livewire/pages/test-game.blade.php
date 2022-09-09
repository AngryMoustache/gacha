<div class="grid m-4 gap-4">
    <x-card x-data="game">
        <div class="relative">
            <template x-for="stone in board.matrix" :key="stone.key">
                <div
                    @click="select(stone.key)"
                    :class="'stone absolute m-1 w-16 h-16 bg-' + stone.value + '-500 rounded-lg ' + (stone.key === selected ? 'opacity-50' : '')"
                    :style="'top: ' + (stone.y * 4.25) + 'rem; left: ' + (stone.x * 4.25) + 'rem'"
                >
                    {{-- <span x-html="stone.x"></span>
                    <span> - </span>
                    <span x-html="stone.y"></span> --}}
                </div>
            </template>
        </div>
    </x-card>

    <script>

        function game () {
            return {
                board: [],
                selected: null,
                canSelect: false,

                init () {
                    this.board = new Board(@json($board).matrix)
                    window.setTimeout(() => this.parseBoard(), 200);
                },

                parseBoard () {
                    let matches = this.board.checkMatches()

                    if (matches.length > 0) {
                        this.canSelect = false
                        this.board.clearStones(matches)
                        window.setTimeout(() => {
                            this.board.dropStones()
                            window.setTimeout(() => this.parseBoard(), 750);
                        }, 200);
                    } else {
                        this.canSelect = true
                    }
                },

                select (key) {
                    if (! this.canSelect || key === this.selected) {
                        this.selected = null
                        return
                    }

                    if (! this.selected) {
                        this.selected = key
                        return
                    }

                    let selected = JSON.parse(JSON.stringify(this.findByKey(this.selected)))
                    let secondSelected = JSON.parse(JSON.stringify(this.findByKey(key)))

                    // Only swappable with neighbours
                    if (! (
                        selected.key === this.findAt(secondSelected.x + 1, secondSelected.y)?.key ||
                        selected.key === this.findAt(secondSelected.x, secondSelected.y + 1)?.key ||
                        selected.key === this.findAt(secondSelected.x - 1, secondSelected.y)?.key ||
                        selected.key === this.findAt(secondSelected.x, secondSelected.y - 1)?.key
                    )) {
                        this.selected = null
                        return
                    }


                    this.findByKey(this.selected).x = secondSelected.x
                    this.findByKey(this.selected).y = secondSelected.y
                    this.findByKey(key).x = selected.x
                    this.findByKey(key).y = selected.y

                    this.selected = null
                    this.canSelect = false

                    window.setTimeout(() => {
                        this.parseBoard()
                    }, 500)
                },
            }
        }

        class Board {
            constructor (matrix) {
                this.matrix = matrix
                this.height = matrix.map((e) => e.y).at(-1) + 1
                this.width = matrix.map((e) => e.x).at(-1) + 1
                this.types = @json($types)
            }

            checkMatches () {
                let hits = []

                // Horizontal matches
                for (let h = 0; h < this.height; h++) {
                    hits.push(this.checkRow(this.matrix.filter((e) => e.y === h)))
                }

                // Vertical matches
                for (let w = 0; w < this.width; w++) {
                    hits.push(this.checkRow(this.matrix.filter((e) => e.x === w)))
                }

                return hits.flat()
            }

            checkRow (row) {
                let foundType = null
                let matches = []
                let hits = []

                for (let i = 0; i < row.length; i++) {
                    foundType = row[i].value
                    if (foundType !== matches[matches.length - 1]?.value) {
                        matches = []
                    }

                    matches.push(row[i])
                    if (matches.length >= 3 && row[i + 1] !== foundType) {
                        hits.push(matches)
                    }
                }

                return hits.flat()
            }

            clearStones (stones) {
                let newBoard = this.matrix
                let newY

                stones.forEach((stone) => {
                    newBoard = newBoard.filter((e) => ! (e.x === stone.x && e.y === stone.y))

                    newY = -1
                    while (this.findAt(stone.x, newY) !== undefined) {
                        newY = newY - 1
                    }

                    stone.y = newY
                    stone.value = this.types[Math.floor(Math.random() * this.types.length)]
                    stone.key = Math.floor(Math.random() * 99999)
                    newBoard.push(stone)
                })

                this.matrix = newBoard
            }

            dropStones () {
                let newBoard = this.matrix
                this.matrix.sort((a, b) => b.y - a.y).forEach((stone, key) => {
                    newBoard[key].y = this.dropStone(stone)
                })

                this.matrix = newBoard
            }

            dropStone (stone) {
                let stop = false
                let newY = stone.y + 1

                // Don't go below the board
                if (newY >= this.height) {
                    return this.height - 1
                }

                // Something is found below, stop falling
                if (this.findAt(stone.x, newY) !== undefined) {
                    return stone.y
                }

                stone.y = stone.y + 1
                return this.dropStone(stone)
            }

            findAt (x, y) {
                return this.matrix.filter((e) => e.y === y && e.x === x)[0]
            }

            findByKey (key) {
                return this.matrix.filter((e) => e.key === key)[0]
            }
        }
    </script>

    <style>
        .stone {
            transition: all .5s;
        }
    </style>
</div>
