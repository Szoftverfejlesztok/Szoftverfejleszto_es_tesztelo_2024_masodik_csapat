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
    <title>Árusok listája</title>
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
            <main role="main" class="ml-sm-auto col-lg-10 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                    <div class="container mt-3">
                        <?php 
                        $error = "";
                        $msg = "";

                        try{
                          // Kiállítók lekérdezése
                          $sqlKiallitok = "SELECT name_company, product_description, online_availability, telephone, email FROM userdata WHERE status = 1 ORDER BY name_company;";
                          $queryKiallitok = $dbconn->prepare($sqlKiallitok);
                          $queryKiallitok->execute();
                        
                          //A kiállítók kilistázása
                            if(!empty($dbconn)){
                              $table = "";
                              if ($queryKiallitok->rowCount()>0){
                                  $table .= "<div class='sellers'><table>\n";
                                  $table .="<tr><th>Árus neve</th><th>Tevékenységi kör</th><th>Telefonszám</th><th>Online elérhetőség</th></tr><br>\n";
                              while ($row = $queryKiallitok->fetch(PDO::FETCH_ASSOC)){
                                   $table .= "<tr><td>{$row["name_company"]}</td><td>{$row["product_description"]}</td><td>{$row["telephone"]}</td><td>{$row["online_availability"]}<br>{$row["email"]}</td></tr>\n";
                              }
                              $table .= "</table></div>\n";
                              }
                            }
                          }catch(PDOException $e){
                            $error = "Lekérdezési hiba: ".$e->getMessage();
                          } catch (Exception $e) {
                            $error = "Hiba történt az árusok lekérése közben: ".$e->getMessage(); 
                          }
                          
                          if (!empty ($table)){
                            echo $table;
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>
</html>
