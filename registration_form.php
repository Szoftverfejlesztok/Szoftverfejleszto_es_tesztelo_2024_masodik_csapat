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
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    fieldset {
        width: 50%;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    h3 {
        margin-top: 0;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"],
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        background-color: #4d4d4d;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    p.error {
        color: #ff0000;
        font-size: 14px;
        margin-top: 5px;
    }
</style>
</head>
<body>
    
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
    $sqlRegistration = "INSERT INTO userdata (user_name, password, name_company, contact, telephone, email, online_availability, product_description, moderator, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $queryRegistration = $dbconn->prepare($sqlRegistration);
    $queryRegistration->execute([$user_name, $password, $name_company, $contact, $telephone, $email, $online_availability, "TBD", "0", "0"]);
}
?>

<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">

<!-- Kliens oldali validáció-->
<script>
    function validateForm() {
        var username = document.getElementById("user_name").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("password_conf").value;
        var companyName = document.getElementById("name_company").value;
        var contactPerson = document.getElementById("contact").value;
        var telephone = document.getElementById("telephone").value;
        var onlineAvailability = document.getElementById("online_availability").value;
        var productDescription = document.getElementById("product_description").value;

        if (username === "") {
            alert("Kérlek add meg a felhasználónevet!");
            return false;
        }

        if (email === "") {
            alert("Kérlek add meg az email címed!");
            return false;
        } else if (!isValidEmail(email)) {
            alert("Érvénytelen email cím!");
            return false;
        }

        if (password === "") {
            alert("Kérlek add meg a jelszavad!");
            return false;
        }

        if (password !== confirmPassword) {
            alert("A jelszavak nem egyeznek!");
            return false;
        }

        if (productDescription === "") {
            alert("Kérlek válassz termék kategóriát!");
            return false;
        }

        // További validációk a cég név, kapcsolattartó, telefonszám és online elérhetőség esetén...

        return true;
    }

    function isValidEmail(email) {
        // Egyszerű email formátum validálás regex segítségével
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
</script>
 <!--szerver oldali validáció-->
 <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Felhasználónév ellenőrzése
    $username = $_POST["user_name"];
    if (strlen($username) < 4 || strlen($username) > 20) {
        $errors[] = "<span style='color: red;'>A felhasználónévnek 4 és 20 karakter között kell lennie!</span>";
    }
    if (empty($username)) {
        $errors[] = "<span style='color: red;'>A felhasználónév mező nem lehet üres!</span>";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $username)) {
        $errors[] = "<span style='color: red;'>A felhasználónévben csak betűk, számok és szóközök engedélyezettek!</span>";
    }

    // Email cím ellenőrzése
    $email = $_POST["email"];
    if (empty($email)) {
        $errors[] = "<span style='color: red;'>Az email cím mező nem lehet üres!</span>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "<span style='color: red;'>Érvénytelen email cím formátum!</span>";
    }

    // Jelszó ellenőrzése
    $password = $_POST["password"];
    if (empty($password)) {
        $errors[] = "<span style='color: red;'>A jelszó mező nem lehet üres!</span>";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $password)) {
        $errors[] = "<span style='color: red;'>A jelszóban csak betűk, számok és szóközök engedélyezettek!</span>";
    }

    // Jelszó megerősítés ellenőrzése
    $confirmPassword = $_POST["password_conf"];
    if (strlen($password) < 6 || strlen($password) > 50) {
        $errors[] = "<span style='color: red;'>A jelszónak 6 és 50 karakter között kell lennie!</span>";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $password)) {
        $errors[] = "<span style='color: red;'>A jelszóban csak betűk, számok és szóközök engedélyezettek!</span>";
    }
    if (empty($confirmPassword)) {
        $errors[] = "<span style='color: red;'>A jelszó megerősítés mező nem lehet üres!</span>";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "<span style='color: red;'>A jelszó és a jelszó megerősítés nem egyezik meg!</span>";
    }

    // Cég név ellenőrzése
    $companyName = $_POST["name_company"];
    if (strlen($companyName) < 5 || strlen($companyName) > 50) {
        $errors[] = "<span style='color: red;'>A cég névének 5 és 50 karakter között kell lennie!</span>";
    }
    

    // Kapcsolattartó ellenőrzése
    $contactPerson = $_POST["contact"];
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $contactPerson)) {
        $errors[] = "<span style='color: red;'>A kapcsolattartó személy nevében csak betűk, számok és szóközök engedélyezettek!</span>";
    }
    

    // Telefonszám ellenőrzése
    $telephone = $_POST["telephone"];
    if (!preg_match("/^06[0-9]{9}$/", $telephone)) {
        $errors[] = "<span style='color: red;'>Érvénytelen telefonszám formátum. Kérlek, használj 11 számjegyet, és az első két számjegy legyen 06!</span>";;
    }
    

    // Online elérhetőség ellenőrzése
    $onlineAvailability = isset($_POST["online_availability"]) ? $_POST["online_availability"] : "";
    if (!empty($onlineAvailability) && !filter_var($onlineAvailability, FILTER_VALIDATE_URL)) {
        $errors[] = "<span style='color: red;'>Az online elérhetőség mező érvénytelen URL formátumot tartalmaz!</span>";
    }
    

    //Termék kategória választás ellenőrzése
    $productDescription = $_POST["product_description"];
    if (empty($productDescription)) {
        $errors[] = "<span style='color: red;'>Kérlek, válassz egy termék leírást az opciók közül!</span>";
    }

    // Ha van hiba, kiírjuk azokat
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    } else {
        // Ha nincs hiba, folytathatjuk a regisztráció feldolgozását vagy adatbázisba mentését.
        // Például: adatbázisba mentés, bejelentkeztetés stb.
        echo "<script>window.onload = function() { alert('Sikeres regisztráció!'); }</script>";
    
    }
}

?>

    <fieldset>
        <h3>Regisztráció</h3>
        <form onsubmit="return validateForm()">
            <label for="user_name">Felhasználónév: *</label>
            <input type="text" id="user_name" name="user_name" placeholder="Felhasználónév"><br>

            <label for="email">E-mail cím: *</label>
            <input type="email" id="email" name="email" placeholder="E-mail"><br>

            <label for="password">Jelszó: *</label>
            <input type="password" id="password" name="password"><br>

            <label for="password_conf">Jelszó megerősítés: *</label>
            <input type="password" id="password_conf" name ="password_conf"><br>

            <label for="name_company">Cég név: *</label>
            <input type="text" id="name_company" name="name_company" placeholder="Cég neve"><br>

            <label for="contact">Kapcsolattartó:</label>
            <input type="text" id="contact" name="contact" placeholder="Kapcsolattartó"><br>

            <label for="telephone">Telefonszám: *</label>
            <input type="tel" id="telephone" name="telephone" placeholder="pl.: 06701111333"><br>

            <label for="online_availability">Online elérhetőség:</label>
            <input type="text" id="online_availability" name="online_availability" placeholder="pl.: https://www.facebook.com/"><br>

            <label>Termék kategória *</label> 
            <select name="product_description" id="product_description">
                <option value="">Válasszon termék kategóriát</option>
                <option value="ruha">Méz</option>
                <option value="szerszám">Kerti szerszám</option>
                <option value="méz">Vetőmag</option>
            </select><br>   
            <br>

            <input type="submit" value="Küldés" name="submitRegisztral">
        </form>
    </fieldset>


   

<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</body>
</html>
