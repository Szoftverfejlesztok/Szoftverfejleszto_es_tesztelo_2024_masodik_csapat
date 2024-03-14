<?php
$error = "";        // hibakezelés
$msg = ""; 

class ReservationException extends Exception{}

require_once("dbconnect.php");

session_start(); //olyan helyen legyen, ami minden oldalra be van require-olva, pl header, footer. De csak egyszer!
/* if (!isset($_SESSION["user"])){
    header("location:/index.php");   //? 
} */

function setReservationStatus($reservation_id, $status, $dbconn){
    try{
        
        if (empty($reservation_id)){
            throw new ReservationException("Jelölje ki a módosítani kivánt helyfoglalási kérelmet!");
        }

        $sql = "UPDATE reservation SET status = $status WHERE reservation_id=:reservation_id";
        $query = $dbconn->prepare($sql);
        $query->bindValue("reservation_id", $reservation_id, PDO::PARAM_STR);
        $query->execute();

        $msg = "A kérelem sikeres státusz módosítása megtörtént.";  

    }catch(aktivalException $e){
        $error = "Hiba lépett fel a státusz módosítás közben: ".$e->getMessage();
    }catch (PDOException $e){
        $error = "Adatbázis hiba: ".$e->getMessage(); 
    }
}

function generateTable($statusNow, $dbconn){
    try {
        if (!empty($dbconn)){
            $sql = "SELECT user_name, date, place_number, reservation_id FROM reservation INNER JOIN userdata "
            . "ON reservation.user_id = userdata.user_Id "
            . "INNER JOIN date_vasar ON reservation.date_id = date_vasar.date_id "
            . "INNER JOIN place ON reservation.place_id = place.place_id "
            . "where reservation_status = :statusNow";
            // a futtatandó sql utasítás
            $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
            $query->bindValue("statusNow", $statusNow, PDO::PARAM_STR);
            $query->execute();  // lekérdezés futtatása
            $table = "";
            if ($query->rowCount()>0){  // a visszaadott sorok száma
                $table .= "<table>\n";
                $table .= "<tr><th>Felhasználó név: </th><th>A vásár dátuma: </th><th>Az elárusító hely száma: </th></tr>\n";
                while ($row = $query->fetch(PDO::FETCH_ASSOC)){ // az eredmény kiolvasása soronként egy asszociatív tömbbe
                $table .= '<tr><td><input type="radio" name="reservation_id" value= "';
                $table .=$row["reservation_id"];
                $table .='">';
                $table .=$row["user_name"];
                $table .="</td><td>";
                $table .=$row["date"];
                $table .="</td><td>";
                $table .=$row["place_number"];
                $table .="</td></tr>\n";
                }
                $table .= "</table>\n";
                return $table;
            }
            }
    } catch (PDOException $e){
        $error = "Lekérdezési hiba: ".$e->getMessage();
    }
}


if (isset($_POST["submitJovahagy"]) && !empty($dbconn)){    
    $reservation_id= trim($_POST["reservation_id"]);
    setReservationStatus($reservation_id, 1, $dbconn);
}

if (isset($_POST["submitFelfuggeszt"]) && !empty($dbconn)){    
    $reservation_id= trim($_POST["reservation_id"]);
    setReservationStatus($reservation_id, 2, $dbconn);
}

if (isset($_POST["submitElutasit"]) && !empty($dbconn)){    
    $reservation_id= trim($_POST["reservation_id"]);
    setReservationStatus($reservation_id, 3, $dbconn);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminisztrátor - Helyfoglalás kezelése</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
    <?php require_once("oldalso_menu.php"); ?>
    <?php require_once("header.php"); ?>


   
    <!-- Main Content -->
       <main role="main" class="ml-sm-auto col-lg-8 px-md-4">
          <!--itt kell tartalommal feltölteni az oldalt -->
              <div class="container mt-3">
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Új helyfoglalási kérelmek</h2>
                    <!--reservation táblában a status: 0 -> az elbirálás alatt álló helyfoglalások -->
                    
                    <button type="submit" name="submitJovahagy">Jóváhagyás</button>
                    <button type="submit" name="submitFelfuggeszt">Felfüggeszt</button>
                    <button type="submit" name="submitElutasit">Elutasít</button><br>
                    <?php
                    $tableNew = generateTable(0, $dbconn);
                    if (!empty($tableNew)){
                        echo $tableNew;
                    } else echo "Nincs elbírálásra váró helyfoglalási kérelem!";

                    ?>

                </form>

                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Jóváhagyott helyfoglalási kérelmek</h2>
                    <!--reservation táblában a status: 1 -> a jóváhagyott helyfoglalások -->
                    <?php
                    $tableAktiv = generateTable(1, $dbconn);
                    if (!empty($tableAktiv)){
                        echo $tableAktiv;
                    } else echo "Nincs jóváhagyott helyfoglalási kérelem!";
                    ?>
                    
                </form>
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Felfüggesztett helyfoglalási kérelmek</h2>
                    <!-- Kérelmek, amik valami apró hibát tartalmaznak -->
                    <!--reservation táblában a status: 2 -> a felfüggesztett helyfoglalások -->
                    <button type="submit" name="submitJovahagy">Jóváhagyás</button>
                    <button type="submit" name="submitElutasit">Elutasít</button><br>
                    <?php
                    $tableDeaktiv = generateTable(2, $dbconn);
                    if (!empty($tableDeaktiv)){
                        echo $tableDeaktiv;
                    } else echo "Nincs felfüggesztett helyfoglalási kérelem!";
                    ?>
 
                </form>
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Elutasított helyfoglalási kérelmek</h2>
                    <!--reservation táblában a status: 3 -> a törölt helyfoglalások -->
                    <?php
                    $tableTorolt = generateTable(3, $dbconn);
                    if (!empty($tableTorolt)){
                        echo $tableTorolt;
                    } else echo "Nincs törölt helyfoglalási kérelem!";
                    ?>
                    
                </form>

            </div>
        </main>
    </div>
</div>
<?php   
                    if (!empty($error)){
                    echo "<p class=\"error\">$error</p>\n";
                    }
                    if (!empty($msg)){
                    echo "<p class=\"msg\">$msg</p>\n";
                    }
                ?>
<?php require_once("footer.html"); ?>




    
</body>
</html>