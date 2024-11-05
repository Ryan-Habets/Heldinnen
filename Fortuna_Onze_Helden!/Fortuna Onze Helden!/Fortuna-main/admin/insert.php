<?php
require_once("login_success.php");
// include database connection file
require_once 'dbconfig.php';
if (isset($_POST['insert'])) {
    // Posted Values  
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $seizoenen = $_POST['seizoenen'];
    $nationaliteit = $_POST['nationaliteit'];
    if (!empty($_POST['geboortedatum'])) {
        $geboortedatum = $_POST['geboortedatum'];
        $geboortedatum = date("Y-m-d", strtotime($geboortedatum));
    } else {
        $geboortedatum = null;
    }
    $geboorteplaats = $_POST['geboorteplaats'];
    if (!empty($_POST['sterfdatum'])) {
        $sterfdatum = $_POST['sterfdatum'];
        $sterfdatum = date("Y-m-d", strtotime($sterfdatum));
    } else {
        $sterfdatum = null;
    }
    $positie = $_POST['positie'];
    $debuut = $_POST['debuut'];
    $ookgespeeldvoor = $_POST['ookgespeeldvoor'];
    $bijzonderheden = $_POST['bijzonderheden'];
    $gespeeldvoor = $_POST['gespeeldvoor'];

    $image_file = $_FILES["file"]["name"];
    $type = $_FILES["file"]["type"];
    $size = $_FILES["file"]["size"];
    $temp = $_FILES["file"]["tmp_name"];

    $path = "../images/" . $image_file; //path to upload to
    $pieces = explode("/", $type);
    if (empty($pieces[1])) {
        $pieces[1] = "png";
    }
    if (!empty($_FILES["file"]["name"])) {
        $newFileName = newFileName($pieces[1]);
        move_uploaded_file($temp, "../images/" . $newFileName);
    } else {
        $newFileName = null;
    }
    // Query for Insertion
    $sql = "INSERT INTO spelers(voornaam,achternaam,seizoenen,gespeeldbij,afbeelding,nationaliteit,geboortedatum,geboorteplaats,sterfdatum,positie,debuut,ookgespeeldvoor,bijzonderheden) VALUES(:vn,:an,:sz,:gv,:afb,:nat,:gebd,:geb,:stf,:po,:deb,:ogv,:bz)";
    //Prepare Query for Execution
    $query = $dbh->prepare($sql);
    // Bind the parameters
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
    // Query Execution
    $query->execute();
    // Check that the insertion really worked. If the last inserted id is greater than zero, the insertion worked.
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        // Message for successfull insertion
        echo "<script>alert('Record inserted successfully');</script>";
        echo "<script>window.location.href='index.php'</script>";
    } else {
        // Message for unsuccessfull insertion
        echo "<script>alert('Something went wrong. Please try again');</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}
function guidv4($data = null)
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
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
    <title>PHP CURD Operation using PDO Extension </title>
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
                    <input type="text" name="debuut" class="form-control" maxlength="10">
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
                <div class="col-md-8"><b>Gespeeld voor</b><br>
                    <select id="gespeeldvoor" name="gespeeldvoor">
                        <option value="1">Fortuna Sittard</option>
                        <option value="2">Fortuna 54</option>
                        <option value="3">Sittardia</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top:1%">
                <div class="col-md-8">
                    <input type="submit" name="insert" value="Opslaan">
                </div>
            </div>
        </form>
    </div>
    </div>
</body>
</html>
<script>
    function goBack() {
        window.history.back();
    }
</script>