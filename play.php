<?php

$email = filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL);

if (!$email) {
    echo "<h2>Error: No email received.</h2>";
    echo "<a href='index.php'>Go back</a>";
    exit;
}


?>

<!doctype html>
<html>
    <head>
        <title>Memory Game</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="js/script.js"></script>
    </head>

    <body>
        <p>Logged in as: <?php echo htmlspecialchars($email); ?></p>

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
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <input type="hidden" name="score" id="movesInput">

                        <button id="quitButtonEnd">Quit</button>
                    </form>
                    <!--<p>Best Score: <span id="bestMoves">0</span></p>-->
                    <!--<button id="playAgain">Play Again</button>-->
            </div>
        </div>
    </body>
</html>