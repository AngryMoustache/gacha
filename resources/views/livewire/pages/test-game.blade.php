<div class="grid m-4 gap-4">
    <x-card x-data="game" class="flex">
        <div
            x-show="readyToLoad"
            class="relative overflow-hidden"
            :style="'width: ' + (width * 4.25) + 'rem; height: ' + (height * 4.25) + 'rem'"
        >
            <template x-for="stone in matrix" :key="stone.key">
                <div
                    @mousedown="select(stone)"
                    @mouseup="stopDragging($event, stone)"
                    @mouseenter="moveDrag($event, stone)"
                    @touchstart="select(stone)"
                    @touchend="moveDrag($event, stone)"
                    {{-- :src="'{{ asset('./images/stones') }}/' + stone.value + '.png'" --}}
                    :class="'stone select-none absolute m-1 w-16 h-16 bg-' + stone.value + '-500 rounded-lg ' + (showSelected && stone.key === selected?.key ? ' stone-selected ' : ' ') + (deletions.includes(stone.key) ? ' stone-deleting ' : '') + ' stone-' + (stone.type)"
                    :style="'transition: all .' + 4 * timing + 's; top: ' + (stone.y * 4.25) + 'rem; left: ' + (stone.x * 4.25) + 'rem;'"
                ></div>
            </template>
        </div>

        <div class="pt-4 pl-8">
            You have <span x-html="possibleMoves.length"></span> possible move(s)<br>
            Turn: <span x-html="turn"></span><br>
            Score: <span x-html="score"></span><br>
            <div x-show="combo > 1">
                <span :style="'font-size: ' + (combo >= 6 ? 3 : combo / 2) + 'rem'">
                    <span x-html="combo"></span>x combo !!!
                </span>
            </div>

            <div class="pt-4">
                <span :class="timing === 100 ? 'opacity-50' : 0">
                    <x-form.button wire:target="" @click="timing = 100">x1</x-form.button>
                </span>

                <span :class="timing === 66 ? 'opacity-50' : 0">
                    <x-form.button wire:target="" @click="timing = 66">x2</x-form.button>
                </span>

                <span :class="timing === 33 ? 'opacity-50' : 0">
                    <x-form.button wire:target="" @click="timing = 33">x3</x-form.button>
                </span>
            </div>
        </div>

    </x-card>

    <script>
        function game () {
            return {
                matrix: [],
                deletions: [],
                selected: null,
                canSelect: false,
                showSelected: false,
                possibleMoves: [],
                dragging: false,
                combo: 0,
                timing: 100,
                score: @json($board->score),
                turn: @json($board->turn),
                readyToLoad: @json($readyToLoad),

                init () {
                    this.matrix = @json($board).matrix
                    this.height = @json($board).height
                    this.width = @json($board).width
                    this.types = @json($board).types

                    this.parseBoard(true)
                },

                parseBoard (fast = false) {
                    let matches = this.checkMatches()
                    this.canSelect = false

                    if (matches.length > 0) {
                        // Check if any match is eligable to create bombs
                        let bombs = []
                        matches.filter((e) => e.length > 8).forEach((e) => {
                            stone = { ...e[Math.floor((Math.random() * e.length))] }
                            stone.type = 'bomb'
                            bombs.push(stone)
                        })

                        this.combo++
                        this.score += (matches.flat().length * this.combo)
                        this.clearStones(matches.flat(), bombs, fast)
                    } else {
                        this.possibleMoves = this.checkMoves()

                        if (this.possibleMoves.length === 0) {
                            this.shuffle()
                            window.setTimeout(() => this.parseBoard(fast), fast ? 1 : this.timing * 7);
                        } else {
                            if (this.readyToLoad === false) {
                                this.readyToLoad = true
                                this.combo = 0
                                this.score = 0
                            }

                            this.canSelect = true
                            @this.emit('updateBoard', this.matrix, this.score, this.combo, this.turn)
                        }
                    }
                },

                stopDragging (e, stone) {
                    if (this.dragging && stone.key !== this.selected?.key) {
                        this.select(stone)
                    }

                    this.dragging = false
                },

                moveDrag (e, stone) {
                    if (! this.selected || this.dragging === false) {
                        return
                    }

                    if (stone.key === this.selected?.key) {
                        return
                    }

                    this.select(stone)
                },

                select (stone) {
                    if (! this.canSelect) {
                        return
                    }

                    if (stone.key === this.selected?.key) {
                        this.selected = null
                        return
                    }

                    if (! this.selected) {
                        this.selected = stone
                        this.showSelected = true
                        this.dragging = true
                        return
                    }

                    // Only swappable with neighbours
                    if (! (
                        this.selected.key === this.findAt(stone.x + 1, stone.y)?.key ||
                        this.selected.key === this.findAt(stone.x, stone.y + 1)?.key ||
                        this.selected.key === this.findAt(stone.x - 1, stone.y)?.key ||
                        this.selected.key === this.findAt(stone.x, stone.y - 1)?.key
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
                        if (this.checkMatches().flat().length > 0) {
                            this.combo = 0
                            this.parseBoard()
                            this.turn++
                        } else {
                            this.swap(this.selected, stone, 'x')
                            this.swap(this.selected, stone, 'y')
                            this.canSelect = true
                        }

                        this.selected = null
                    }, this.timing * 5)
                },

                swap (object1, object2, key) {
                    const temp = object1[key]
                    object1[key] = object2[key]
                    object2[key] = temp
                },

                clearType (color) {
                    this.clearStones(this.matrix.filter((e) => e.value === color))
                },

                shuffle () {
                    let coords = this.matrix.map((e) => ({x: e.x, y: e.y})).sort((a, b) => 0.5 - Math.random())
                    let newCoords

                    this.matrix.sort((a, b) => 0.5 - Math.random()).forEach((stone) => {
                        newCoords = coords.pop()
                        stone.x = newCoords.x
                        stone.y = newCoords.y
                        stone.value = this.getRandomType()
                    })
                },

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

                    return hits.filter((e) => e.length > 0)
                },

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
                },

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
                },

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
                },

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
                },

                dropStones () {
                    for (let w = 0; w < this.width; w++) {
                        this.matrix.filter((e) => e.x === w).sort((a, b) => a.y - b.y).forEach((stone, y) => {
                            stone.y = y
                        })
                    }
                },

                clearStones (stones, replacements = [], fast = false) {
                    this.deletions = stones
                        .map((e) => e.key)
                        .filter((e) => ! replacements.map((r) => r.key).includes(e))

                    let bombs = stones.filter((e) => e.type === 'bomb').map((e) => e.value)

                    window.setTimeout(() => {
                        let replacement

                        // Move stones up or replace them with special stones
                        stones.forEach((stone) => {
                            replacement = replacements.filter((e) => e.y === stone.y && e.x === stone.x)[0]
                            if (replacement) {
                                stone.key = Math.floor(Math.random() * 99999) // TODO
                                stone.type = replacement.type
                            } else {
                                stone.y = Math.min(...this.getColumn(stone.x).map((e) => e.y)) - 1
                                stone.key = Math.floor(Math.random() * 99999)
                                stone.value = this.getRandomType()
                                stone.type = 'stone'
                            }
                        })

                        bombs.forEach((e) => this.clearType(e))
                    }, fast ?  1 : this.timing * 2.5)

                    window.setTimeout(() => {
                        this.dropStones()
                        window.setTimeout(() => this.parseBoard(fast), fast ? 1 : this.timing * 7);
                    }, fast ? 1 : this.timing * 3);
                },

                findAt (x, y) {
                    return this.matrix.filter((e) => e.y === y && e.x === x)[0]
                },

                getRow (y) {
                    return this.matrix.filter((e) => e.y === y).sort((a, b) => a.x - b.x)
                },

                getColumn (x) {
                    return this.matrix.filter((e) => e.x === x).sort((a, b) => a.y - b.y)
                },

                getRandomType () {
                    return this.types[Math.floor(Math.random() * this.types.length)]
                },
            }
        }
    </script>

    <style>
        .stone {
            z-index: 10;
        }

        .stone-selected {
            margin: .5rem;
            width: 3.5rem;
            height: 3.5rem;
            z-index: 0;
        }

        .stone-deleting {
            margin: 2rem;
            width: 0;
            height: 0;
        }

        .stone-bomb {
            border-radius: 50%;
        }
    </style>
</div>
