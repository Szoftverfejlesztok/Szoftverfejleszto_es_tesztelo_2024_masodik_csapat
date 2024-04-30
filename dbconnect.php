<?php
require_once ("config.php");
try {
    $dbconn = new PDO(DBTYPE . ":dbhost=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASSWORD);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Adatbázis kapcsolódási hiba: " . $e->getMessage();
}
?>