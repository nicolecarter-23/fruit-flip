<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Memory Game</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="centerScreen">
            <h1>Fruit Flip Memory Game</h1>
            <div class="loginBox">
                <?php 
                include "connect.php";

                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $birthdateInput = filter_input(INPUT_POST, "birthdate");

                if (!$email || !$birthdateInput) {
                    echo "Error: Missing or invalid input.";
                    exit;
                }

                $birthdate = date("Y-m-d", strtotime($birthdateInput));

                $stmt = $dbh->prepare("SELECT * FROM players WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user) {
                    if ($user['birthdate'] == $birthdate) {
                        echo "<h2>Welcome Back!</h2>";
                        echo "<a href='play.php?email=$email' class='gameButton'>Play Game</a>";
                    } else {
                        echo "Error: Incorrect password. Please try again.";
                        echo "<a href='index.php'>Back</a>";
                    }
                } else {
                    $stmt = $dbh->prepare("INSERT INTO players (email, birthdate) VALUES (?, ?)");
                    $stmt->execute([$email, $birthdate]);

                    echo "<h2>Account created.</h2>";
                    echo "<h2>Welcome to the game!</h2>";
                    echo "<a href='play.php?email=$email'>Play Game</a>";
                }
                ?>
            </div>
        </div>
    </body>
</html>