<?php
require_once("login_success.php"); // Controleer of de gebruiker is ingelogd
require_once 'dbconfig.php'; // Inclusie van de databaseconfiguratie

// Code voor het verwijderen van een record
if (isset($_REQUEST['del'])) {
    // Haal het ID van de rij op die moet worden verwijderd
    $uid = intval($_GET['del']);
    // SQL-query om het record te verwijderen
    $sql = "delete from spelers WHERE id=:id";
    // Bereid de query voor
    $query = $dbh->prepare($sql);
    // Bind de parameter (ID van de speler)
    $query->bindParam(':id', $uid, PDO::PARAM_STR);
    // Voer de query uit
    $query->execute();
    // Toon een melding na succesvolle verwijdering
    echo "<script>alert('Record Updated successfully');</script>";
    // Redirect naar de indexpagina
    echo "<script>window.location.href='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Overzicht Spelers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS voor styling -->
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
    <!-- Logout knop -->
    <div id="goback">
        <button style="position:absolute; right:10px; top:10px; z-index: 100;" onclick="goBack()" type="button" class="btn btn-dark">Logout</button>
    </div>

    <!-- Container voor de inhoud -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3>Overzicht Spelers</h3>
                <hr />
                <!-- Knop om een nieuwe speler toe te voegen -->
                <a href="insert.php"><button class="btn btn-primary">Voeg een nieuwe speler toe</button></a>
                <div class="table-responsive">
                    <!-- Tabel met spelersgegevens -->
                    <table id="mytable" class="table table-bordred table-striped">
                        <thead>
                            <th>#</th> <!-- ID van de speler -->
                            <th>achternaam</th> <!-- Achternaam van de speler -->
                            <th>voornaam</th> <!-- Voornaam van de speler -->
                            <th>afbeelding</th> <!-- Afbeelding van de speler -->
                            <th>nationaliteit</th> <!-- Nationaliteit van de speler -->
                            <th>Aanpassen</th> <!-- Knop om de spelergegevens aan te passen -->
                            <th>Verwijderen</th> <!-- Knop om de speler te verwijderen -->
                        </thead>
                        <tbody>
                            <?php
                            // SQL-query om alle spelers op te halen
                            $sql = "SELECT * from spelers";
                            // Bereid de query voor
                            $query = $dbh->prepare($sql);
                            // Voer de query uit
                            $query->execute();
                            // Haal de resultaten op
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            // Controleer of er records zijn gevonden
                            if ($query->rowCount() > 0) {
                                // Loop door de resultaten en toon ze in de tabel
                                foreach ($results as $result) {
                            ?>
                                    <tr>
                                        <!-- Toon het ID van de speler -->
                                        <td><?php echo htmlentities($result->id); ?></td>
                                        <!-- Toon de achternaam van de speler -->
                                        <td><?php echo htmlentities($result->achternaam); ?></td>
                                        <!-- Toon de voornaam van de speler -->
                                        <td><?php echo htmlentities($result->voornaam); ?></td>
                                        <!-- Toon de afbeelding van de speler -->
                                        <td><img style="height: 40px; width: auto" src="../images/<?php echo $result->afbeelding; ?>"> </td>
                                        <!-- Toon de nationaliteit van de speler -->
                                        <td><?php echo htmlentities($result->nationaliteit); ?></td>
                                        <!-- Knop om de spelergegevens aan te passen -->
                                        <td><a href="update.php?id=<?php echo htmlentities($result->id); ?>"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></a></td>
                                        <!-- Knop om de speler te verwijderen -->
                                        <td><a href="index.php?del=<?php echo htmlentities($result->id); ?>"><button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');"><span class="glyphicon glyphicon-trash"></span></button></a></td>
                                    </tr>
                            <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Functie om terug te gaan naar de logoutpagina
        function goBack() {
            window.location.href = "./logout.php";
        }
    </script>
</body>
</html>