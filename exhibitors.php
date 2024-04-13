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
                    <div class="container mt-3">

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
                                  $table .= "<div class='exhibitors'><table>\n";
                                  $table .="<tr><th>Kiállító neve</th><th>Tevékenységi kör</th><th>Elérhetőség</th></tr><br>\n";
                              while ($row = $queryKiallitok->fetch(PDO::FETCH_ASSOC)){
                                   $table .= "<tr><td>{$row["name_company"]}</td><td>{$row["product_description"]}</td><td>{$row["online_availability"]}</td></tr>\n";
                              }
                              $table .= "</table></div>\n";
                              }
                            }
                          }catch(PDOException $e){
                            $error = "Lekérdezési hiba: ".$e->getMessage();
                          }
                          if (!empty ($table)){
                            echo $table;
                          }
                        ?>
         
                    </div>
            </main>
        </div>
    </div>

    <?php require_once("footer.html"); ?>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>
</html>
