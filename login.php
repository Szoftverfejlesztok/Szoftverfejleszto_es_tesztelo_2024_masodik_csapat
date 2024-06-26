<?php
$error = "";        // hibakezelés
$msg = "";

require_once ("dbconnect.php");
session_start();
class UserLoginException extends Exception
{
}

if (isset($_POST["submitBejelentkezes"]) && !empty($dbconn)) {    //11.
    try {
        $login = trim($_POST["felhnev"]);
        $jelszo = trim($_POST["jelszo"]);
        if (empty($login) || empty($jelszo)) {
            throw new UserLoginException("Adja meg a felhasználónevét és jelszavát");
        }

        $sqlLogin = "SELECT * FROM  userdata WHERE user_name=:felhasznalonev";
        $queryLogin = $dbconn->prepare($sqlLogin);
        $queryLogin->bindValue("felhasznalonev", $login, PDO::PARAM_STR);
        $queryLogin->execute();
        if ($queryLogin->rowCount() != 1) { //ha rowcount nem egyelő 1 el akkor nem egy felhasználót kaptunk vissza, jó esetben 0-át
            throw new UserLoginException("Hibás felhasználói azonosító");
        }
        $user = $queryLogin->fetch(PDO::FETCH_ASSOC); //kiolvassuk az adatokat
        if (!password_verify($jelszo, $user["password"])) {
            throw new UserLoginException("Hibás jelszó");
        }
        if ($user["status"] == 0) {
            throw new UserLoginException("Az Ön regisztrációja adminisztrátori jóváhagyásra vár. Kérjük próbáljon meg egy késöbbi időpontban belépni!");
        }
        if ($user["status"] == 2) {
            throw new UserLoginException("Ez a felhasználói fiók jelenleg fel van függesztve. Kérjük vegye fel a kapcsolatot velünk!");
        }
        if ($user["status"] == 3) {
            throw new UserLoginException("Ez a felhasználói fiók törlésre került!");
        }
        $msg = "Sikeres bejelentkezés: " . $user["user_name"];  //ez már nem kell írányítsuk át a bejelentkezett profilra
        $_SESSION["user"] = array(
            "user_id" => $user["user_id"],
            "user_name" => $user["user_name"],
            "name_company" => $user["name_company"],
            "contact" => $user["contact"],
            "telephone" => $user["telephone"],
            "email" => $user["email"],
            "photo" => $user["photo"],
            "online_availability" => $user["online_availability"],
            "product_description" => $user["product_description"],
            "moderator" => $user["moderator"],
            "status" => $user["status"]
        );//írjuk be a session tömbbe a felhasználói adatainkat
        setcookie("user_id", $user["user_id"], time() + 60 * 60 * 24); //be kell állítani a cookiet, csak a felhasználói azonosítóját tároljuk,1.hogy hívjuk 2. milyen érétke van 3.mikor járjon le (4. site melyik részére érvényes)

        header("location:index.php"); //átírányítás 

    } catch (UserLoginException $e) {
        $error = "Bejelentkezési hiba: " . $e->getMessage();
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
    <title>Bejelentkezés</title>
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
            <main role="main" class="col-lg-10 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3">

                    <div class="login-page">
                        <div class="form">
                            <form class="login-form" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                                <input type="text" placeholder="Felhasználónév" name="felhnev" />
                                <input type="password" placeholder="Jelszó" name="jelszo" />
                                <input type="submit" value="Bejelentkezés" name="submitBejelentkezes">
                                <p class="message">Nem regisztrált még? <a href="registration_form.php">Új regisztráció
                                        létrehozása</a></p>
                            </form>
                        </div>
                    </div>
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