<?php
session_start();

// Databaseconfiguratie
$host = "localhost";
$username = "root";
$password = "";
$database = "fortunamusea";
$message = "";

try {
    $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Controleer of het loginformulier is ingediend
    if (isset($_POST["login"])) {
        // Controleer of de gebruikersnaam en het wachtwoord zijn ingevuld
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>'; // Toon een foutmelding als velden leeg zijn
        } else {
            // SQL-query om de gebruiker op te zoeken op basis van de gebruikersnaam
            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $connect->prepare($query); // Bereid de query voor
            $statement->execute(
                array(
                    'username' => $_POST["username"] // Bind de gebruikersnaam aan de query
                )
            );
            $results = $statement->fetchAll(PDO::FETCH_OBJ); // Haal alle resultaten op als objecten
            $count = $statement->rowCount(); // Tel het aantal gevonden records

            // Debugging: Print het wachtwoord uit de database
            foreach ($results as $result) {
                echo $result->password;
            }

            // Controleer of er gebruikers zijn gevonden
            if ($count > 0) {
                foreach ($results as $result) {
                    // Debugging: Log het gehashte wachtwoord uit de database
                    error_log("Database password hash: " . $result->password);
                    // Debugging: Log het ingevoerde wachtwoord
                    error_log("Entered password: " . $_POST["password"]);

                    // Controleer of het ingevoerde wachtwoord overeenkomt met het gehashte wachtwoord
                    if (password_verify($_POST["password"], $result->password)) {
                        $_SESSION["username"] = $_POST["username"]; // Sla de gebruikersnaam op in de sessie
                        header("location:index.php"); // Redirect naar de indexpagina
                    } else {
                        $message = '<label>Wrong password</label>'; // Toon een foutmelding bij een verkeerd wachtwoord
                    }
                }
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage(); // Sla de foutmelding op als er een databasefout optreedt
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div id="goback">
    <!-- Knop om terug te gaan naar de vorige pagina -->
    <button style="position:absolute; right:10px; top:10px;" onclick="goBack()" type="button" class="btn btn-dark">Ga Terug</button>
</div>
<body>
    <br />
    <div class="container" style="width:500px;">
        <?php
        // Toon een fout- of succesbericht als de variabele $message is ingesteld
        if (isset($message)) {
            echo '<label class="text-danger">' . $message . '</label>';
        }
        ?>
        <h3>Login Page</h3><br />
        <p id="demo">-</p>
        <!-- Loginformulier -->
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" class="form-control" /> <!-- Invoerveld voor gebruikersnaam -->
            <br />
            <label>Password</label>
            <input type="password" name="password" class="form-control" /> <!-- Invoerveld voor wachtwoord -->
            <br />
            <input type="submit" name="login" class="btn btn-info" value="Login" /> <!-- Login knop -->
        </form>
    </div>
    <br />
</body>
</html>
<script>
    // Javascript voor automatische redirect
    var start = 30; // Aantal seconden voordat de redirect plaatsvindt
    document.getElementById("demo").innerHTML = "redirect after " + start + " seconds";
    // Update de countdown elke seconde
    var x = setInterval(function() {
        start--;
        document.getElementById("demo").innerHTML = "redirect after " + start + " seconds";
        if (start <= 0) {
            window.location.href = '../pages/index.php'; // Redirect naar de indexpagina
        }
    }, 1000);

    // Functie om terug te gaan naar de vorige pagina
    function goBack() {
        window.location.href = "../pages/index.php";
    }
</script>