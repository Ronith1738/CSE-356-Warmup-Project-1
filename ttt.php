<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ttt_styles.css">
    <title>Tic Tac Toe</title>
</head>

<body>
<?php
function display_board($board) {
    echo '<table>';
    for ($i = 0; $i < 3; $i++) {
        echo '<tr>';
        for ($j = 0; $j < 3; $j++) {
            $cell_value = $board[$i * 3 + $j];
            if ($cell_value === ' ') {
                $url = 'ttt.php?name=' . urlencode($_GET['name']) . '&board=' . urlencode(substr_replace($board, 'X', $i * 3 + $j, 1>
                echo "<td><a href=\"$url\">&nbsp;</a></td>";
            } else {
                echo "<td>$cell_value</td>";
            }
        }
        echo '</tr>';
    }
    echo '</table>';
}

function check_win($board, $player) {
    $winning_combinations = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],  // Rows
        [0, 3, 6], [1, 4, 7], [2, 5, 8],  // Columns
        [0, 4, 8], [2, 4, 6]              // Diagonals
    ];

    foreach ($winning_combinations as $combination) {
        if ($board[$combination[0]] === $player &&
            $board[$combination[1]] === $player &&
            $board[$combination[2]] === $player) {
            return true;
        }
    }

    return false;
}

function make_computer_move($board) {
    // Simple AI: Select the first available empty cell
    for ($i = 0; $i < 9; $i++) {
        if ($board[$i] === ' ') {
            return substr_replace($board, 'O', $i, 1);
        }
    }
    return $board; // No empty cells, shouldn't happen in a normal game
}

if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = htmlspecialchars($_GET['name']);
    $date = date('Y-m-d');
    echo "<h1>Hello $name, $date</h1>";

    if (isset($_GET['board'])) {
        $board = urldecode($_GET['board']);
        if (check_win($board, 'X')) {
            display_board($board);
            echo "<p>You won!</p>";
            echo '<p><a href="ttt.php?name=' . urlencode($name) . '">Play again</a></p>';
        } else {
            $board = make_computer_move($board);
            if (check_win($board, 'O')) {
                display_board($board);
                echo "<p>I won!</p>";
                echo '<p><a href="ttt.php?name=' . urlencode($name) . '">Play again</a></p>';
            } else if (strpos($board, ' ') === false) {
                display_board($board);
                echo "<p>WINNER: NONE. A STRANGE GAME. THE ONLY WINNING MOVE IS NOT TO PLAY.</p>";
            } else {
                display_board($board);
            }
        }
    } else {
        $board = '         '; // 9 spaces for empty board
        display_board($board);
    }
} else {
    echo '<h1>Welcome to Tic Tac Toe</h1>';
    echo '<div class="login">';
    echo '<form action="ttt.php" method="GET">';
    echo '<label for="name">Enter your name:</label><br>';
    echo '<input type="text" id="name" name="name"><br>';
    echo '<input type="submit" value="Submit">';
    echo '</form>';
    echo '</div>';
}
?>
</body>
</html>