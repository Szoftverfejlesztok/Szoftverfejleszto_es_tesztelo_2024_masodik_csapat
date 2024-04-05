<?php
require_once("dbconnect.php");
session_start(); 
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásár</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

</head>
<body>
    <header class="text-center">
        <img src="nenipiac_kep.webp" alt="Piac" title="Piac">
        <img src="kocsogok_kep.jpg" alt="Piac" title="Piac">
        <img src="lanypiac_kep.jpg" alt="Piac" title="Piac">
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1:5500/fooldal.html">Kezdőlap</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Helyfoglalás</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Árusok listája</a></li>
            <li class="nav-item"><a class="nav-link" href="http://127.0.0.1:5500/hazirend.html">Házirend</a></li>
            <li class="nav-item"><a class="nav-link" href="http://127.0.0.1:5500/jarvanyugyisz.html">Járványügyi szabályzat</a></li>
        </ul>
    </div>
</div>
</nav>
<!--<style>
    input:not([type=checkbox]){ /*mindenre ugyanaz kivéve a type checkboxra */ 
        display: block;
        margin-bottom: 10px;
    }
</style>-->

<?php
// Adatbázis kapcsolat beállítása
$servername = "localhost";
$username = "felhasznalonev";
$password = "jelszo";
$database = "adatbazis_nev";

$conn = new mysqli($servername, $username, $password, $database);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Hiba az adatbázishoz való kapcsolódás során: " . $conn->connect_error);
}

// Űrlapról érkező adatok beolvasása
$felhnev = $_POST['felhnev'];
$email = $_POST['email'];
$jelszo = $_POST['jelszo'];
$vallnev = $_POST['vallnev'];
$kapcstarto = $_POST['kapcstarto'];
$telefonszam = $_POST['telefonszam'];
$online = $_POST['online'];

// SQL lekérdezés előkészítése és végrehajtása az adatok mentésére
$sql = "INSERT INTO regisztraciok (felhnev, email, jelszo, vallnev, kapcstarto, telefonszam, online)
VALUES ('$felhnev', '$email', '$jelszo', '$vallnev', '$kapcstarto', '$telefonszam', '$online')";

if ($conn->query($sql) === TRUE) {
    echo "Sikeresen regisztráltál!";
} else {
    echo "Hiba az adatok mentése közben: " . $conn->error;
}

// Adatbázis kapcsolat lezárása
$conn->close();
?>
<form action="regisztracio.php" method="post">

<form>

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
    </fieldset>
</form>


<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</body>
</html>
