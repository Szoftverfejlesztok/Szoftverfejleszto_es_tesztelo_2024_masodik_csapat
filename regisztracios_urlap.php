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
                    <div class="container mt-3">
         <!--<style>
    input:not([type=checkbox]){ /*mindenre ugyanaz kivéve a type checkboxra */ 
        display: block;
        margin-bottom: 10px;
    }
</style>-->

<?php


if (isset($_POST["submitRegisztral"]) && !empty($dbconn)){    
    // Űrlapról érkező adatok beolvasása
    $felhnev = $_POST['user_name'];
    $email = $_POST['email'];
    $jelszo = $_POST['password'];
    $vallnev = $_POST['name_company'];
    $kapcstarto = $_POST['contact'];
    $telefonszam = $_POST['telephone'];
    $online = $_POST['online_availability'];

    // SQL lekérdezés előkészítése és végrehajtása az adatok mentésére
    $sql = "INSERT INTO user_data (user_name, email, password, name_company, contact, telephone, online_availability) 
    VALUES (:user_name, :email, :password, :name_company, :contact, :telephone, :online_availability)";

console_log($sql);

    $query= $dbconn->prepare($sql);
    $query->bindValue("user_name", $felhnev, PDO::PARAM_STR);
    $query->bindValue("email", $email, PDO::PARAM_STR);
    $query->bindValue("password", $jelszo, PDO::PARAM_STR);
    $query->bindValue("name_company", $vallnev, PDO::PARAM_STR);
    $query->bindValue("contact", $kapcstarto, PDO::PARAM_STR);
    $query->bindValue("telephone", $telefonszam, PDO::PARAM_STR);
    $query->bindValue("online_availability", $online, PDO::PARAM_STR);

    ?>
    <script>
    console.log(1);
    </script>
    <?php
    $eredmeny = $query->execute();

    if ($eredmeny === TRUE) {
        $msg = "Sikeresen regisztráltál!";
    } else {
        $error =  "Hiba az adatok mentése közben: " . $conn->error;
    }
}

// Adatbázis kapcsolat lezárása

?>

<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">

    <fieldset>
    <h3>Regisztráció</h3>
        <label for="felhnev">Felhasználónév</label> <!--űrlap elem ID-ja-->
        <input type="text" name="felhnev" id="felhnev" placeholder="Felhasználónév"><br> <!--name lehet azonos, az id nem  szerver oldalon a neve alapján kapjuk meg, id csak egyedi, a fornak meg kell egyezni az input id-jával-->
        <label for="email">E-mail cím</label>
        <input type="email" name="email" id="email"placeholder="E-mail"><br>
        <label for="jelszo">Jelszó</label>
        <input type="password" name="jelszo" id="jelszo"><br>
        <label for="jelszomeg">Jelszó megerősítés</label>
        <input type="password" name="jelszomeg" id="jelszomeg"><br>
        <label for="cegnev">Cég név</label> 
        <input type="text" name="cegnev" id="cegnev" placeholder="Cég neve"><br>
        <label for="kapcstarto">Kapcsolattartó</label> 
        <input type="text" name="kapcstarto" id="kapcstarto" placeholder="Kapcsolattartó"><br>
        <label for="telefonszam">Telefonszám</label> 
        <input type="tel" name="telefonszam" id="telefonszam" placeholder="pl.: 06701111333"><br>
        <label for="online">Online elérhetőség</label> 
        <input type="text" name="online" id="online" placeholder=""><br>    
        <input type="submit" value="Küldés" name="submitRegisztral">

    </fieldset>
</form>


<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</body>
</html>
