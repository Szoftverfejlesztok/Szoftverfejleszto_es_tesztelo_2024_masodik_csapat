<?php

class FairException extends Exception{}

function getNextDate($dbconn){
    if (!empty($dbconn)){
        $sql = "SELECT date FROM date_market WHERE is_next=1";
        // a futtatandó sql utasítás
        $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
        $query->execute();  // lekérdezés futtatása
        if ($query->rowCount()>0){  // a visszaadott sorok száma
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){ // az eredmény kiolvasása soronként egy asszociatív tömbbe
                return $row["date"];
            }
        }
        else {
            return null;
        }
    }
}

function addNextTime($newVasarDate, $dbconn){
        if (empty($newVasarDate)){
            throw new FairException("Kérem, adjon meg egy vásári időpontot!");
        }
        $sql = "INSERT INTO date_market (date) VALUES (:newVasarDate)";
        $query = $dbconn->prepare($sql);
        $query->bindValue("newVasarDate", $newVasarDate, PDO::PARAM_STR);
        $query->execute();
}

function generateSelect($dbconn){
    if (!empty($dbconn)){
        $sql = "SELECT date, date_id from date_market where date >= now() ORDER BY date";  // a futtatandó sql utasítás
        $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
        $query->execute();  // lekérdezés futtatása
        $select = "";
        if ($query->rowCount()>0){  // a visszaadott sorok száma
            $select .= '<select name="date_id">\n';
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){ // az eredmény kiolvasása soronként egy asszociatív tömbbe
                $select .= '<option required value= ';
                $select .=$row["date_id"];
                $select .='>';
                $select .=$row["date"];
                $select .="</option>";
            }
            $select .= "</select>\n";
            return $select;
        }
    }
}

function setNextDate($dateId, $dbconn){
    if (empty($dateId)){
        throw new FairException("Jelölje ki a beállítani kívánt vásári dátumot!");
    }
    $sqlInaktiv = "UPDATE date_market SET is_next = 0"; //a tábla összes elemének nullára állítja az is_next mezőjét
    $queryInaktiv = $dbconn->prepare($sqlInaktiv);
    $queryInaktiv->execute();
    $sqlAktiv = "UPDATE date_market SET is_next = 1 WHERE date_id=:date_id"; //a kiválasztottnál 1-re állítja
    $queryAktiv = $dbconn->prepare($sqlAktiv);
    $queryAktiv->bindValue("date_id", $dateId, PDO::PARAM_STR);
    $queryAktiv->execute();   
}

if (isset($_POST["submitHozzaad"]) && !empty($dbconn)){    
    try {
        $newVasarDate= trim($_POST["newVasarDate"]);
        addNextTime($newVasarDate, $dbconn);
        $msg = "Az új vásári dátum bekerült az adatbázisba.";  
    } catch(FairException $e){
        $error = "Hiba lépett fel az új vásári dátum létrehozása közben.".$e->getMessage();
    } catch (PDOException $e){
        if( $e->getCode() == 23000) {
            $error = "Ilyen dátum már szerepel az adatbázisban!";
        } else {
            $error = "Adatbázis hiba: ".$e->getMessage(); 
        }
    } 
}
if (isset($_POST["submitKivalaszt"]) && !empty($dbconn)){    
    try {
        $dateId= trim($_POST["date_id"]);
        setNextDate($dateId, $dbconn);
        $msg = "Sikeres módosítás.";  
    } catch(FairException $e){
        $error = "Hiba lépett fel a dátum beállítása közben: ".$e->getMessage();
    }catch (PDOException $e){
        $error = "Adatbázis hiba: ".$e->getMessage(); 
    }
}
?>

<h2>A következő vásár időpontja:</h2><br>
<div>
    <div class="kiemel">
        <h2>
            <?php
            try {
                $nextTime = getNextDate($dbconn);
                if (!empty($nextTime)){
                    echo $nextTime;
                    if (isset($_SESSION["user"]) && ($_SESSION["user"]["moderator"] == 1))
                    {
                    echo '<br><a href="#" id="nextDatePopUp">Szerkesztés</a>';
                    }
                } else echo "Nincs dátum beállítva";
            } catch (PDOException $e){
                $error = "Lekérdezési hiba: ".$e->getMessage();
            }
            ?>
        </h2> 
    </div>
</div>
<div id="popup-dialog" class="popup">
  <div class="popup-content">
    <span class="close-btn" onclick="closePopup()">&times;</span>
    <h2>A következő vásár időpontja legyen:</h2>
    <form  action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
        <label for="newVasarDate">Új vásár dátum hozzáadása:</label>
        <input type="date" id="newVasarDate" name="newVasarDate" required>
        <button type="submit" name="submitHozzaad">Hozzáad</button><br><br>
    </form>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
        <label for="date">Jelölje ki a következő vásárt!</label>
        <?php
        try {
            echo generateSelect($dbconn);
        } catch (PDOException $e){
            $error = "Lekérdezési hiba: ".$e->getMessage();
        }
        ?>
        <br><br>
        <button type="submit" name="submitKivalaszt">Kiválaszt</button><br>
    </form>
  </div>
</div>



