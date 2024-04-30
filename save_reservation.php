<?php
session_start();
require_once ("dbconnect.php");
if (isset($_GET['selectedDateId']) && isset($_GET['selectedHelyId'])) {
    try {
        $userId = $_SESSION["user"]["user_id"];
        $selectedHelyId = $_GET['selectedHelyId'];
        $selectedDateId = $_GET['selectedDateId'];

        $sqlReservation = "INSERT INTO reservation (user_id, place_id, date_id, status) VALUES (?, ?, ?, ?)";
        $queryReservation = $dbconn->prepare($sqlReservation);
        $queryReservation->execute([$userId, $selectedHelyId, $selectedDateId, 0]);
        header("Location: index.php?foglalas=1");
    } catch (PDOException $e) {
        $error = "Adatbázis hiba: " . $e->getMessage();
    } catch (Exception $e) {
        $error = "Hiba történt a helyfoglalási kérelem mentése közben: " . $e->getMessage();
    }
} else {
    header("Location: index.php?foglalas=0");
}
exit;
?>