<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásár</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="main.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
</head>
<body>

    <?php require_once("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once("sidebar_menu.php"); ?>


            <!-- Main Content -->
            <main role="main" class="ml-sm-auto col-lg-8 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3" id="validation">
                <h3>A kiválasztott hely foglalásának véglegesítése</h3><br>
                    <?php
                    if(isset($_GET['selectedDateId']) && isset($_GET['selectedHelyId'])) {
                        $selectedDateId = $_GET['selectedDateId'];
                        $selectedHelyId = $_GET['selectedHelyId'];
                        $userId = $_SESSION["user"]["user_id"];

                        $sqlUserData = "SELECT name_company, contact, telephone, email FROM userdata WHERE user_id = $userId";
                        $queryUserData = $dbconn->prepare($sqlUserData);
                        $queryUserData->execute();

                        $sqlVasarData = "SELECT date FROM date_market WHERE date_id = $selectedDateId";
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
                            <form action="save_reservation.php" method="GET">
                                <input type="hidden" name="selectedDateId" value=<?php echo $selectedDateId; ?>>
                                <input type="hidden" name="selectedHelyId" value=<?php echo $selectedHelyId; ?>>
                                <br><h4>Foglaló adatai:</h4><br>
                                <label>Cégnév: <?php echo $userData['name_company']; ?></label><br/>
                                <label>Kapcsolattartó: <?php echo $userData['contact']; ?></label><br/>
                                <label>Telefonszám: <?php echo $userData['telephone']; ?></label><br/>
                                <label>E-mail cím: <?php echo $userData['email']; ?></label><br/>
                                <br><h4>Foglalás adatai:</h4><br>
                                <label>Vásár dátuma: <?php echo $vasarData['date']; ?></label><br/>
                                <label>Hely száma: <?php echo $placeData['place_number']; ?></label><br/>
                                <label>Hely ára: <?php echo $placeData['place_price']; ?> Ft</label><br/><br>
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
                    
                </div>
            </main>
        </div>
    </div>

    <?php 
        displayMessages($error, $msg);
        require_once("footer.html"); 
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


</body>
</html>
