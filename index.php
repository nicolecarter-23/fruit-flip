<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Fruit Flip</title>

        <link rel="stylesheet" href="css/style.css">
    </head>
    
    <body>
        <div class="loginBox">
            <h1>Fruit Flip!</h1>
            <p>Enter a player name to start!</p>
            <form action="login.php" method="post">
                <input
                    type="text"
                    name="username"
                    placeholder="Player name"
                    maxlength="50"
                    required
                >
                <button type="submit" id="loginButton">
                    Play
                </button>
            </form>
        </div>
    </body>
</html>