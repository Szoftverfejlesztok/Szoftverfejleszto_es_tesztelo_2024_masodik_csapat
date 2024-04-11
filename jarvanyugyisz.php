
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
                <h1>Járványügyi szabályzat</h1>
<div id="kezdes">
    <h3>Madárinfluenza kereskedelmi információk</h3>

        Utolsó frissítés: 2024.02.07.<br><br>

        <b >FIGYELEM! </b>
</div>
<p>
Az alábbi táblázatban szereplő, hazánkkal szemben korlátozást bevezető harmadik országok esetében továbbra is érvényben vannak a korlátozások
 mindaddig, amíg az adott harmadik ország nem jelzi ennek ellenkezőjét. <br><br>

Minden harmadik ország saját hatáskörben dönt az importkorlátozások bevezetéséről vagy feloldásáról. Az ezzel kapcsolatos visszajelzésekkel az
 alábbi táblázat folyamatosan frissül. Abban az esetben, ha nem érhető el friss információ a célországgal kapcsolatban, javasoljuk, hogy az
  importőr partnerükön keresztül érdeklődjenek a célország központi hatóságánál. <br><br> <br>
<b>
Felhívjuk a figyelmet arra, hogy az alábbi információ mellett az adott termékre vonatkozó exportbizonyítványban foglalt követelményeknek is
teljesülniük kell, így a tervezett szállítmány indítása előtt javasoljuk ennek ellenőrzését is. A kiszállítás csak abban az esetben valósulhat
 meg, ha az exportbizonyítványban foglalt követelmények is teljesülnek, és az alább közölt, madárinfluenza miatt bevezetett korlátozások is
  lehetővé teszik azt. <br> <br>
Az alábbi információ csak tájékoztató jellegű, a járványügyi helyzet függvényében a korlátozások változhatnak, ezért a szállítások előtt
javasoljuk, hogy közvetlenül tájékozódjanak az aktuális helyzetről!</b></p>

<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>



                    <div class="container mt-3">
         
                    </div>
                </main>
        </div>
    </div>

    <?php require_once("footer.html"); ?>


    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


    
</body>
</html>