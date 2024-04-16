<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 
class ReservationAdminException extends Exception{}

if (!(isset($_SESSION["user"]) && ($_SESSION["user"]["moderator"] == 1))){
    header("location:index.php"); //  átírányítás 
}

function setReservationStatus($reservation_id, $status, $dbconn){
    try{
        
        if (empty($reservation_id)){
            throw new ReservationAdminException("Jelölje ki a módosítani kivánt helyfoglalási kérelmet!");
        }

        $sql = "UPDATE reservation SET status = $status WHERE reservation_id=:reservation_id";
        $query = $dbconn->prepare($sql);
        $query->bindValue("reservation_id", $reservation_id, PDO::PARAM_STR);
        $query->execute();

        $msg = "A kérelem sikeres státusz módosítása megtörtént.";  

    }catch(ReservationAdminException $e){
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
            . "where reservation.status = :statusNow";
            // a futtatandó sql utasítás
            $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
            $query->bindValue("statusNow", $statusNow, PDO::PARAM_STR);
            $query->execute();  // lekérdezés futtatása
            $table = "";
            if ($query->rowCount()>0){  // a visszaadott sorok száma
                $table .= '<table class="admin-table">';
                $table .= "<tr><th>Felhasználó név </th><th>A vásár dátuma </th><th>Az elárusító hely száma </th></tr>\n";
                while ($row = $query->fetch(PDO::FETCH_ASSOC)){ // az eredmény kiolvasása soronként egy asszociatív tömbbe
                $table .= '<tr><td>';
                if ($statusNow == 0){
                    $table .= '<input type="radio" name="reservation_id" required value= "';
                    $table .=$row["reservation_id"];
                    $table .='">';
                }
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
function getReservationCountForStatus($status, $dbconn){
    try{

        if (!empty($dbconn)){
            $sql = "SELECT COUNT(status) AS db FROM reservation WHERE status =:status";
            $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
            $query->bindValue("status", $status, PDO::PARAM_STR);
            $query->execute();  // lekérdezés futtatása
            $row = $query->fetch(PDO::FETCH_ASSOC);
            return $row ["db"];
        } else {
            throw new ReservationAdminException("Nincs adatbázis kapcsolat!"); 
        }
    } catch (PDOException $e){
        $error = "Lekérdezési hiba: ".$e->getMessage();
    } catch(ReservationAdminException $e){
        $error = "Hiba lépett fel a helyfoglalás státuszának megváltoztatása közben: ".$e->getMessage();
    }
}


if (isset($_POST["submitJovahagy"]) && !empty($dbconn)){    
    $reservation_id= trim($_POST["reservation_id"]);
    setReservationStatus($reservation_id, 1, $dbconn);
}

if (isset($_POST["submitElutasit"]) && !empty($dbconn)){    
    $reservation_id= trim($_POST["reservation_id"]);
    setReservationStatus($reservation_id, 3, $dbconn);
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminisztrátor - Helyfoglalás kezeléser</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="main.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                    <div class="container mt-3">
                    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Helyfoglalási kérelmek kezelése</h2><br><br>
                    <h3>Új helyfoglalási kérelmek</h3>
                    <!--reservation táblában a status: 0 -> az elbirálás alatt álló helyfoglalások -->
                    
                    <button type="submit" name="submitJovahagy" <?php echo getReservationCountForStatus (0,$dbconn) == 0 ? "disabled" : "";?>>
                        Jóváhagyás
                    </button>
                    <button type="submit" name="submitElutasit" <?php echo getReservationCountForStatus (0,$dbconn) == 0 ? "disabled" : "";?>>
                        Elutasít
                    </button><br><br>
                    <?php
                    $tableNew = generateTable(0, $dbconn);
                    if (!empty($tableNew)){
                        echo $tableNew;
                    } else echo "Nincs elbírálásra váró helyfoglalási kérelem!";
                    ?>
                </form><br><br>

                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h3>Jóváhagyott helyfoglalási kérelmek</h3>
                    <!--reservation táblában a status: 1 -> a jóváhagyott helyfoglalások -->
                    <?php
                    $tableAktiv = generateTable(1, $dbconn);
                    if (!empty($tableAktiv)){
                        echo $tableAktiv;
                    } else echo "Nincs jóváhagyott helyfoglalási kérelem!";
                    ?>
                </form><br><br>

                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h3>Elutasított helyfoglalási kérelmek</h3>
                    <!--reservation táblában a status: 2 -> a törölt helyfoglalások -->
                    <?php
                    $tableTorolt = generateTable(2, $dbconn);
                    if (!empty($tableTorolt)){
                        echo $tableTorolt;
                    } else echo "Nincs törölt helyfoglalási kérelem!";
                    ?>    
                </form>
                    </div>
                </main>
        </div>
    </div>

    <?php require_once("footer.html"); ?>

</body>
</html>