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
            <main role="main" class="ml-sm-auto col-lg-9 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                    <div class="container mt-3">
                    
                    <?php
                    try {
                        $user_id = $_SESSION["user"]["user_id"];

                        $sqlJovahagy = "SELECT p.place_number, d.date FROM place p, date_market d, userdata u, reservation r 
                        WHERE '$user_id' = u.user_id 
                        AND u.user_id = r.user_id
                        and p.place_id = r.place_id 
                        and d.date_id = r.date_id 
                        and r.status = 0 
                        ORDER by d.date DESC;";

                        $sqlElfogad = "SELECT p.place_number, d.date FROM place p, date_market d, userdata u, reservation r 
                        WHERE '$user_id' = u.user_id 
                        AND u.user_id = r.user_id
                        and p.place_id = r.place_id 
                        and d.date_id = r.date_id 
                        and r.status = 1 
                        ORDER by d.date DESC;";

                        $sqlTorol = "SELECT p.place_number, d.date FROM place p, date_market d, userdata u, reservation r 
                        WHERE '$user_id' = u.user_id 
                        AND u.user_id = r.user_id
                        and p.place_id = r.place_id 
                        and d.date_id = r.date_id 
                        and r.status = 2
                        ORDER by d.date DESC;";

                        $queryJovahagy = $dbconn->prepare($sqlJovahagy);
                        $queryJovahagy->execute();

                        $queryElfogad = $dbconn->prepare($sqlElfogad);
                        $queryElfogad->execute();

                        $queryTorol = $dbconn->prepare($sqlTorol);
                        $queryTorol->execute();

                        if($queryJovahagy->rowCount() > 0){
                            #amennyiben van találat kiírjuk - jóváhagyásra vár
                                echo '<h4>Jóváhagyásra váró helyfoglalási kérelmek:</h4>';
                                echo "<div class='search'><table>";
                                echo "<br><tr><th>Vásár dátuma</th><th>Foglalt hely sorszáma</th></tr>";
                                while($row = $queryJovahagy->fetch(PDO::FETCH_ASSOC)){
                                    echo "<tr><td>".$row["date"]."</td><td>".$row["place_number"]."</td></tr>";
                                }
                                echo "</table><br><br></div>";}
                        else{
                            echo "<h4>Nincs jóváhagyásra váró helyfoglalási kérelem!</h4>";
                        }
                        if($queryElfogad->rowCount() > 0){
                            #amennyiben van találat kiírjuk - jóváhagyott
                                echo '<h4>Jóváhagyott helyfoglalási kérelmek:</h4>';
                                echo "<div class='search'><table>";
                                echo "<br><tr><th>Vásár dátuma</th><th>Foglalt hely sorszáma</th></tr>";
                                while($row = $queryElfogad->fetch(PDO::FETCH_ASSOC)){
                                    echo "<tr><td>".$row["date"]."</td><td>".$row["place_number"]."</td></tr>";
                                }
                                echo "</table><br><br></div>";}
                        else{
                            echo "<h4>Nincs jóváhagyott helyfoglalási kérelem!</h4>";
                        }               
                        if($queryTorol->rowCount() > 0){
                            #amennyiben van találat kiírjuk - törölt
                                echo '<h4>Törölt helyfoglalási kérelmek:</h4>';
                                echo "<div class='search'><table>";
                                echo "<br><tr><th>Vásár dátuma</th><th>Foglalt hely sorszáma</th></tr>";
                                while($row = $queryTorol->fetch(PDO::FETCH_ASSOC)){
                                        echo "<tr><td>".$row["date"]."</td><td>".$row["place_number"]."</td></tr>"; }
                                echo "</table><br><br></div>";}

                        else {
                            echo '<h4>Nincs törölt helyfoglalási kérelem!</h4>';
                        }
                    
                    } catch (PDOException $e){
                        $error = "Adatbázis hiba: ".$e->getMessage(); 
                    } catch (Exception $e) {
                        $error = "Hiba történt a helyfoglalási kérelmek lekérése közben: ".$e->getMessage(); 
                    }
                    ?>




         
                    </div>
            </main>
        </div>
    </div>

    <?php 
        displayMessages($error, $msg);
        require_once("footer.html"); 
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>
</html>
