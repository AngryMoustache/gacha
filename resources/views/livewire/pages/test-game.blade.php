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

        <div x-html="possibleMoves.length"></div>
    </x-card>

    <script>

        function game () {
            return {
                board: [],
                selected: null,
                canSelect: false,
                showSelected: false,
                possibleMoves: [],
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
                        }, 300);
                    } else {
                        this.canSelect = true
                        this.possibleMoves = this.board.checkMoves()

                        if (this.possibleMoves.length === 0) {
                            this.canSelect = false
                            this.board.shuffle()
                            window.setTimeout(() => this.parseBoard(), 750);
                        }
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

                swap (object1, object2, key) {
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

            shuffle () {
                let coords = this.matrix.map((e) => ({x: e.x, y: e.y})).sort((a, b) => 0.5 - Math.random())
                let newCoords

                this.matrix.sort((a, b) => 0.5 - Math.random()).forEach((stone) => {
                    newCoords = coords.pop()
                    stone.x = newCoords.x
                    stone.y = newCoords.y
                    stone.value = this.getRandomType()
                })
            }

            checkMatches () {
                let hits = []

                // Horizontal matches
                for (let h = 0; h < this.height; h++) {
                    hits.push(this.checkStraightRow(this.getRow(h)).flat())
                }

                // Vertical matches
                for (let w = 0; w < this.width; w++) {
                    hits.push(this.checkStraightRow(this.getColumn(w)).flat())
                }

                return hits.flat()
            }

            checkMoves () {
                let moves = []
                let bucketMoves = []

                // Horizontal moves
                for (let h = 0; h < this.height; h++) {
                    moves.push(this.checkStraightRow(this.getRow(h), 2))
                }

                // Vertical moves
                for (let w = 0; w < this.width; w++) {
                    moves.push(this.checkStraightRow(this.getColumn(w), 2))
                }

                // Bucket moves
                for (let h = 0; h < this.height; h++) {
                    bucketMoves.push(this.checkBucketPattern(this.getRow(h)))
                }

                return moves
                    .filter((move) => move[0]?.length > 0)
                    .filter((move) => this.canHaveMatch(move))
                    .concat(bucketMoves)
                    .flat()
            }

            canHaveMatch (stones) {
                // Check all 6 possible stones
                return stones.filter((stone) => {
                    if (! (stone[0].x === stone[1].x)) {
                        // Horizontal
                        return ([
                            this.findAt(stone[0].x - 1, stone[0].y - 1)?.value,
                            this.findAt(stone[0].x - 1, stone[0].y + 1)?.value,
                            this.findAt(stone[0].x - 2, stone[0].y)?.value,
                            this.findAt(stone[1].x + 1, stone[1].y - 1)?.value,
                            this.findAt(stone[1].x + 1, stone[1].y + 1)?.value,
                            this.findAt(stone[1].x + 2, stone[1].y)?.value,
                        ].includes(stone[0].value))
                    }

                    // Vertical
                    return ([
                        this.findAt(stone[0].x - 1, stone[0].y - 1)?.value,
                        this.findAt(stone[0].x + 1, stone[0].y - 1)?.value,
                        this.findAt(stone[0].x, stone[0].y - 2)?.value,
                        this.findAt(stone[1].x - 1, stone[1].y + 1)?.value,
                        this.findAt(stone[1].x + 1, stone[1].y + 1)?.value,
                        this.findAt(stone[1].x, stone[1].y + 2)?.value,
                    ].includes(stone[0].value))
                }).length > 0
            }

            checkBucketPattern (row) {
                let foundType = null
                let matches = []
                let hits = []
                let x, y

                row.forEach((stone) => {
                    [x, y] = [stone.x, stone.y]
                    if (
                        [this.findAt(x - 1, y - 1), this.findAt(x + 1, y - 1)].filter((e) => e?.value === stone.value).length === 2 ||
                        [this.findAt(x + 1, y - 1), this.findAt(x + 1, y + 1)].filter((e) => e?.value === stone.value).length === 2 ||
                        [this.findAt(x - 1, y + 1), this.findAt(x + 1, y + 1)].filter((e) => e?.value === stone.value).length === 2 ||
                        [this.findAt(x - 1, y - 1), this.findAt(x - 1, y + 1)].filter((e) => e?.value === stone.value).length === 2
                    ) {
                        hits.push(stone)
                    }
                })

                return hits
            }

            checkStraightRow (row, amount = 3) {
                let foundType = null
                let matches = []
                let hits = []

                for (let i = 0; i < row.length; i++) {
                    foundType = row[i].value

                    // Is the new stone the same as the one already matched?
                    if (foundType !== matches[matches.length - 1]?.value) {
                        matches = []
                    }

                    matches.push(row[i])

                    // Has the amount limit been reached and is the next stone not the same type?
                    if (matches.length >= amount && row[i + 1] !== foundType) {
                        hits.push(matches)
                    }
                }

                return hits
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
                    stone.key = Math.floor(Math.random() * 99999)
                    stone.value = this.getRandomType()
                })
            }

            findAt (x, y) {
                return this.matrix.filter((e) => e.y === y && e.x === x)[0]
            }

            getRow (y) {
                return this.matrix.filter((e) => e.y === y).sort((a, b) => a.x - b.x)
            }

            getColumn (x) {
                return this.matrix.filter((e) => e.x === x).sort((a, b) => a.y - b.y)
            }

            getRandomType () {
                return this.types[Math.floor(Math.random() * this.types.length)]
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
