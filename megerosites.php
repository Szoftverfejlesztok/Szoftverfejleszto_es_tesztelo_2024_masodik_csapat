<?php
require_once("dbconnect.php"); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style1.css">
        <title>Adatok megerősítése</title>
    </head>
    <body>
        <h1>A kiválasztott hely foglalásának véglegesítése</h1>
        <?php
        if(isset($_GET['selectedDateId']) && isset($_GET['selectedHelyId'])) {
            $selectedDateId = $_GET['selectedDateId'];
            $selectedHelyId = $_GET['selectedHelyId'];
            //$userId = $_GET['userId'];
            $userId = 1;

            $sqlUserData = "SELECT name_company, contact, telephone, email FROM userdata WHERE user_id = $userId";
            $queryUserData = $dbconn->prepare($sqlUserData);
            $queryUserData->execute();

            $sqlVasarData = "SELECT date FROM date_vasar WHERE date_id = $selectedDateId";
            $queryVasarData = $dbconn->prepare($sqlVasarData);
            $queryVasarData->execute();

            $sqlPlaceData = "SELECT place_number, place_price FROM place WHERE place_id = $selectedHelyId";
            $queryPlaceData = $dbconn->prepare($sqlPlaceData);
            $queryPlaceData->execute();
            
            if($queryUserData->rowCount() == 1 && $queryVasarData->rowCount() == 1 && $queryPlaceData->rowCount() == 1) {
                $userData = $queryUserData->fetch(PDO::FETCH_ASSOC);
                $vasarData = $queryVasarData->fetch(PDO::FETCH_ASSOC);
                $placeData = $queryPlaceData->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="saveReservation.php" method="GET">
                    <input type="hidden" name="selectedDateId" value=<?php echo $selectedDateId; ?>>
                    <input type="hidden" name="selectedHelyId" value=<?php echo $selectedHelyId; ?>>
                    <input type="hidden" name="userId" value=<?php echo $userId; ?>>
                    <h2>Foglaló adatai:</h2>
                    <label>Cégnév: <?php echo $userData['name_company']; ?></label><br/>
                    <label>Kapcsolattartó: <?php echo $userData['contact']; ?></label><br/>
                    <label>Telefonszám: <?php echo $userData['telephone']; ?></label><br/>
                    <label>E-mail cím: <?php echo $userData['email']; ?></label><br/>
                    <h2>Foglalás adatai:</h2>
                    <label>Vásár dátuma: <?php echo $vasarData['date']; ?></label><br/>
                    <label>Hely száma: <?php echo $placeData['place_number']; ?></label><br/>
                    <label>Hely ára: <?php echo $placeData['place_price']; ?> Ft</label><br/>
                    <input type="submit" value="Foglalás véglegesítése">
                </form>
                <?php
            } else {
                echo "Nincs megjeleníthető adat.";
            }
        } else {
            echo "Hibás adatátadás!";
        }
        ?>
    </body>
</html>
