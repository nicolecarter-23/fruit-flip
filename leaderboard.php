<?php
include "connect.php";

/* RECEIVE DATA FROM play.php
--------------------------*/

$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$score = filter_input(INPUT_POST, "score", FILTER_VALIDATE_INT);

if (!$email || !$score) {
    echo "<h2>Error: Missing email or score not recieved.</h2>";
    echo "<a href='index.php'>Back to login</a>";
    exit;
}

$stmt = $dbh->prepare("SELECT email FROM players WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit;
}

//$userid = $user['userid'];

/* INSERT THE RESULT
--------------------------*/

$stmt = $dbh->prepare("INSERT INTO results (email, score, datePlayed) VALUES (?, ?, NOW())");
$stmt->execute([$email, $score]);

/* GET USER STATS
--------------------------*/

$stmt = $dbh->prepare("
    SELECT 
        COUNT(*) AS gamesPlayed,
        MIN(score) AS bestScore,
        AVG(score) AS averageScore
    FROM results
    WHERE email = ?
");
$stmt->execute([$email]);
$userStats = $stmt->fetch();

/* GET TOP 5 PLAYERS
--------------------------*/

$stmt = $dbh->query("
    SELECT email, MIN(score) AS bestScore
    FROM results
    GROUP BY email
    ORDER BY bestScore ASC
    LIMIT 5
");
$topUsers = $stmt->fetchAll();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<h1>Leaderboard</h1>

<!-- USER STATS -->
<h2>Your Results</h2>

<p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
<p><strong>Games Played:</strong> <?php echo $userStats['gamesPlayed']; ?></p>
<p><strong>Best Score:</strong> <?php echo $userStats['bestScore']; ?> score</p>

<hr>

<!-- TOP 5 TABLE -->
<h2>Top 5 Players</h2>

<!--<table border="1" cellpadding="8">-->
<table>
    <tr>
        <th>Rank</th>
        <th>Email</th>
        <th>Best Score (score)</th>
    </tr>

    <?php
    $rank = 1;

    foreach ($topUsers as $row) {
        echo "<tr>";
        echo "<td>$rank</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . $row['bestScore'] . "</td>";
        echo "</tr>";
        $rank++;
    }
    ?>
</table>

<br>

<a href="play.php?email=<?php echo urlencode($email); ?>" class="gameButton">Play Again</a>
<br><br>
<a href="index.php" class="gameButton">Log Out</a>

</body>
</html>