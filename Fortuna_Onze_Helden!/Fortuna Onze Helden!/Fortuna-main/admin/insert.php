<?php
require_once("login_success.php"); 
require_once 'dbconfig.php';

// Controleer of het formulier is ingediend
if (isset($_POST['insert'])) {
    // Haal de waarden op die zijn gepost vanuit het formulier
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $seizoenen = $_POST['seizoenen'];
    $nationaliteit = $_POST['nationaliteit'];

    // Controleer of de geboortedatum is ingevuld en converteer deze naar het juiste formaat
    if (!empty($_POST['geboortedatum'])) {
        $geboortedatum = $_POST['geboortedatum'];
        $geboortedatum = date("Y-m-d", strtotime($geboortedatum));
    } else {
        $geboortedatum = null; //  Stel in op null als er geen geboortedatum is opgegeven
    }

    // Haal de geboorteplaats op
    $geboorteplaats = $_POST['geboorteplaats'];

    // Controleer of de sterfdatum is ingevuld en converteer deze naar het juiste formaat
    if (!empty($_POST['sterfdatum'])) {
        $sterfdatum = $_POST['sterfdatum'];
        $sterfdatum = date("Y-m-d", strtotime($sterfdatum));
    } else {
        $sterfdatum = null; // Stel in op null als er geen sterfdatum is opgegeven
    }

    // Haal overige gegevens op
    $positie = $_POST['positie'];
    $debuut = $_POST['debuut'];
    $ookgespeeldvoor = $_POST['ookgespeeldvoor'];
    $bijzonderheden = $_POST['bijzonderheden'];
    $gespeeldvoor = $_POST['gespeeldvoor'];
    $rugnummer = $_POST['rugnummer'];
    $url = $_POST['url'];

    // Haal de afbeelding op die is geüpload
    $image_file = $_FILES["file"]["name"];
    $type = $_FILES["file"]["type"];
    $size = $_FILES["file"]["size"];
    $temp = $_FILES["file"]["tmp_name"];

    // Stel het pad in waar de afbeelding wordt opgeslagen
    $path = "../images/" . $image_file;
    $pieces = explode("/", $type);

    // Controleer het bestandstype en stel een standaardtype in als het leeg is
    if (empty($pieces[1])) {
        $pieces[1] = "png";
    }

    // Controleer of er een bestand is geüpload
    if (!empty($_FILES["file"]["name"])) {
        $newFileName = newFileName($pieces[1]); // Genereer een unieke bestandsnaam
        move_uploaded_file($temp, "../images/" . $newFileName); // Verplaats het bestand naar de juiste locatie
    } else {
        $newFileName = null; // Stel in op null als er geen bestand is geüpload
    }

    // SQL-query om de gegevens in de database in te voegen
    $sql = "INSERT INTO spelers(voornaam,achternaam,seizoenen,gespeeldbij,afbeelding,nationaliteit,geboortedatum,geboorteplaats,sterfdatum,positie,debuut,ookgespeeldvoor,bijzonderheden,rugnummer,URL) VALUES(:vn,:an,:sz,:gv,:afb,:nat,:gebd,:geb,:stf,:po,:deb,:ogv,:bz,:rn,:url)";
    $query = $dbh->prepare($sql); // Bereid de query voor

    // Bind de parameters aan de query
    $query->bindParam(':vn', $voornaam, PDO::PARAM_STR);
    $query->bindParam(':an', $achternaam, PDO::PARAM_STR);
    $query->bindParam(':sz', $seizoenen, PDO::PARAM_STR);
    $query->bindParam(':gv', $gespeeldvoor, PDO::PARAM_STR);
    $query->bindParam(':afb', $newFileName, PDO::PARAM_STR);
    $query->bindParam(':nat', $nationaliteit, PDO::PARAM_STR);
    $query->bindParam(':gebd', $geboortedatum, PDO::PARAM_STR);
    $query->bindParam(':geb', $geboorteplaats, PDO::PARAM_STR);
    $query->bindParam(':stf', $sterfdatum, PDO::PARAM_STR);
    $query->bindParam(':po', $positie, PDO::PARAM_STR);
    $query->bindParam(':deb', $debuut, PDO::PARAM_STR);
    $query->bindParam(':ogv', $ookgespeeldvoor, PDO::PARAM_STR);
    $query->bindParam(':bz', $bijzonderheden, PDO::PARAM_STR);
    $query->bindParam(':rn', $rugnummer, PDO::PARAM_STR);
    $query->bindParam(':url', $url, PDO::PARAM_STR);

    // Voer de query uit
    $query->execute();

    // Controleer of de invoeging succesvol was
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo "<script>alert('Record inserted successfully');</script>";
        echo "<script>window.location.href='index.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}

// Functie om een unieke bestandsnaam te genereren
function guidv4($data = null)
{
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// Functie om een nieuwe bestandsnaam te genereren op basis van het type
function newFileName($type)
{
    $newFileName = guidv4();
    $newFileName .= ".";
    $newFileName .= $type;
    return $newFileName;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP CURD Operation using PDO Extension</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
</head>
<div id="goback">
    <button style="position:absolute; right:10px; top:10px;" onclick="goBack()" type="button" class="btn btn-dark">Ga Terug</button>
</div>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Nieuwe Speler Toevoegen</h3>
                <hr />
            </div>
        </div>
        <!-- Formulier voor het toevoegen van een nieuwe speler -->
        <form name="insertrecord" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4"><b>Voornaam</b>
                    <input type="text" name="voornaam" class="form-control" required>
                </div>
                <div class="col-md-4"><b>Achternaam</b>
                    <input type="text" name="achternaam" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>Seizoenen</b>
                    <input type="text" name="seizoenen" class="form-control">
                </div>
                <div class="col-md-4"><b>Afbeelding</b>
                    <input type="file" name="file" class="form-control" maxlength="10">
                    <small class="text-muted">Bij het behouden van de huidige afbeelding pas dit niet aan.</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>Nationaliteit</b>
                    <input type="text" name="nationaliteit" class="form-control">
                </div>
                <div class="col-md-4"><b>Geboortedatum</b>
                    <input type="date" name="geboortedatum" class="form-control" maxlength="10">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>Geboorteplaats</b>
                    <input type="text" name="geboorteplaats" class="form-control">
                </div>
                <div class="col-md-4"><b>Sterfdatum</b>
                    <input type="date" name="sterfdatum" class="form-control" maxlength="10">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"><b>Positie</b>
                    <input type="text" name="positie" class="form-control">
                </div>
                <div class="col-md-4"><b>Debuut</b>
                    <input type="text" name="debuut" class="form-control" maxlength="50">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8"><b>Ook Gespeeld Voor</b>
                    <textarea class="form-control" name="ookgespeeldvoor"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8"><b>Bijzonderheden</b>
                    <textarea class="form-control" name="bijzonderheden"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <input type="hidden" id="gespeeldvoor" name="gespeeldvoor" value="1">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8"><b>Rugnummer</b>
                    <input type="text" name="rugnummer" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8"><b>URL</b>
                    <input type="url" name="url" class="form-control">
                </div>
            </div>
            <br>
            <div class="row" style="margin-top:1%">
                <div class="col-md-8">
                    <input type="submit" name="insert" value="Opslaan">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<script>
    // Functie om terug te gaan naar de vorige pagina
    function goBack() {
        window.history.back();
    }
</script>