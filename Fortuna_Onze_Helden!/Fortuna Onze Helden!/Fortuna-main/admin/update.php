<?php
require_once("login_success.php");
// include database connection file
require_once 'dbconfig.php';
if (isset($_POST['update'])) {
    // Get the userid
    $userid = intval($_GET['id']);
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
    $gespeeldbij = $_POST['gespeeldbij'];
    $rugnummer = $_POST['rugnummer'];
    $url = $_POST['url'];

    $filename = $_POST['filename'];
    if (empty($filename)) {
        echo $filename = newFileName("png");
    }

    //switch
    if (!empty($_FILES["file"]["name"])) {
        //File props
        $image_file = $_FILES["file"]["name"];
        $type = $_FILES["file"]["type"];
        $size = $_FILES["file"]["size"];
        $temp = $_FILES["file"]["tmp_name"];

        // Query for Query for Updation
        $sql = "update spelers set voornaam=:vn,achternaam=:an,seizoenen=:sz,gespeeldbij=:gb,afbeelding=:afb,nationaliteit=:nat,geboortedatum=:gebd,geboorteplaats=:geb,sterfdatum=:stf,positie=:po,debuut=:deb,ookgespeeldvoor=:ogv,bijzonderheden=:bz,rugnummer=:rn,URL=:url where id=:uid";
        //Prepare Query for Execution
        $query = $dbh->prepare($sql);
        // Bind the parameters
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

        move_uploaded_file($temp, "../images/" . $filename);
    } else {
        // Query for Query for Updation
        $sql = "update spelers set voornaam=:vn,achternaam=:an,seizoenen=:sz,gespeeldbij=:gb,nationaliteit=:nat,geboortedatum=:gebd,geboorteplaats=:geb,sterfdatum=:stf,positie=:po,debuut=:deb,ookgespeeldvoor=:ogv,bijzonderheden=:bz,rugnummer=:rn,URL=:url where id=:uid";
        //Prepare Query for Execution
        $query = $dbh->prepare($sql);
        // Bind the parameters
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
    // Query Execution
    $query->execute();
    // Mesage after updation
    echo "<script>alert('Record Updated successfully');</script>";
    // Code for redirection
    echo "<script>window.location.href='index.php'</script>";

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
    <title>Speler Aanpassen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
</head>

<body>
    <div id="goback">
        <button style="position:absolute; right:10px; top:10px;" onclick="goBack()" type="button" class="btn btn-dark">Ga Terug</button>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h3>Speler Aanpassen</h3>
                <hr />
            </div>
        </div>

        <?php
        // Get the userid
        $userid = intval($_GET['id']);
        $sql = "SELECT * from spelers where id=:uid";
        //Prepare the query:
        $query = $dbh->prepare($sql);
        //Bind the parameters
        $query->bindParam(':uid', $userid, PDO::PARAM_STR);
        //Execute the query:
        $query->execute();
        //Assign the data which you pulled from the database (in the preceding step) to a variable.
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        // For serial number initialization
        $cnt = 1;
        if ($query->rowCount() > 0) {
            //In case that the query returned at least one record, we can echo the records within a foreach loop:
            foreach ($results as $result) {
        ?>
                <form name="insertrecord" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <input type="hidden" name="filename" value="<?php echo htmlentities($result->afbeelding); ?>">
                        <div class="col-md-4"><b>Voornaam</b>
                            <input type="text" value="<?php echo htmlentities($result->voornaam); ?>" name="voornaam" class="form-control" required>
                        </div>
                        <div class="col-md-4"><b>Achternaam</b>
                            <input type="text" value="<?php echo htmlentities($result->achternaam); ?>" name="achternaam" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><b>Seizoenen</b>
                            <input type="text" value="<?php echo htmlentities($result->seizoenen); ?>" name="seizoenen" class="form-control">
                        </div>
                        <div class="col-md-4"><b>Afbeelding</b>
                            <input type="file" name="file" class="form-control" maxlength="10">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"><b>Nationaliteit</b>
                            <input type="text" value="<?php echo htmlentities($result->nationaliteit); ?>" name="nationaliteit" class="form-control">
                        </div>
                        <div class="col-md-4"><b>Geboortedatum</b>
                            <input type="date" value="<?php echo htmlentities($result->geboortedatum); ?>" name="geboortedatum" class="form-control" maxlength="10">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"><b>Geboorteplaats</b>
                            <input type="text" value="<?php echo htmlentities($result->geboorteplaats); ?>" name="geboorteplaats" class="form-control">
                        </div>
                        <div class="col-md-4"><b>Sterfdatum</b>
                            <input type="date" value="<?php echo htmlentities($result->sterfdatum); ?>" name="sterfdatum" class="form-control" maxlength="10">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"><b>Positie</b>
                            <input type="text" value="<?php echo htmlentities($result->positie); ?>" name="positie" class="form-control">
                        </div>
                        <div class="col-md-4"><b>Debuut</b>
                            <input type="text" value="<?php echo htmlentities($result->debuut); ?>" name="debuut" class="form-control" maxlength="10">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8"><b>Ook Gespeeld Voor</b>
                            <textarea class="form-control" name="ookgespeeldvoor"><?php echo htmlentities($result->ookgespeeldvoor); ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8"><b>Bijzonderheden</b>
                            <textarea class="form-control" name="bijzonderheden"><?php echo htmlentities($result->bijzonderheden); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" id="gespeeldbij" name="gespeeldbij" value="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8"><b>Rugnummer</b>
                            <input type="text" value="<?php echo htmlentities($result->rugnummer); ?>" name="rugnummer" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8"><b>URL</b>
                            <input type="url" value="<?php echo htmlentities($result->URL); ?>" name="url" class="form-control">
                        </div>
                    </div>
            <?php }
        } ?>

            <div class="row" style="margin-top:1%">
                <div class="col-md-8">
                    <input type="submit" name="update" value="Aanpassen">
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