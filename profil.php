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
   
    <title>Felhasználói profilok</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
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
   
<body>

<h2>Profil adatok</h2>

<?php
// Felhasználó adatainak beolvasása
$felhnev = "example_user"; 
$jelszo = "*******"; 
$email = "example@example.com"; 
$cegnev = "Bolt Kft.";
$kapcstarto = "Tanács Kata";
$telefonszam = "+36707777777";
$online = "Mézes bödön";

// Felhasználói adatok megjelenítése
echo "<p><strong>Felhasználónév:</strong> $felhnev</p>";
echo "<p><strong>Jelszó:</strong> $jelszo</p>";
echo "<p><strong>E-mail cím:</strong> $email</p>";
echo "<p><strong>Cég neve:</strong> $cegnev</p>";
echo "<p><strong>Kapcsolattartó:</strong> $kapcstarto</p>";
echo "<p><strong>Telefonszám:</strong> $telefonszam</p>";
echo "<p><strong>Online elérhetőség:</strong> $online</p>";

    
    /*
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

    // SQL lekérdezés az összes felhasználói profil lekéréséhez
    $sql = "SELECT felhnev, email, vallnev, kapcstarto, telefonszam, online FROM regisztraciok";
    $result = $conn->query($sql);

    // Adatok megjelenítése a táblázatban
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["felhnev"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["vallnev"] . "</td>";
            echo "<td>" . $row["kapcstarto"] . "</td>";
            echo "<td>" . $row["telefonszam"] . "</td>";
            echo "<td>" . $row["online"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "Nincs elérhető felhasználói profil.";
    }
    $conn->close();*/
    ?>
</table>

</body>
</html>