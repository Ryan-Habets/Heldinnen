<?php
require_once("login_success.php");
require_once 'dbconfig.php';

if (isset($_POST['update'])) {
    // Haal het ID van de speler op
    $userid = intval($_GET['id']);

    // Waarden die zijn gepost vanuit het formulier
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $seizoenen = $_POST['seizoenen'];
    $nationaliteit = $_POST['nationaliteit'];

    // Controleer of de geboortedatum is ingevuld en converteer deze naar het juiste formaat
    if (!empty($_POST['geboortedatum'])) {
        $geboortedatum = $_POST['geboortedatum'];
        $geboortedatum = date("Y-m-d", strtotime($geboortedatum));
    } else {
        $geboortedatum = null; // Stel in op null als er geen geboortedatum is opgegeven
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
    $gespeeldbij = $_POST['gespeeldbij'];
    $rugnummer = $_POST['rugnummer'];
    $url = $_POST['url'];

    // Controleer of er een afbeelding is geüpload
    $filename = $_POST['filename'];
    if (empty($filename)) {
        $filename = newFileName("png"); // Genereer een nieuwe bestandsnaam als er geen afbeelding is opgegeven
    }

    if (!empty($_FILES["file"]["name"])) {
        // Haal eigenschappen van het geüploade bestand op
        $image_file = $_FILES["file"]["name"];
        $type = $_FILES["file"]["type"];
        $size = $_FILES["file"]["size"];
        $temp = $_FILES["file"]["tmp_name"];

        // SQL-query om de gegevens bij te werken inclusief afbeelding
        $sql = "update spelers set voornaam=:vn,achternaam=:an,seizoenen=:sz,gespeeldbij=:gb,afbeelding=:afb,nationaliteit=:nat,geboortedatum=:gebd,geboorteplaats=:geb,sterfdatum=:stf,positie=:po,debuut=:deb,ookgespeeldvoor=:ogv,bijzonderheden=:bz,rugnummer=:rn,URL=:url where id=:uid";
        $query = $dbh->prepare($sql); // Bereid de query voor

        // Bind de parameters aan de query
        $query->bindParam(':vn', $voornaam, PDO::PARAM_STR);
        $query->bindParam(':an', $achternaam, PDO::PARAM_STR);
        $query->bindParam(':sz', $seizoenen, PDO::PARAM_STR);
        $query->bindParam(':gb', $gespeeldbij, PDO::PARAM_STR);
        $query->bindParam(':afb', $filename, PDO::PARAM_STR);
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
        $query->bindParam(':uid', $userid, PDO::PARAM_STR);

        // Verplaats het geüploade bestand naar de juiste locatie
        move_uploaded_file($temp, "../images/" . $filename);
    } else {
        // SQL-query om de gegevens bij te werken zonder afbeelding
        $sql = "update spelers set voornaam=:vn,achternaam=:an,seizoenen=:sz,gespeeldbij=:gb,nationaliteit=:nat,geboortedatum=:gebd,geboorteplaats=:geb,sterfdatum=:stf,positie=:po,debuut=:deb,ookgespeeldvoor=:ogv,bijzonderheden=:bz,rugnummer=:rn,URL=:url where id=:uid";
        $query = $dbh->prepare($sql); // Bereid de query voor

        // Bind de parameters aan de query
        $query->bindParam(':vn', $voornaam, PDO::PARAM_STR);
        $query->bindParam(':an', $achternaam, PDO::PARAM_STR);
        $query->bindParam(':sz', $seizoenen, PDO::PARAM_STR);
        $query->bindParam(':gb', $gespeeldbij, PDO::PARAM_STR);
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
        $query->bindParam(':uid', $userid, PDO::PARAM_STR);
    }

    // Voer de query uit
    $query->execute();

    // Toon een melding na succesvolle update
    echo "<script>alert('Record Updated successfully');</script>";
    // Redirect naar de indexpagina
    echo "<script>window.location.href='index.php'</script>";
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