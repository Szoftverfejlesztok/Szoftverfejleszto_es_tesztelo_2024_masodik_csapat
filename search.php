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
    <h2></h2>

    <?php require_once("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once("sidebar_menu.php"); ?>


            <!-- Main Content -->
            <main role="main" class="ml-sm-auto col-lg-8 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3">
                    <?php
                    if(isset($_GET['keres'])){ //az isset függvény segítségével megvizsgáljuk,hogy létezik-e a GET tömbben lévő 'keres' kulcs
                        $keres = $_GET['keres']; 
                        $keres = trim($keres); //eltávolítjuk a szóközt az elejéről és végéről
                        $keres = htmlspecialchars($keres, ENT_QUOTES, 'UTF-8'); // HTML és JS kódok eltávolítása
                        if(!empty($keres)){ //ellenőrizzük nem-e üres a kapott változó
                            try {
                                //sql lekérdezés - jövőbeli vásárok
                                $sqlKeres1 = ("SELECT t.product_category, u.name_company, p.place_number, d.date 
                                FROM userdata u, product_range k, product t, place p, date_market d, reservation r 
                                WHERE u.user_id = k.user_id 
                                AND t.product_id = k.product_id 
                                AND u.user_id = r.user_id 
                                AND p.place_id = r.place_id 
                                AND d.date_id = r.date_id 
                                AND t.product_category LIKE '%$keres%'
                                AND DATE(d.date) >= CURRENT_DATE
                                AND r.status = 1 
                                ORDER by d.date;;");
                                $queryKeres1 = $dbconn->prepare($sqlKeres1);
                                $queryKeres1->execute();

                                //sql lekérdezés - múltbeli vásárok
                                $sqlKeres2 = ("SELECT t.product_category, u.name_company, p.place_number, d.date 
                                FROM userdata u, product_range k, product t, place p, date_market d, reservation r 
                                WHERE u.user_id = k.user_id 
                                AND t.product_id = k.product_id 
                                AND u.user_id = r.user_id 
                                AND p.place_id = r.place_id 
                                AND d.date_id = r.date_id 
                                AND t.product_category LIKE '%$keres%'
                                AND DATE(d.date) <= CURRENT_DATE 
                                AND r.status = 1
                                ORDER by d.date;");
                                $queryKeres2 = $dbconn->prepare($sqlKeres2);
                                $queryKeres2->execute();

                                $talalat = false;
                                if($queryKeres1->rowCount() > 0){
                                //amennyiben van találat kiírjuk
                                    echo '<h4>Találatok "'.$keres.'" termékkategóriára a következő vásárokban:</h4>';
                                    echo "<div class='search'><table>";
                                    echo "<br><tr><th>Termék kategória</th><th>Árus</th><th>Vásár időpontja</th><th>Foglalt hely száma</th></tr>";
                                    while($row = $queryKeres1->fetch(PDO::FETCH_ASSOC)){
                                        echo "<tr><td>".$row["product_category"]."</td><td>".$row["name_company"]."</td><td>".$row["date"]."</td><td>".$row["place_number"]."</td></tr>";
                                        }
                                    echo "</table><br><br></div>";
                                    $talalat = true;    
                                }
                                if($queryKeres2->rowCount() > 0){
                                    //amennyiben van találat kiírjuk
                                    echo '<h4>Találatok "'.$keres.'" termékkategóriára az elmúlt vásárokban:</h4>';
                                    echo "<div class='search'><table>";
                                    echo "<br><tr><th>Termék kategória</th><th>Árus</th><th>Vásár időpontja</th><th>Foglalt hely száma</th></tr>";
                                    while($row = $queryKeres2->fetch(PDO::FETCH_ASSOC)){
                                        echo "<tr><td>".$row["product_category"]."</td><td>".$row["name_company"]."</td><td>".$row["date"]."</td><td>".$row["place_number"]."</td></tr>";
                                    }
                                    echo "</table></div>";
                                    $talalat = true;
                                }

                                if(!$talalat){
                                    echo '<h4>Nincs találat "'.$keres.'" termékkategóriára!</h4><br>';
                                }
                            } catch (PDOException $e){
                                $error = "Adatbázis hiba: ".$e->getMessage(); 
                            } catch (Exception $e) {
                                $error = "Hiba történt a keresés közben: ".$e->getMessage(); 
                            }
                        }else{
                            echo '<h4>Üres keresőmező</h4>';
                        }
                    }else{
                        echo 'Kérem írja be a keresett terméket!';
                    }
                    ?>
                    <div id="market_picture">
                        <img src="market_picture2.png" alt="piac kép">
                     
                    </div>

                </div>
            </main>
        </div>
    </div>

    <?php 
        displayMessages($error, $msg);
        require_once("footer.html"); 
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


</body>
</html>
