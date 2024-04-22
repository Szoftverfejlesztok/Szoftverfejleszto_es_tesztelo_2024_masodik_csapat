<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 
class ProfileException extends Exception{}
if (!isset($_SESSION["user"])){
    header("location:index.php");    
    exit;
}


function generateTable($dbconn){
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

                        $form .= '<label>Árus/Cég neve: *</label>';
                        $form .= '<input type="text" name="name_company" id="name_company" required value="';
                        $form .= $row["name_company"]; 
                        $form .= '"><br>';

                        $form .= '<label>E-mail cím: *</label>';
                        $form .= '<input type="email" name="email" required id="email" value="';
                        $form .= $row["email"]; 
                        $form .= '"><br>';
                        
                        $form .= '<label>Kapcsolattartó: </label>';
                        $form .= '<input type="text" name="contact" id="contact" value="';
                        $form .= $row["contact"]; 
                        $form .= '"><br>';
                        
                        $form .= '<label>Telefonszám: * <br>(pl.: 06301234567)</label>';
                        $form .= '<input type="tel" name="telephone" id="contact" required pattern="^06[0-9]{9}$" value="';
                        $form .= $row["telephone"]; 
                        $form .= '"><br>';

                        $form .= '<label>Online elérhetőség: <br>(pl.: https://www.pelda.com)</label>';
                        $form .= '<input type="url" name="online_availability" id="online_availability" value="';
                        $form .= $row["online_availability"]; 
                        $form .= '"><br>';

                        $form .= '<input type="submit" value="Módosít" name="submitModosit"><br><br>';
                        $form .= '</form>';
                        return $form;
                    }
                }

}
function generateTable2($dbconn){
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

                    $form .= '<label>Felhasználónév: *</label>';
                    $form .= '<input type="text" name="user_name" id="user_name" readonly value="';
                    $form .= $row["user_name"]; 
                    $form .= '"><br>';

                    $form .= '<label>Jelenlegi jelszó: *</label>';
                    $form .= '<input type="password" name="password" required id="password"><br>';

                    $form .= '<label>Új jelszó: *</label>';
                    $form .= '<input type="password" name="password_new1" required id="password_new1"><br>';

                    $form .= '<label>Jelszó megerősítése: *</label>';
                    $form .= '<input type="password" name="password_new2" required id="password_new2"><br>';

                    $form .= '<input type="submit" value="Módosít" name="submitModosit2">';
                    $form .= '</form>';
                    return $form;
                }
            }
}
function updateUserProfile ($email, $name_company, $contact, $telephone, $online_availability, $dbconn){
        if (!empty($dbconn))
        {
            $sql = "UPDATE userdata SET email =:email, name_company =:name_company, contact =:contact, telephone =:telephone, online_availability =:online_availability WHERE user_id=:user_id";
            $query = $dbconn->prepare($sql);
            $query->bindValue("email", strtolower($email), PDO::PARAM_STR);
            $query->bindValue("name_company", $name_company, PDO::PARAM_STR);
            $query->bindValue("contact", $contact, PDO::PARAM_STR);
            $query->bindValue("telephone", $telephone, PDO::PARAM_STR);
            $query->bindValue("online_availability", $online_availability, PDO::PARAM_STR);
            $query->bindValue("user_id", $_SESSION["user"]["user_id"], PDO::PARAM_STR);
            $query->execute(); 
        }
}

function updatePassword ($password, $password_new1, $password_new2, $dbconn){
    if (!empty($dbconn))
    {
       if ($password_new1 != $password_new2) 
       {
        throw new ProfileException("Az új jelszó nem egyezik meg a jelszó megerősítésével!");
       }
       $sql = "SELECT password, user_id FROM  userdata WHERE user_name=:felhasznalonev";
       $query = $dbconn->prepare($sql);
       $query->bindValue("felhasznalonev", $_SESSION["user"]["user_name"], PDO::PARAM_STR);
       $query->execute();
       $user = $query->fetch(PDO::FETCH_ASSOC); //kiolvassuk az adatokat
        if (!password_verify($password,$user["password"])){
            throw new ProfileException("Hibás jelszó");
        } 
        $sql = "UPDATE userdata SET password=:password WHERE user_id=:user_id";
        $query = $dbconn->prepare($sql);
        $query->bindValue("password", password_hash($password_new1, null), PDO::PARAM_STR);
        $query->bindValue("user_id", $_SESSION["user"]["user_id"], PDO::PARAM_STR);
        $query->execute();
    }
}

if (isset($_POST["submitModosit"]) && !empty($dbconn)){   
    try {
        $email= trim($_POST["email"]); 
        $name_company= trim($_POST["name_company"]);
        $contact= trim($_POST["contact"]);
        $telephone= trim($_POST["telephone"]);   
        $online_availability= trim($_POST["online_availability"]);
        updateUserProfile($email, $name_company, $contact, $telephone, $online_availability, $dbconn);
        $msg = "Sikeres profil módosítás";
    } catch(ProfileException $e){
        $error = "Hiba lépett fel a profilmódostás közben.".  $e->getMessage();
    } catch (PDOException $e){
        $error = "Adatbázis hiba: " . $e->getMessage(); 
    }  catch (Exception $e) {
        $error = "Hiba lépett fel:" . $e->getMessage();
    }
 
}
if (isset($_POST["submitModosit2"]) && !empty($dbconn)){   
    
    try {
        $password= trim($_POST["password"]); 
        $password_new1= trim($_POST["password_new1"]); 
        $password_new2= trim($_POST["password_new2"]); 
        updatePassword($password, $password_new1, $password_new2, $dbconn);  
        $msg = "Sikeres jelszó módosítás";  
    } catch(ProfileException $e){
        $error = "Hiba lépett fel a jelszómódosítás közben.".$e->getMessage();
    } catch (PDOException $e){
        $error = "Adatbázis hiba: ".$e->getMessage(); 
    }  catch (Exception $e) {
        $error = "Hiba lépett fel:".$e->getMessage();
    }
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
            <main role="main" class="col-lg-9 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3">
                    <h2>Profil adatok</h2>
                    <div class="profile-page">
                        <div class="form profile-form">
                            <h3>Személyes adatok</h3>
                            <?php
                            try {
                                $form = generateTable($dbconn);
                                if ($form != null){
                                    echo $form;
                                } else {
                                    echo "Nincs elérhető felhasználói profil.";
                                }
                            } catch (PDOException $e){
                                $error = "Lekérdezési hiba: ".$e->getMessage();
                            } catch (Exception $e){
                                $error = "Hiba lépett fel a profil adatok lekérése közben: ".$e->getMessage();
                            }
       
                            ?>
                             <h3>Felhasználói adatok</h3>
                            <?php
                             try {
                                $form = generateTable2($dbconn);
                                if ($form != null){
                                    echo $form;
                                } else {
                                    echo "Nincs elérhető felhasználói profil.";
                                }
                            } catch (PDOException $e){
                                $error = "Lekérdezési hiba: ".$e->getMessage();
                            } catch (Exception $e){
                                $error = "Hiba lépett fel a belépési adatok lekérése közben: ".$e->getMessage();
                            }
                            ?>
                            </table>
                        </div>
                    </div> 
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