
<?php
$error = "";
$msg = "";
  // Kiállítók lekérdezése
  $sqlKiallitok = "SELECT photo, name_company, product_description, online_availability FROM userdata;";
  $queryKiallitok = $dbconn->prepare($sqlKiallitok);
  $queryKiallitok->execute();

  //A kiállítók kilistázása
  try{
    if(!empty($dbconn)){
        $table = "";
        if ($queryKiallitok->rowCount()>0){
            $table .= "<table>\n";
            $table .="<tr><th></th><th>Kiállító neve</th><th>Tevékenységi kör</th><th>Elérhetőség</th></tr>\n";
        while ($row = $queryKiallitok->fetch(PDO::FETCH_ASSOC)){
             $table .= "<tr><td>{$row["photo"]}</td><td>{$row["name_company"]}</td><td>{$row["product_description"]}</td><td>{$row["online_availability"]}</td></tr>\n";
        }
        }
    }
  }catch(PDOException $e){
    $error = "Lekérdezési hiba: ".$e->getMessage();
  }
  if (!empty ($table)){
    echo $table;
  }
?>
    
