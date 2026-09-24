<?php

include "connect.php";

$username = trim($_POST["username"] ?? "");

if (empty($username)) {
    echo "Error: Please enter a player name.";
    exit;
}

/*Check whether this player already exists*/
$stmt = $dbh->prepare(
    "SELECT player_id FROM players WHERE username = ?"
);

$stmt->execute([$username]);

$player = $stmt->fetch(PDO::FETCH_ASSOC);


/*Create a new player if the username doesn't already exist*/
if (!$player) {

    $stmt = $dbh->prepare(
        "INSERT INTO players (username) VALUES (?)"
    );

    $stmt->execute([$username]);

    $playerId = $dbh->lastInsertId();

} else {

    $playerId = $player["player_id"];
}


/*Send the player to the game*/
header(
    "Location: play.php?player_id=" .
    urlencode($playerId)
);

exit;
?>