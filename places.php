<?php
require_once ("dbconnect.php");
session_start();
// Ellenőrizzük, hogy van-e érték a vásárokidőpontok listából
if (isset($_GET['dateId'])) {
    $dateId = $_GET['dateId'];

    // Lekérdezés a szabad helyeket tartalmazó legördülő lista feltöltéséhez
    $sqlHelyek = "SELECT p.place_number, p.place_id
            FROM place p
            LEFT JOIN reservation r ON p.place_id = r.place_id AND r.date_id = $dateId
            WHERE r.place_id IS NULL;";
    $queryHelyek = $dbconn->prepare($sqlHelyek);
    $queryHelyek->execute();

    // Ellenőrzés, hogy van-e eredmény
    if ($queryHelyek->rowCount() > 0) {
        echo "<option value=''>--Válasszon helyet--</option>";
        // Adatok kiírása
        while ($row = $queryHelyek->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row["place_id"] . "'>" . $row["place_number"] . "</option>";
        }
    } else {
        echo "<option value=''>Nincsenek elérhető helyek ezen a napon.</option>";
    }
}
?>