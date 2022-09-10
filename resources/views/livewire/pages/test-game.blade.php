<div class="grid m-4 gap-4">
    <x-card x-data="game">
        <div class="relative overflow-hidden" :style="'width: ' + (board.width * 4.25) + 'rem; height: ' + (board.height * 4.25) + 'rem'">
            <template x-for="stone in board.matrix" :key="stone.key">
                <div
                    @click="select(stone)"
                    :class="'stone absolute m-1 w-16 h-16 bg-' + stone.value + '-500 rounded-lg ' + (showSelected && stone.key === selected?.key ? 'stone-selected' : '')"
                    :style="'top: ' + (stone.y * 4.25) + 'rem; left: ' + (stone.x * 4.25) + 'rem'"
                >
                    {{-- TODO: icon --}}
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
                showSelected: false,
                types: @json($types),

                init () {
                    this.board = new Board(@json($board).matrix, this.types)
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

                select (stone) {
                    if (! this.canSelect || stone.key === this.selected?.key) {
                        this.selected = null
                        return
                    }

                    if (! this.selected) {
                        this.selected = stone
                        this.showSelected = true
                        return
                    }

                    // Only swappable with neighbours
                    if (! (
                        this.selected.key === this.board.findAt(stone.x + 1, stone.y)?.key ||
                        this.selected.key === this.board.findAt(stone.x, stone.y + 1)?.key ||
                        this.selected.key === this.board.findAt(stone.x - 1, stone.y)?.key ||
                        this.selected.key === this.board.findAt(stone.x, stone.y - 1)?.key
                    )) {
                        this.selected = null
                        this.showSelected = false
                        return
                    }

                    this.swap(this.selected, stone, 'x')
                    this.swap(this.selected, stone, 'y')
                    this.canSelect = false
                    this.showSelected = false

                    window.setTimeout(() => {
                        if (this.board.checkMatches().length > 0) {
                            this.parseBoard()
                        } else {
                            this.swap(this.selected, stone, 'x')
                            this.swap(this.selected, stone, 'y')
                        }

                        this.selected = null
                        this.canSelect = true
                    }, 500)
                },

                swap(object1, object2, key) {
                    const temp = object1[key]
                    object1[key] = object2[key]
                    object2[key] = temp
                }
            }
        }

        class Board {
            constructor (matrix, types) {
                this.matrix = matrix
                this.height = Math.max(...matrix.map((e) => e.y)) + 1
                this.width = Math.max(...matrix.map((e) => e.x)) + 1
                this.types = types
            }

            checkMatches () {
                let hits = []

                // Horizontal matches
                for (let h = 0; h < this.height; h++) {
                    hits.push(this.checkRow(this.getRow(h)))
                }

                // Vertical matches
                for (let w = 0; w < this.width; w++) {
                    hits.push(this.checkRow(this.getColumn(w)))
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

            dropStones () {
                for (let w = 0; w < this.width; w++) {
                    this.matrix.filter((e) => e.x === w).sort((a, b) => a.y - b.y).forEach((stone, y) => {
                        stone.y = y
                    })
                }
            }

            clearStones (stones) {
                stones.forEach((stone) => {
                    stone.y = Math.min(...this.getColumn(stone.x).map((e) => e.y)) - 1
                    stone.value = this.types[Math.floor(Math.random() * this.types.length)]
                    stone.key = Math.floor(Math.random() * 99999)
                })
            }

            findAt (x, y) {
                return this.matrix.filter((e) => e.y === y && e.x === x)[0]
            }

            findByKey (key) {
                return this.matrix.filter((e) => e.key === key)[0]
            }

            getRow (y) {
                return this.matrix.filter((e) => e.y === y).sort((a, b) => a.x - b.x)
            }

            getColumn (x) {
                return this.matrix.filter((e) => e.x === x).sort((a, b) => a.y - b.y)
            }
        }
    </script>

    <style>
        .stone {
            z-index: 10;
            transition: all .5s;
        }

        .stone-selected {
            margin: .5rem;
            width: 3.5rem;
            height: 3.5rem;
            z-index: 0;
        }
    </style>
</div>
