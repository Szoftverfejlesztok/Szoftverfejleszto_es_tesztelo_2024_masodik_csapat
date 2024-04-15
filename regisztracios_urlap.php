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

        // További validációk a cég név, kapcsolattartó, telefonszám és online elérhetőség esetén...

        return true;
    }

    function isValidEmail(email) {
        // Egyszerű email formátum validálás regex segítségével
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
</script>
</head>
<body>
    <fieldset>
        <h3>Regisztráció</h3>
        <form onsubmit="return validateForm()">
            <label for="user_name">Felhasználónév:</label>
            <input type="text" id="user_name" name="user_name" placeholder="Felhasználónév"><br>

            <label for="email">E-mail cím:</label>
            <input type="email" id="email" name="email" placeholder="E-mail"><br>

            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password"><br>

            <label for="password_conf">Jelszó megerősítés:</label>
            <input type="password" id="password_conf" name ="password_conf"><br>

            <label for="name_company">Cég név:</label>
            <input type="text" id="name_company" name="name_company" placeholder="Cég neve"><br>

            <label for="contact">Kapcsolattartó:</label>
            <input type="text" id="contact" name="contact" placeholder="Kapcsolattartó"><br>

            <label for="telephone">Telefonszám:</label>
            <input type="tel" id="telephone" name="telephone" placeholder="pl.: 06701111333"><br>

            <label for="online_availability">Online elérhetőség:</label>
            <input type="text" id="online_availability" name="online_availability" placeholder=""><br>

            <input type="submit" value="Küldés" name="submitRegisztral">
        </form>
    </fieldset>
   <!-- <fieldset>
    <h3>Regisztráció</h3>
        <label>Felhasználónév</label> űrlap elem ID-ja-->
       <!-- <input type="text" name="user_name" id="user_name" placeholder="Felhasználónév"><br> --><!--name lehet azonos, az id nem  szerver oldalon a neve alapján kapjuk meg, id csak egyedi, a fornak meg kell egyezni az input id-jával-->
        <!--<label>E-mail cím</label>
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
    </fieldset> -->


    <!--szerver oldali validáció-->
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Felhasználónév ellenőrzése
    $username = $_POST["user_name"];
    if (empty($username)) {
        $errors[] = "A felhasználónév mező nem lehet üres.";
    }

    // Email cím ellenőrzése
    $email = $_POST["email"];
    if (empty($email)) {
        $errors[] = "Az email cím mező nem lehet üres.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Érvénytelen email cím formátum.";
    }

    // Jelszó ellenőrzése
    $password = $_POST["password"];
    if (empty($password)) {
        $errors[] = "A jelszó mező nem lehet üres.";
    }

    // Jelszó megerősítés ellenőrzése
    $confirmPassword = $_POST["password_conf"];
    if (empty($confirmPassword)) {
        $errors[] = "A jelszó megerősítés mező nem lehet üres.";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "A jelszó és a jelszó megerősítés nem egyezik meg.";
    }

    // Cég név ellenőrzése
    $companyName = $_POST["name_company"];
    // Itt lehetne további validációk hozzáadása, például minimális vagy maximális hossz ellenőrzése.

    // Kapcsolattartó ellenőrzése
    $contactPerson = $_POST["contact"];
    // Itt lehetne további validációk hozzáadása, például speciális karakterek engedélyezése vagy tiltása.

    // Telefonszám ellenőrzése
    $telephone = $_POST["telephone"];
    // Itt lehetne további validációk hozzáadása, például a telefonszám formátumának ellenőrzése.

    // Online elérhetőség ellenőrzése
    $onlineAvailability = $_POST["online_availability"];
    // Itt lehetne további validációk hozzáadása, például URL formátum ellenőrzése.

    // Ha van hiba, kiírjuk azokat
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    } else {
        // Ha nincs hiba, folytathatjuk a regisztráció feldolgozását vagy adatbázisba mentését.
        // Például: adatbázisba mentés, bejelentkeztetés stb.
        echo "<p>Sikeres regisztráció!</p>";
    }
}
?>


<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</body>
</html>
