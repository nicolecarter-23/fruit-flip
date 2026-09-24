<?php

    include "connect.php";

    /*Get game result*/
    $playerId = filter_input(INPUT_POST, "player_id", FILTER_VALIDATE_INT);
    $score = filter_input(INPUT_POST, "score", FILTER_VALIDATE_INT);

    if (!$playerId || !$score) {
        echo "<h2>Error: Invalid player or score.</h2>";
        echo "<a href='index.php'>Back to home</a>";
        exit;
    }


    /*Verify the player exists in the database*/
    $stmt = $dbh->prepare(
        "SELECT username FROM players WHERE player_id = ?"
    );

    $stmt->execute([$playerId]);

    $player = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$player) {
        echo "<h2>Error: Player not found.</h2>";
        echo "<a href='index.php'>Back to home</a>";
        exit;
    }

    $username = $player["username"];


    /*Save game result to the database*/
    $stmt = $dbh->prepare(
        "INSERT INTO results (player_id, score)
        VALUES (?, ?)"
    );

    $stmt->execute([$playerId, $score]);


    /*Get current players stats*/
    $stmt = $dbh->prepare("
        SELECT
            COUNT(*) AS games_played,
            MIN(score) AS best_score,
            AVG(score) AS average_score
        FROM results
        WHERE player_id = ?
    ");

    $stmt->execute([$playerId]);

    $userStats = $stmt->fetch(PDO::FETCH_ASSOC);


    /*Top 5 players*/
    $stmt = $dbh->query("
        SELECT
            p.username,
            MIN(r.score) AS best_score
        FROM players p
        JOIN results r
            ON p.player_id = r.player_id
        GROUP BY p.player_id, p.username
        ORDER BY best_score ASC
        LIMIT 5
    ");

    $topUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fruit Flip Leaderboard</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <h1>Fruit Flip Leaderboard</h1>

    <h2>Your Results</h2>

    <p>
        <strong>Player:</strong>
        <?php echo htmlspecialchars($username); ?>
    </p>

    <p>
        <strong>Games Played:</strong>
        <?php echo $userStats["games_played"]; ?>
    </p>

    <p>
        <strong>Best Score:</strong>
        <?php echo $userStats["best_score"]; ?> moves
    </p>

    <p>
        <strong>Average Score:</strong>
        <?php echo number_format($userStats["average_score"], 1); ?> moves
    </p>


    <h2>Top 5 Players</h2>

    <table>

        <tr>
            <th>Rank</th>
            <th>Player</th>
            <th>Best Score</th>
        </tr>

        <?php
            $rank = 1;

            foreach ($topUsers as $row) {

                echo "<tr>";
                echo "<td>" . $rank . "</td>";
                echo "<td>" .
                    htmlspecialchars($row["username"]) .
                    "</td>";
                echo "<td>" .
                    $row["best_score"] .
                    " moves</td>";
                echo "</tr>";
                $rank++;
            }
        ?>

    </table>

    <br>

    <a href="play.php?player_id=<?php echo urlencode($playerId); ?>" class="gameButton"> Play Again </a>

    <br><br>

    <a href="index.php" class="gameButton"> Change Player</a>
</body>
</html>