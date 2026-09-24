<?php
    include "connect.php";

    $playerId = filter_input(INPUT_GET, "player_id", FILTER_VALIDATE_INT);

    if (!$playerId) {
        echo "<h2>Error: Invalid player.</h2>";
        echo "<a href='index.php'>Go back</a>";
        exit;
    }

    // Get player information from the database
    $stmt = $dbh->prepare(
        "SELECT username FROM players WHERE player_id = ?"
    );

    $stmt->execute([$playerId]);

    $player = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$player) {
        echo "<h2>Error: Player not found.</h2>";
        echo "<a href='index.php'>Go back</a>";
        exit;
    }

    $username = $player["username"];
?>

<!doctype html>
<html>
    <head>
        <title>Memory Game</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="js/script.js"></script>
    </head>

    <body>
        <p>Playing as: <?php echo htmlspecialchars($username); ?></p>

        <div id="splashScreen">
            <canvas id="splashCanvas" width="480" height="1200"></canvas>
        </div>

        <div id="startScreen" class="centerScreen" style="display:none;">
            <img src="images/startScreen.png" id="startImg">
            <button id="startGameButton">Start</button>
        </div>

        <!-- GAME SCREEN -->
        <div id="gameScreen" style="display: none;">
            <div id="topBar">
                <button id="helpButton"> Help </button>
                <img src="images/peach.png" id="peach" width="50" height="50">
                <!-- <button id="quitButton"> Quit </button> -->
            </div>
            <header> 
                <h1>Fruit Flip Memory Game! </h1>
            </header>
            <h2>Moves: <span id="moves">0</span></h2>
            <div id="helpPopup" style="display:none;">
                <div id="helpContent">
                    <span id="closeHelp">X</span>
                    <h2>How to Play</h2>
                    <p>Click two cards to flip them over. If they match, they disappear. 
                    Try to match all 8 pairs with the fewest moves possible!</p>
                </div>
            </div>

            <div id="cardContainer">
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
                <div class="card">
                    <img src="images/backCard.png" class="backCard">
                </div>
            </div>
        </div>

        <!-- END SCREEN -->
        <div id="endScreen" style="display:none;">
            <div class="endScreenContent">
                    <h2>Game Complete!</h2>

                    <p>Your Moves: <span id="finalMoves">0</span></p>

                    <form id="resultForm" method="POST" action="leaderboard.php">

                        <input type="hidden" name="player_id" value="<?php echo htmlspecialchars($playerId); ?>">

                        <input type="hidden" name="score" id="movesInput">

                        <button id="quitButtonEnd">
                            View Leaderboard
                        </button>

                    </form>
            </div>
        </div>
    </body>
</html>