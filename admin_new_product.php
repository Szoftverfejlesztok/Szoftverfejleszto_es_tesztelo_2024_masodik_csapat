<?php
$error = "";        // hibakezelés
$msg = ""; 

class ProductException extends Exception{}

require_once("dbconnect.php");

session_start(); //olyan helyen legyen, ami minden oldalra be van require-olva, pl header, footer. De csak egyszer!
/* if (!isset($_SESSION["user"])){
    header("location:/index.php");   //? 
} */


function addNewProduct($termek_kategoria, $dbconn){

    try{
        if (empty($termek_kategoria)){
            throw new ProductException("Kérem, írja be az új termékkategóriát!");
        }
        $sql = "INSERT INTO termek (termek_kategoria) VALUES (:termek_kategoria)";
        $query = $dbconn->prepare($sql);
        $query->bindValue("termek_kategoria", $termek_kategoria, PDO::PARAM_STR);
        $query->execute();
        $msg = "Az új termékkategória bekerült az adatbázisba.";  
    }catch(ProductException $e){
        $error = "Hiba lépett fel az új kategória létrehozása közben.".$e->getMessage();
    }catch (PDOException $e){
        $error = "Adatbázis hiba: ".$e->getMessage(); 
        echo $e->getMessage();
    } 
}

function generateTable($dbconn){
    try {
        if (!empty($dbconn)){
            $sql = "SELECT termek_kategoria FROM termek";
            // a futtatandó sql utasítás
            $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
            $query->execute();  // lekérdezés futtatása
            $table = "";
            if ($query->rowCount()>0){  // a visszaadott sorok száma
                $table .= "<table>\n";
                $table .= "<tr><th>Termék kategória: </th></tr>";
                $rowNumber = 0;
                while ($row = $query->fetch(PDO::FETCH_ASSOC)){ // az eredmény kiolvasása soronként egy asszociatív tömbbe
                    $rowNumber++; 
                    if ($rowNumber%2==0){
                        $table .= "<tr class=csikoz1><td>";
                    }
                    else {
                        $table .= "<tr class=csikoz2><td>";
                    }
                $table .= $row["termek_kategoria"];
                $table .= "</td></tr>\n";
                }
                $table .= "</table>\n";
                return $table;
            }
        }
    } catch (PDOException $e){
        $error = "Lekérdezési hiba: ".$e->getMessage();
    }
}

if (isset($_POST["submitHozzaad"]) && !empty($dbconn)){    
    $termek_kategoria= trim($_POST["termek_kategoria"]);
    addNewProduct($termek_kategoria, $dbconn);

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminisztrátor - Új termékkategóriák felvétele</title>
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
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <h2>Új termékkategóriák felvétele</h2><br><br>

                    <input type="text" id="termek_kategoria" name="termek_kategoria" placeholder="Új termékkategória"><br><br>
                    
                    <button type="submit" name="submitHozzaad">Hozzáadás</button><br><br>
                    <?php
                    $tableNew = generateTable($dbconn);
                    if (!empty($tableNew)){
                        echo $tableNew;
                    } else echo "Nincs megjeleníthető termékkategória felvéve!";

                    ?>

                </form>
            </div>
        </main>
    </div>
</div>
<?php   
                    if (!empty($error)){
                    echo "<p class=\"error\">$error</p>\n";
                    }
                    if (!empty($msg)){
                    echo "<p class=\"msg\">$msg</p>\n";
                    }
                ?>
<?php require_once("footer.html"); ?>




    
</body>
</html>



    
</body>
</html>