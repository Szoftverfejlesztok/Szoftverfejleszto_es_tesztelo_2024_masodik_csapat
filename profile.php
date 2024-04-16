<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 
if (!isset($_SESSION["user"])){
    header("location:index.php");    
    exit;
}


function generateTable($dbconn){
        try {
            if (!empty($dbconn)){
                $sql = "SELECT user_name, email, name_company, contact, telephone, online_availability FROM userdata WHERE user_id=:user_id";  // a futtatandó sql utasítás
                $query = $dbconn->prepare($sql);  // előkészített lekérdezés létrehozása
                $query->bindValue("user_id", $_SESSION["user"]["user_id"], PDO::PARAM_STR);
                $query->execute();  // lekérdezés futtatása
                $form = "";
                    if ($query->rowCount()>0){  // a visszaadott sorok száma
                        $row = $query->fetch(PDO::FETCH_ASSOC); 

                        $form .= '<form action="' . $_SERVER["PHP_SELF"] . '" method="POST">';
                        $form .= '<fieldset>';

                        $form .= '<label>Felhasználónév: </label>';
                        $form .= '<input type="text" name="user_name" id="user_name" readonly value="';
                        $form .= $row["user_name"]; 
                        $form .= '"><br>';

                        $form .= '<label>E-mail cím: </label>';
                        $form .= '<input type="text" name="email" id="email" value="';
                        $form .= $row["email"]; 
                        $form .= '"><br>';

                        $form .= '<label>Jelszó: </label>';
                        $form .= '<input type="password" name="password" id="password"><br>';

                        $form .= '<label>Jelszó újra: </label>';
                        $form .= '<input type="password" name="password_new" id="password_new"><br>';

                        $form .= '<label>Cég név: </label>';
                        $form .= '<input type="text" name="name_company" id="name_company" value="';
                        $form .= $row["name_company"]; 
                        $form .= '"><br>';
                        
                        $form .= '<label>Kapcsolattartó: </label>';
                        $form .= '<input type="text" name="contact" id="contact" value="';
                        $form .= $row["contact"]; 
                        $form .= '"><br>';
                        
                        $form .= '<label>Telefonszám: </label>';
                        $form .= '<input type="tel" name="telephone" id="contact" value="';
                        $form .= $row["telephone"]; 
                        $form .= '"><br>';

                        $form .= '<label>Online elérhetőség: </label>';
                        $form .= '<input type="text" name="online_availability" id="online_availability" value="';
                        $form .= $row["online_availability"]; 
                        $form .= '"><br>';

                        $form .= '<input type="submit" value="Módosít" name="submitModosit">';
                        $form .= '</form>';
                        return $form;
                    }
                }
        } catch (PDOException $e){
            echo "Lekérdezési hiba: ".$e->getMessage();
            $error = "Lekérdezési hiba: ".$e->getMessage();
        }
}
function updateUserProfile ($email, $name_company, $contact, $telephone, $online_availability, $dbconn){
    try {
        if (!empty($dbconn))
        {
            $sql = "UPDATE userdata SET email =:email, name_company =:name_company, contact =:contact, telephone =:telephone, online_availability =:online_availability WHERE user_id=:user_id";
            $query = $dbconn->prepare($sql);
            $query->bindValue("email", $email, PDO::PARAM_STR);
            $query->bindValue("name_company", $name_company, PDO::PARAM_STR);
            $query->bindValue("contact", $contact, PDO::PARAM_STR);
            $query->bindValue("telephone", $telephone, PDO::PARAM_STR);
            $query->bindValue("online_availability", $online_availability, PDO::PARAM_STR);
            $query->bindValue("user_id", $_SESSION["user"]["user_id"], PDO::PARAM_STR);
            $query->execute();
            $msg = "Sikeres profil módosítás."; 
            echo '<script type ="text/JavaScript">';  
            echo 'alert("Sikeres profil módosítás")';  
            echo '</script>'; 
        } else {$error = "Nincs adatbázis kapcsolat";}
    } catch (PDOException $e){
        echo "Lekérdezési hiba: ".$e->getMessage();
        $error = "Lekérdezési hiba: ".$e->getMessage();
    }
}
if (isset($_POST["submitModosit"]) && !empty($dbconn)){   
    $email= trim($_POST["email"]); 
    $name_company= trim($_POST["name_company"]);
    $contact= trim($_POST["contact"]);
    $telephone= trim($_POST["telephone"]);   
    $online_availability= trim($_POST["online_availability"]);
    updateUserProfile($email, $name_company, $contact, $telephone, $online_availability, $dbconn);
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználói profil</title>
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
                    <h2>Profil adatok</h2>
                    <div class="profile-page">
                        <div class="form">
                            <?php
                            $form = generateTable($dbconn);
                            if ($form != null){
                                echo $form;
                            } else {
                                echo "Nincs elérhető felhasználói profil.";
                            }
                            ?>
                            </table>
                        </div>
                    </div> 
                </div>
            </main>
        </div>
    </div>

    <?php require_once("footer.html"); ?>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>
</html>