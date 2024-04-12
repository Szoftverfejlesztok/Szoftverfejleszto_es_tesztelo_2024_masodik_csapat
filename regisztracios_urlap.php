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
    <title>Regisztráció</title>
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
         <!--<style>
    input:not([type=checkbox]){ /*mindenre ugyanaz kivéve a type checkboxra */ 
        display: block;
        margin-bottom: 10px;
    }
</style>-->

<?php
if (isset($_POST["submitRegisztral"]) && !empty($dbconn)){    
    // Űrlapról érkező adatok beolvasása
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], null);
    $name_company = $_POST['name_company'];
    $contact = $_POST['contact'];
    $telephone = $_POST['telephone'];
    $online_availability = $_POST['online_availability'];

    // SQL lekérdezés előkészítése és végrehajtása az adatok mentésére
    $sqlRegistration = "INSERT INTO userdata (user_name, password, name_company, contact, telephone, email, photo, online_availability, product_description, moderator, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $queryRegistration = $dbconn->prepare($sqlRegistration);
    $queryRegistration->execute([$user_name, $password, $name_company, $contact, $telephone, $email, "TBD", $online_availability, "TBD", "0", "0"]);
}
?>

<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
    <fieldset>
    <h3>Regisztráció</h3>
        <label>Felhasználónév</label> <!--űrlap elem ID-ja-->
        <input type="text" name="user_name" id="user_name" placeholder="Felhasználónév"><br> <!--name lehet azonos, az id nem  szerver oldalon a neve alapján kapjuk meg, id csak egyedi, a fornak meg kell egyezni az input id-jával-->
        <label>E-mail cím</label>
        <input type="email" name="email" id="email"placeholder="E-mail"><br>
        <label>Jelszó</label>
        <input type="password" name="password"  id="password"><br>
        <label>Jelszó megerősítés</label>
        <input type="password" id="password_conf"><br>
        <label>Cég név</label> 
        <input type="text" name="name_company"  id="name_company" placeholder="Cég neve"><br>
        <label>Kapcsolattartó</label> 
        <input type="text" name="contact"  id="contact" placeholder="Kapcsolattartó"><br>
        <label>Telefonszám</label> 
        <input type="tel" name="telephone"  id="telephone" placeholder="pl.: 06701111333"><br>
        <label>Online elérhetőség</label> 
        <input type="text" name="online_availability"  id="online_availability" placeholder=""><br>    
        <input type="submit" value="Küldés" name="submitRegisztral">
    </fieldset>
</form>


<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</body>
</html>
