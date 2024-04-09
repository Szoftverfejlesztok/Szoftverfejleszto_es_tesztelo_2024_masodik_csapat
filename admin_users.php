<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 

if (!(isset($_SESSION["user"]) && ($_SESSION["user"]["moderator"] == 1))){
    header("location:index.php"); //  átírányítás 
}

function setUserStatus($userId, $status, $dbconn){
    try{
        
        if (empty($userId)){
            throw new UserStatusException("Jelölje ki a módosítani kívánt felhasználói profilt!");
        }

        $sqlAktiv = "UPDATE userdata SET status = $status WHERE user_id=:user_id";
        $queryAktiv = $dbconn->prepare($sqlAktiv);
        $queryAktiv->bindValue("user_id", $userId, PDO::PARAM_STR);
        $queryAktiv->execute();

        $msg = "Sikeres státusz módosítás.";  

    }catch(UserStatusException $e){
        $error = "Hiba lépett fel a profil státuszának megváltoztatása közben: ".$e->getMessage();
    }catch (PDOException $e){
        $error = "Adatbázis hiba: ".$e->getMessage(); 
    }
}

function generateTable($statusNow, $dbconn){
    try {
        if (!empty($dbconn)){
            $sql = "SELECT user_Id, user_name, name_company from userdata where status = :statusNow ";  // a futtatandó sql utasítás
            $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
            $query->bindValue("statusNow", $statusNow, PDO::PARAM_STR);
            $query->execute();  // lekérdezés futtatása
            $table = "";
            if ($query->rowCount()>0){  // a visszaadott sorok száma
                $table .= "<table>\n";
                $table .= "<tr><th>Felhasználó név: </th><th>Eladó/Cég név: </th></tr>\n";
                while ($row = $query->fetch(PDO::FETCH_ASSOC)){ // az eredmény kiolvasása soronként egy asszociatív tömbbe
                $table .= '<tr><td><input type="radio" name="user_id" value= "';
                $table .=$row["user_Id"];
                $table .='">';
                $table .=$row["user_name"];
                $table .="</td><td>";
                $table .=$row["name_company"];
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


if (isset($_POST["submitAktival"]) && !empty($dbconn)){    
    $user_id= trim($_POST["user_id"]);
    setUserStatus($user_id, 1, $dbconn);
}

if (isset($_POST["submitDeaktival"]) && !empty($dbconn)){    
    $user_id= trim($_POST["user_id"]);
    setUserStatus($user_id, 2, $dbconn);
}

if (isset($_POST["submitTorol"]) && !empty($dbconn)){    
    $user_id= trim($_POST["user_id"]);
    setUserStatus($user_id, 3, $dbconn);
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminisztrátor - Felhasználó kezelés</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
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
                    <div class="container mt-3">
                    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Új felhasználói jelentkezések</h2>
                    <!--userdata táblában a status: 0 -> a még elbirálás alatt álló felhasználók -->
                    
                    <button type="submit" name="submitAktival">Aktiválás</button><br>
                    <?php
                    $tableNew = generateTable(0, $dbconn);
                    if (!empty($tableNew)){
                        echo $tableNew;
                    } else echo "Nincs aktiválásra váró felhasználó!";
                    ?>

                </form>

                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Aktív felhasználók</h2>
                    <!--userdata táblában a status: 1 -> az aktiv felhasználók -->

                    <button type="submit" name="submitDeaktival">Felfüggeszt</button>
                    <button type="submit" name="submitTorol">Töröl</button><br>
                    <?php
                    $tableAktiv = generateTable(1, $dbconn);
                    if (!empty($tableAktiv)){
                        echo $tableAktiv;
                    } else echo "Nincs aktív felhasználó!";
                    ?>
                    
                </form>
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Felfüggesztett felhasználók</h2>
                    <!--userdata táblában a status: 2 -> a felfüggesztett felhasználók -->
                    <button type="submit" name="submitAktival">Aktiválás</button>
                    <button type="submit" name="submitTorol">Töröl</button><br>
                    <?php
                    $tableDeaktiv = generateTable(2, $dbconn);
                    if (!empty($tableDeaktiv)){
                        echo $tableDeaktiv;
                    } else echo "Nincs felfüggesztett felhasználó!";
                    ?>
 
                </form>
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Törölt felhasználók</h2>
                    <!--userdata táblában a status: 3 -> a törölt felhasználók -->
                    <?php
                    $tableTorolt = generateTable(3, $dbconn);
                    if (!empty($tableTorolt)){
                        echo $tableTorolt;
                    } else echo "Nincs törölt felhasználó!";
                    ?>
                    
                </form>
         
                    </div>
                </main>
        </div>
    </div>

    <?php require_once("footer.html"); ?>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>
</html>
