<?php
// Adatbázis kapcsolódás
require_once("dbconnect.php"); 
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_tablazat.css"></head>
<body> 
<h2>Termékkategória kereső</h2>
    <form method="GET" action="keres.php">
        <label for="keres"></label>
        <input type="text" name="keres" id="keres" placeholder="Termékkategória">
        <button type="submit">Keresés</button>
    </form>

<?php

 
if(isset($_GET['keres'])){
# az isset függvény segítségével megvizsgáljuk,hogy létezik-e a GET tömbben lévő 'keres' kulcs
    $keres = $_GET['keres']; 
 
    if(!empty($keres)){
        # ellenőrizzük nem-e üres a kapott változó
        $keres = trim($keres); # eltávolítjuk a szóközt az elejéről és végéről
        

        // sql lekérdezés
        $sqlKeres1 = ("SELECT u.name_company, p.place_number, d.date 
        FROM userdata u, kinalat k, termek t, place p, date_vasar d, reservation r 
        WHERE u.user_id = k.user_id 
        AND t.termek_id = k.termek_id 
        AND u.user_id = r.user_id 
        AND p.place_id = r.place_id 
        AND d.date_id = r.date_id 
        AND t.termek_kategoria LIKE '%$keres%';");
        $queryKeres1 = $dbconn->prepare($sqlKeres1);
        $queryKeres1->execute();



        
        if($queryKeres1->rowCount() > 0){
            #amennyiben van találat kiírjuk
                echo 'Találatok a '.$keres.' termékkategóriára:';
                echo "<br><table border='1' id='keresEredmeny'>";
                echo "<br><tr><th>Árus</th><th>Vásár időpontja</th><th>Foglalt hely száma</th></tr>";
                while($row = $queryKeres1->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr><td>".$row["name_company"]."</td><td>".$row["date"]."</td><td>".$row["place_number"]."</td></tr>";
                }
                echo "</table>";
        }else{
                echo 'Nincs találat';
        }
        
    }else{
    echo 'Üres keresőmező';
    # esetleg visszairányítás: 
    //header('Location: kereso.html');
    }
    
}else{
    echo 'Kérem írja be a keresett terméket!';
}


?>
<script>
document.addEventListener("DOMContentLoaded", function() {
const keres = document.getElementById('keres');
const keresEredmeny =document.getElementById('keresEredmeny');

    keres.addEventListener('click', function() {
        keresEredmeny.classList.add("hidden");
    });

});

</script>
</body>
</html>

