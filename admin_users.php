<?php
$error = "";        // hibakezelés
$msg = "";

require_once ("dbconnect.php");
session_start();
class UserAdminException extends Exception
{
}

if (!(isset($_SESSION["user"]) && ($_SESSION["user"]["moderator"] == 1))) {
    header("location:index.php"); //  átírányítás 
}

function setUserStatus($userId, $status, $dbconn)
{
    if (empty($userId)) {
        throw new UserAdminException("Jelölje ki a módosítani kívánt felhasználói profilt!");
    }

    $sqlAktiv = "UPDATE userdata SET status = $status WHERE user_id=:user_id";
    $queryAktiv = $dbconn->prepare($sqlAktiv);
    $queryAktiv->bindValue("user_id", $userId, PDO::PARAM_STR);
    $queryAktiv->execute();
}

function generateTable($statusNow, $dbconn)
{
    if (!empty($dbconn)) {
        $sql = "SELECT user_Id, user_name, name_company from userdata where status = :statusNow ";  // a futtatandó sql utasítás
        $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
        $query->bindValue("statusNow", $statusNow, PDO::PARAM_STR);
        $query->execute();  // lekérdezés futtatása
        $table = "";
        if ($query->rowCount() > 0) {  // a visszaadott sorok száma
            $table .= '<table class="admin-table">';
            $table .= "<tr><th>Felhasználó név </th><th>Eladó/Cég név </th></tr>\n";
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { // az eredmény kiolvasása soronként egy asszociatív tömbbe
                $table .= '<tr><td>';
                if ($statusNow == 0 || $statusNow == 1 || $statusNow == 2) {
                    $table .= '<input type="radio" required name="user_id" required value= "';
                    $table .= $row["user_Id"];
                    $table .= '">';
                }
                $table .= $row["user_name"];
                $table .= "</td><td>";
                $table .= $row["name_company"];
                $table .= "</td></tr>\n";
            }
            $table .= "</table>\n";
            return $table;
        }
    }
}

function getUserCountForStatus($status, $dbconn)
{
    try {

        if (!empty($dbconn)) {
            $sql = "SELECT COUNT(status) AS db FROM userdata WHERE status =:status";
            $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
            $query->bindValue("status", $status, PDO::PARAM_STR);
            $query->execute();  // lekérdezés futtatása
            $row = $query->fetch(PDO::FETCH_ASSOC);
            return $row["db"];
        } else {
            return 0;
        }
    } catch (Exception $e) {
        return 0;
    }
}

if (isset($_POST["submitAktival"]) && !empty($dbconn)) {
    try {
        $user_id = trim($_POST["user_id"]);
        setUserStatus($user_id, 1, $dbconn);
        $msg = "Sikeres státusz módosítás.";
    } catch (UserAdminException $e) {
        $error = "Hiba lépett fel a profil státuszának megváltoztatása közben: " . $e->getMessage();
    } catch (PDOException $e) {
        $error = "Adatbázis hiba: " . $e->getMessage();
    }
}

if (isset($_POST["submitDeaktival"]) && !empty($dbconn)) {
    try {
        $user_id = trim($_POST["user_id"]);
        setUserStatus($user_id, 2, $dbconn);
        $msg = "Sikeres státusz módosítás.";
    } catch (UserAdminException $e) {
        $error = "Hiba lépett fel a profil státuszának megváltoztatása közben: " . $e->getMessage();
    } catch (PDOException $e) {
        $error = "Adatbázis hiba: " . $e->getMessage();
    }
}

