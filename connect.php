<?php 
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=php_assignment",
        "root",
        ""
    );
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
?>