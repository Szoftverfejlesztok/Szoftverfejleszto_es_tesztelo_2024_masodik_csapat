<?php
require_once("dbconnect.php");
if(isset($_GET['userId']) && isset($_GET['selectedDateId']) && isset($_GET['selectedHelyId'])) {
    $userId = $_GET['userId'];
    $selectedHelyId = $_GET['selectedHelyId'];
    $selectedDateId = $_GET['selectedDateId'];

    $sqlReservation = "INSERT INTO reservation (user_id, place_id, date_id, status) VALUES (?, ?, ?, ?)";
    $queryReservation = $dbconn->prepare($sqlReservation);
    $queryReservation->execute([$userId, $selectedHelyId, $selectedDateId, 1]);
    header("Location: index.php?foglalas=1");
} else {
    header("Location: index.php?foglalas=0");
}
exit;
?>