if (isset($_POST["submitTorol"]) && !empty($dbconn)) {
    try {
        $user_id = trim($_POST["user_id"]);
        setUserStatus($user_id, 3, $dbconn);
        $msg = "Sikeres státusz módosítás.";
    } catch (UserAdminException $e) {
        $error = "Hiba lépett fel a profil státuszának megváltoztatása közben: " . $e->getMessage();
    } catch (PDOException $e) {
        $error = "Adatbázis hiba: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminisztrátor - Felhasználó kezelés</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="main.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
</head>

<body>

    <?php require_once ("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once ("sidebar_menu.php"); ?>

            <!-- Main Content -->
            <main role="main" class="ml-sm-auto col-lg-9 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3">
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <h2>Felhasználói státuszok kezelése</h2><br><br>
                        <h3>Új felhasználói jelentkezések</h3>
                        <!--userdata táblában a status: 0 -> a még elbirálás alatt álló felhasználók -->

                        <button type="submit" name="submitAktival" <?php echo getUserCountForStatus(0, $dbconn) == 0 ? "disabled" : ""; ?>>
                            Aktiválás
                        </button><br><br>
                        <?php
                        try {
                            $tableNew = generateTable(0, $dbconn);
                            if (!empty($tableNew)) {
                                echo $tableNew;
                            } else
                                echo "Nincs aktiválásra váró felhasználó!";
                        } catch (PDOException $e) {
                            $error = "Lekérdezési hiba: " . $e->getMessage();
                        } catch (UserAdminException $e) {
                            $error = "Hiba lépett fel a felhasználók lekérése közben: " . $e->getMessage();
                        }
                        ?>
                    </form><br><br>

                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <h3>Aktív felhasználók</h3>
                        <!--userdata táblában a status: 1 -> az aktiv felhasználók -->

                        <button type="submit" name="submitDeaktival" <?php echo getUserCountForStatus(1, $dbconn) == 0 ? "disabled" : ""; ?>>
                            Felfüggeszt
                        </button>
                        <button type="submit" name="submitTorol" <?php echo getUserCountForStatus(1, $dbconn) == 0 ? "disabled" : ""; ?>>
                            Töröl
                        </button><br><br>
                        <?php
                        try {
                            $tableAktiv = generateTable(1, $dbconn);
                            if (!empty($tableAktiv)) {
                                echo $tableAktiv;
                            } else
                                echo "Nincs aktív felhasználó!";
                        } catch (PDOException $e) {
                            $error = "Lekérdezési hiba: " . $e->getMessage();
                        } catch (UserAdminException $e) {
                            $error = "Hiba lépett fel a felhasználók lekérése közben: " . $e->getMessage();
                        }
                        ?>
                    </form><br><br>

                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <h3>Felfüggesztett felhasználók</h3>
                        <!--userdata táblában a status: 2 -> a felfüggesztett felhasználók -->
                        <button type="submit" name="submitAktival" <?php echo getUserCountForStatus(2, $dbconn) == 0 ? "disabled" : ""; ?>>
                            Aktiválás
                        </button>
                        <button type="submit" name="submitTorol" <?php echo getUserCountForStatus(2, $dbconn) == 0 ? "disabled" : ""; ?>>
                            Töröl
                        </button><br><br>
                        <?php
                        try {
                            $tableDeaktiv = generateTable(2, $dbconn);
                            if (!empty($tableDeaktiv)) {
                                echo $tableDeaktiv;
                            } else
                                echo "Nincs felfüggesztett felhasználó!";
                        } catch (PDOException $e) {
                            $error = "Lekérdezési hiba: " . $e->getMessage();
                        } catch (UserAdminException $e) {
                            $error = "Hiba lépett fel a felhasználók lekérése közben: " . $e->getMessage();
                        }
                        ?>
                    </form><br><br>

                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <h3>Törölt felhasználók</h3>
                        <!--userdata táblában a status: 3 -> a törölt felhasználók -->
                        <?php
                        try {
                            $tableTorolt = generateTable(3, $dbconn);
                            if (!empty($tableTorolt)) {
                                echo $tableTorolt;
                            } else
                                echo "Nincs törölt felhasználó!";
                        } catch (PDOException $e) {
                            $error = "Lekérdezési hiba: " . $e->getMessage();
                        } catch (UserAdminException $e) {
                            $error = "Hiba lépett fel a felhasználók lekérése közben: " . $e->getMessage();
                        }
                        ?>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <?php
    displayMessages($error, $msg);
    require_once ("footer.html");
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>

</html>