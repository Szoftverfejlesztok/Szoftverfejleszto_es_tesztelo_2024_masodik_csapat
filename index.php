<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");

session_start(); //olyan helyen legyen, ami minden oldalra be van require-olva, pl header, footer. De csak egyszer!


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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásár</title>
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
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ut turpis vel
                    odio ultricies consectetur. Fusce nec sodales quam. Duis ac purus id velit
                    suscipit ultrices ut et augue.
                </p>
            </div>
        </main>
    </div>
</div>
<?php require_once("footer.html"); ?>




    
</body>
</html>