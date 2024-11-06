<html>
<head>
    <link rel="stylesheet" href="../css/speler.css">
    <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
    <link href="../bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
// DB credentials.
require_once('../includes/connection.php'); //Connection file to enstablish a connection
$id = $_GET['ID'];
$sql = "SELECT * from spelers WHERE id=$id";
//Prepare the query:
$query = $dbh->prepare($sql);
//Execute the query:
$query->execute();
//Assign the data which you pulled from the database (in the preceding step) to a variable.
$results = $query->fetchAll(PDO::FETCH_OBJ);
// For serial number initialization
if ($query->rowCount() > 0) {
    //In case that the query returned at least one record, we can echo the records within a foreach loop:
    $switch = true;
    foreach ($results as $result) {
        if ($switch == true) {
            $array = [[$result->id, $result->voornaam, $result->achternaam, $result->seizoenen, $result->gespeeldbij, $result->afbeelding, $result->nationaliteit, $result->geboortedatum, $result->geboorteplaats, $result->sterfdatum, $result->positie, $result->debuut, $result->ookgespeeldvoor, $result->bijzonderheden]];
            $switch = false;
        } else {
            array_push($array, [$result->id, $result->voornaam, $result->achternaam, $result->seizoenen, $result->gespeeldbij, $result->afbeelding, $result->nationaliteit, $result->geboortedatum, $result->geboorteplaats, $result->sterfdatum, $result->positie, $result->debuut, $result->ookgespeeldvoor, $result->bijzonderheden]);
        }
    }
};
if (!empty($array)) {
    foreach ($array as list($id, $voornaam, $achternaam, $seizoenen, $gespeeldbij, $afbeelding, $nationaliteit, $geboortedatum, $geboorteplaats, $sterfdatum, $positie, $debuut, $ookgespeeldvoor, $bijzonderheden)) {
?>
        <section id="grid_section">
            <div id="goback">
                <button id="backButton" onclick="goBack()" type="button" class="btn btn-dark">Ga Terug</button>
            </div>
            <div class="container text-center">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div id="blok1">
                            <?php echo "<h1>$voornaam $achternaam</h1>"; ?>
                            <hr>
                            <?php echo "<span>$bijzonderheden</span>"; ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div id="blok2">
                            <?php if($gespeeldbij == 1){ ?>
                                <img id="image" src="../resources/logo.png" style="width: 200px;"></img>
                            <?php } ?>
                            <?php if($gespeeldbij == 2){ ?>
                                <img id="image" src="../resources/sittardia.png" style="width: 200px;"></img>
                            <?php } ?>
                            <?php if($gespeeldbij == 3){ ?>
                                <img id="image" src="../resources/54.png" style="width: 200px;"></img>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div id="blok3">
                            <?php if (!empty($afbeelding)) { ?>
                                <img id="player_img" onclick="play()" id="image" src="../images/<?php echo $afbeelding; ?>" style="width: 250px;"></img>
                            <?php }; ?>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div id="blok4">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <h1>Statistieken</h1>
                                    <hr>
                                    <?php if (!empty($seizoenen)) {
                                        echo "<p> Seizoenen gespeeld: $seizoenen</p>";
                                    } ?>
                                    <?php if (!empty($positie)) {
                                        echo "<p> Positie: $positie</p>";
                                    } ?>
                                    <?php if (!empty($debuut)) {
                                        echo "<p> Debuut: $debuut</p>";
                                    } ?>
                                    <?php if (!empty($ookgespeeldvoor)) {
                                        echo "<p> Ook gespeeld voor: $ookgespeeldvoor</p>";
                                    } ?>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <h1>Persoonlijke Info</h1>
                                    <hr>
                                    <?php if (!empty($voornaam)) {
                                        echo "<p> Voornaam: $voornaam</p>";
                                    } ?>
                                    <?php if (!empty($achternaam)) {
                                        echo "<p> Achternaam: $achternaam</p>";
                                    } ?>
                                    <?php if (!empty($nationaliteit)) {
                                        echo "<p> Nationaliteit: $nationaliteit</p>";
                                    } ?>
                                    <?php if (!empty($geboortedatum)) {
                                        $convertedGeboortedatum = date("d-m-Y", strtotime($geboortedatum));
                                        echo "<p> Geboortedatum: $convertedGeboortedatum</p>";
                                    } ?>
                                    <?php if (!empty($geboorteplaats)) {
                                        echo "<p> Geboorteplaats: $geboorteplaats</p>";
                                    } ?>
                                    <?php if (!empty($sterfdatum)) {
                                        if (!$sterfdatum == "") {
                                            $convertedSterfdatum = date("d-m-Y", strtotime($sterfdatum));
                                            echo "<p> Sterfdatum: $convertedSterfdatum</p>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($gespeeldbij == 1){ ?>
                        <link href="../css/fortunaSittard.css" rel="stylesheet">
                    <?php } ?>
                    <?php if($gespeeldbij == 2){ ?>
                        <link href="../css/fortuna54.css" rel="stylesheet">
                    <?php } ?>
                    <?php if($gespeeldbij == 3){ ?>
                        <link href="../css/sitardia.css" rel="stylesheet">
                    <?php } ?>
                </div>
            </div>
        </section>
        <?php }
}; ?>
<style>
    /* body {
        background-color: #f8d000;
        color: white;
    } */
</style>
<script>
    // Function to go back to the previous page
    function goBack() {
        window.location.href = "./index.php";
    }

    // Add event listener for keydown event after DOM content is loaded
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('keydown', function(event) {
            console.log('Key pressed:', event.key); // Debugging line
            if (event.key === "Escape") {
                document.getElementById("backButton").click();
            }
        });
    });
</script>