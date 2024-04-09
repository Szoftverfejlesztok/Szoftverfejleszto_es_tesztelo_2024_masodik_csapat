<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 

//itt fontos a sorrend:
if (isset($_GET["logout"])){//14. ha be van állítva a getben a logout akkor ő ki akart jelentkezni
    // ki kell venni a felhasználói adatokat a sessionből és így tudja hogy kijelentkezni akar (session destroy lerombol, session unset = kiüríti a tartalmát pl nyelvi beállítás is lehet benne
    unset($_SESSION["user"]);  // a sessionben lévő user tömböt megszünteti
    setcookie("id","",time()-1);//17. törölje a cookiekat a kijelentkezéssel, cookiet nem lehet törölni csak lejártra állítani
    unset($_COOKIE["id"]);  //szerver oldali tömbből is kidobom a kukikat
    $msg = "Sikeres kijelentkezés!";
}

if(!empty($_COOKIE["id"]) && isset($dbconn)){     // 18. lépés, ha van cookie és van adatbázis kapcsolat akkor
        try{
            $sqlCookie = "SELECT id, felhasznalonev, jelszo, teljesnev FROM usere where id=:id";
            $queryCookie = $dbconn->prepare($sqlCookie); //lekérdezés előkészítése (üres)
            $queryCookie->bindValue("id", $_COOKIE["id"], PDO::PARAM_INT); //kitöltöm adattal a lekérdezést
            $queryCookie->execute(); //lefuttatás
            if ($queryCookie->rowCount() != 1){ //hogyha rowcount nem egyelő 1 el akkor azaz nem egy felhasználót kaptunk vissza jó esetben 0-át
                throw new userException("Hibás mentett felhasználói azonosító");
            }
            $user = $queryCookie->fetch(PDO::FETCH_ASSOC); //kiolvassuk az adatokat
            $_SESSION["user"] = array("felhasznalonev"=>$user["felhasznalonev"], "teljesnev"=>$user["teljesnev"], "id"=>$user["id"]);//(Itt csak frissítjük lentről a kövi sorral együtt írjuk be a session tömbbe a felhasználói adatainkat
            setcookie("id",$user["id"],time()+60*3);
        }   catch (PDOException $e){
            $error= "Adatbázis lekérdezési hiba: ". $e->getMessage();
        }   catch (userException $e){
            $error = "Mentett felhasználó hiba: ".$e->getMessage();
        }

}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásár</title>
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
                        <p>
                        <h1>VÁSÁR</h1>

                        <?php require_once("admin_next_vasar.php"); ?>
                        <div id="cim">Helyszín: 6782 Mórahalom, Szegedi út 114.</div>

                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2760.711539595866!2d19.867224776185033!3d46.2161930710962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47437d322b2fa027%3A0x15a3d790a61e4b55!2zTcOzcmFoYWxvbSB2w6Fzw6FydMSXcg!5e0!3m2!1shu!2shu!4v1708362443078!5m2!1shu!2shu" width="900" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </p>
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
