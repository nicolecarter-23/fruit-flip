<?php 
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=fruit_flip",
        "root",
        ""
    );

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}
?>