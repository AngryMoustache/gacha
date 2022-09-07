<div>
    <div class="grid grid-cols-8 gap-2" id="js-game"></div>

    <script>
        (() => {
            function fillBoard () {
                let board = []

                for (let h = 0; h < 5; h++) {
                    board[h] = []
                    for (let w = 0; w < 8; w++) {
                        board[h][w] = tiles[Math.floor(Math.random() * tiles.length)];
                    }
                }

                return board;
            }

            function renderBoard (board) {
                let node
                for (let h = 0; h < board.length; h++) {
                    for (let w = 0; w < board[h].length; w++) {
                        node = document.createElement('div')
                        node.style.background = board[h][w]
                        node.style.aspectRatio = '1'
                        node.classList = 'js-node w-full'
                        window.$board.appendChild(node)
                    }
                }

                window.$nodes = document.querySelectorAll('.js-node')
            }

            function checkMatches (board) {
                // Get all types on the board
                const types = board.flat().filter((value, index, self) => {
                    return self.indexOf(value) === index
                })

                // Results array
                let hits = []

                // Horizontal matches
                for (let h = 0; h < board.length; h++) {
                    hits.push(checkRow(board[h], h))
                }

                // Vertical matches
                board = board[0].map((_, colIndex) => board.map(row => row[colIndex]))
                for (let h = 0; h < board.length; h++) {
                    hits.push(checkRow(board[h], h).map((item) => {
                        return { type: item.type, y: item.x, x: item.y }
                    }))
                }

                return hits.flat()
            }

            function checkRow (row, y) {
                let foundType = null
                let matches = []
                let hits = []

                for (let w = 0; w < row.length; w++) {
                    foundType = row[w]
                    if (foundType !== matches[matches.length - 1]?.type) {
                        matches = []
                    }

                    matches.push({ type: foundType, y: y, x: w })

                    if (matches.length >= 3 && row[w + 1] !== foundType) {
                        hits.push(matches)
                    }
                }

                return hits.flat()
            }

            const tiles = ['red', 'green', 'blue', 'purple', 'yellow'];
            window.$board = document.getElementById('js-game')

            let board = fillBoard()
            renderBoard(board)

            let node
            let matches = checkMatches(board)
            matches.forEach((item) => {
                console.log(item)
                node = window.$board.children[(item.y * 8) + item.x]
                node.style.opacity = 0.25
            })
        })()
    </script>
</div>
