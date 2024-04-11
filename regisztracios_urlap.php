<?php
require_once("dbconnect.php");
session_start(); 
?>
<!--<style>
    input:not([type=checkbox]){ /*mindenre ugyanaz kivéve a type checkboxra */ 
        display: block;
        margin-bottom: 10px;
    }
</style>-->

<?php/*
// Adatbázis kapcsolat beállítása
$servername = "PHP_SELF";
$username = "root";
$password = "jelszo";
$database = "adatbazis_nev";

$conn = new mysqli($servername, $username, $password, $database);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Hiba az adatbázishoz való kapcsolódás során: " . $conn->connect_error);
}*/



// Űrlapról érkező adatok beolvasása
$felhnev = $_POST['user_name'];
$email = $_POST['email'];
$jelszo = $_POST['password'];
$vallnev = $_POST['name_company'];
$kapcstarto = $_POST['contact'];
$telefonszam = $_POST['telephone'];
$online = $_POST['online_availability'];

// SQL lekérdezés előkészítése és végrehajtása az adatok mentésére
$sql = "INSERT INTO regisztraciok ('user_name', 'email', 'password', 'name_company', 'contact', 'telephone', online_availability')
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
