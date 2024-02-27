<?php

class UserException extends Exception{}

require_once("dbconnect.php");

if (isset($_POST["submitBejelentkezes"]) && !empty($dbconn)){    //11.
    try{
        $login= trim($_POST["felhnev"]);
        $jelszo = trim($_POST["jelszo"]);
        if (empty($login) || empty($jelszo)){
            throw new userException("Adja meg a felhasználónevét és jelszavát");
        }

        $sqlLogin = "SELECT id, felhasznalonev,jelszo,teljesnev FROM  usere WHERE felhasznalonev=:felhasznalonev";
        $queryLogin = $dbconn->prepare($sqlLogin);
        $queryLogin->bindValue("felhasznalonev", $login, PDO::PARAM_STR);
        $queryLogin->execute();
        if ($queryLogin->rowCount() != 1){ //hogyha rowcount nem egyelő 1 el akkor azaz nem egy felhasználót kaptunk vissza jó esetben 0-át
            throw new userException("Hibás felhasználói azonosító");
        }
        $user = $queryLogin->fetch(PDO::FETCH_ASSOC); //kiolvassuk az adatokat
        if (!password_verify($jelszo,$user["jelszo"])){
            throw new userException("Hibás jelszó");
        }    

        $msg = "Sikeres bejelentkezés: ".$user["teljesnev"];  //ez már nem kell írányítsuk át a bejelentkezett profilra

        $_SESSION["user"] = array("felhasznalonev"=>$user["felhasznalonev"], "teljesnev"=>$user["teljesnev"], "id"=>$user["id"]);//írjuk be a session tömbbe a felhasználói adatainkat
        setcookie("id",$user["id"],time()+60*3); //16. be kell állítani a cookiet, csak a felhasználói azonosítóját tároljuk,1.hogy hívjuk 2. milyen érétke van 3.mikor járjon le (4. site melyik részére érvényes)



        header("location:index.php"); //12.lépés  átírányítás 

    }catch(userException $e){
        $error = "Bejelentkezési hiba: ".$e->getMessage();
    }catch (PDOException $e){
        $error = "Adatbázis hiba: ".$e->getMessage(); 
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
    <?php require_once("dbconnect.php"); ?>
    <?php require_once("oldalso_menu.php"); ?>
    <?php require_once("header.php"); ?>
   
<?php   
    if (!empty($error)){
    echo "<p class=\"error\">$error</p>\n";
    }
    if (!empty($msg)){
    echo "<p class=\"msg\">$msg</p>\n";
    }
?>

<div class="login-page">
    <div class="form">
        <form class="login-form" action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
            <input type="text" placeholder="Felhasználónév" name= "felhnev"/>
            <input type="password" placeholder="Jelszó" name="jelszo"/>
            <input type="submit" value="Bejelentkezés" name="submitBejelentkezes">
            <p class="message">Nem regisztrált még? <a href="#">Új regisztráció létrehozása</a></p>
        </form>
    </div>
</div>


</div>
</div>
<?php require_once("footer.html"); ?>
</body>
</html>