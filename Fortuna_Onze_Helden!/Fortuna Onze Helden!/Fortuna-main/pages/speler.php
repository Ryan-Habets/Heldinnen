<html>
<head>
  <link rel="stylesheet" href="../css/speler.css">
  <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
  <link href="../bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
// Databaseverbinding
require_once('../includes/connection.php');
$id = $_GET['ID'];

// SQL-query om gegevens van de speler op te halen
$sql = "SELECT * from spelers WHERE id=$id";
$query = $dbh->prepare($sql); // Bereid de query voor
$query->execute(); // Voer de query uit
$results = $query->fetchAll(PDO::FETCH_OBJ); // Haal de resultaten op als objecten

// Controleer of er records zijn gevonden
if ($query->rowCount() > 0) {
  $switch = true; // Variabele om de eerste record te onderscheiden
  foreach ($results as $result) {
    // Bouw een array met de gegevens van de speler
    if ($switch == true) {
      $array = [[$result->id, $result->voornaam, $result->achternaam, $result->seizoenen, $result->gespeeldbij, $result->afbeelding, $result->nationaliteit, $result->geboortedatum, $result->geboorteplaats, $result->sterfdatum, $result->positie, $result->debuut, $result->ookgespeeldvoor, $result->bijzonderheden, $result->rugnummer, $result->URL]];
      $switch = false;
    } else {
      array_push($array, [$result->id, $result->voornaam, $result->achternaam, $result->seizoenen, $result->gespeeldbij, $result->afbeelding, $result->nationaliteit, $result->geboortedatum, $result->geboorteplaats, $result->sterfdatum, $result->positie, $result->debuut, $result->ookgespeeldvoor, $result->bijzonderheden, $result->rugnummer, $result->URL]);
    }
  }
}

// Controleer of de array niet leeg is
if (!empty($array)) {
  foreach ($array as list($id, $voornaam, $achternaam, $seizoenen, $gespeeldbij, $afbeelding, $nationaliteit, $geboortedatum, $geboorteplaats, $sterfdatum, $positie, $debuut, $ookgespeeldvoor, $bijzonderheden, $rugnummer, $video_url)) {
?>
    <section id="grid_section">
      <div id="goback">
        <!-- Knop om terug te gaan naar de vorige pagina -->
        <button onclick="goBack()" type="button" class="btn btn-dark">Ga Terug</button>
      </div>
      <div class="container text-center">
        <div class="row">
          <!-- Eerste blok: Naam en bijzonderheden -->
          <div class="col-lg-4 col-md-6">
            <div id="blok1">
              <?php echo "<h1>$voornaam $achternaam</h1>"; ?>
              <hr>
              <?php echo "<span>$bijzonderheden</span>"; ?>
            </div>
          </div>
          <!-- Tweede blok: Video Player -->
          <div class="col-lg-4 col-md-6">
            <div class="video-container">
              <?php if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) { 
                // Zorg ervoor dat de URL correct is voor embedding
                $embed_url = str_replace('watch?v=', 'embed/', $video_url);
                if (strpos($embed_url, 'youtube.com') !== false) {
                  $embed_url .= '?autoplay=1';
                } else {
                  $embed_url .= '?autoplay=1';
                }
              ?>
                <!-- YouTube iframe -->
                <iframe id="videoPlayer" src="<?php echo $embed_url; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
              <?php } else { ?>
                <!-- Lokale video -->
                <video id="videoPlayer" controls>
                  <source src="<?php echo $video_url; ?>" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
              <?php } ?>
            </div> 
          </div>
          <!-- Derde blok: Logo -->
          <div class="col-lg-4 col-md-2">
            <div id="blok2">
              <img id="image" src="../resources/logo.png" style="width: 200px;"></img>
            </div>
          </div>
          <!-- Vierde blok: Afbeelding van de speler -->
          <div class="col-lg-4 col-md-6">
            <div id="blok3">
              <?php if (!empty($afbeelding)) { ?>
                <img id="player_img" onclick="play()" src="../images/<?php echo $afbeelding; ?>" style="height: 280px;" style="width: 100%;"></img>
              <?php }; ?>
            </div>
          </div>
          <!-- Vijfde blok: Statistieken en persoonlijke info -->
          <div class="col-lg-8 col-md-12">
            <div id="blok4">
              <div class="row">
                <!-- Statistieken -->
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
                  <?php if (!empty($rugnummer)) {
                    echo "<p> Rugnummer: $rugnummer</p>";
                  } ?>
                </div>
                <!-- Persoonlijke info -->
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
          <!-- Dynamische CSS op basis van gespeeldbij -->
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
  document.addEventListener('DOMContentLoaded', (event) => {
    // Event listener voor toetsenbordacties
    document.addEventListener("keydown", function(e) {
      if (e.key === "Escape") {
        goBack(); // Roep de goBack functie aan om terug te gaan naar de vorige pagina
      }
      if (e.code === "Space") {
          // Wanneer de spatiebalk wordt ingedrukt, speel de video opnieuw af
          var video = document.getElementById('videoPlayer');
          
          // Controleer of het video-element bestaat
          if (video) {
              // Controleer of het video-element een iframe is (bijvoorbeeld een YouTube-video)
              if (video.tagName.toLowerCase() === 'iframe') {
                  // Haal de huidige bron (URL) van de iframe op
                  var iframeSrc = video.src;
                  
                  // Voeg autoplay toe aan de URL om de video automatisch af te spelen
                  video.src = iframeSrc + (iframeSrc.indexOf('?') > -1 ? '&' : '?') + 'autoplay=1';
              } else {
                  // Als het geen iframe is, speel de video direct af
                  video.play();
              }
          }
      }
    });
  });

  // Functie om terug te gaan naar de indexpagina
  function goBack() {
    window.location.href = "./index.php";
  }
</script>