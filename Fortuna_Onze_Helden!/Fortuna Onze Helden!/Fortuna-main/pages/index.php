<html>
<head>
  <!-- Favicon en stylesheets -->
  <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
  <link rel="stylesheet" href="../css/kb.css">
  <link rel="stylesheet" href="../css/index.css">
  <link href="../bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- Logo met link naar admin login -->
<a href="../admin/pdo_login.php"><img src="../resources/fortuna_museam.jpg" alt="logo" style="width: 100px; position: absolute; margin-top: 5px; margin-left: 5px;"></a>
<div class="container">
  <div class="row text-center">
    <div class="col-lg-10">
      <!-- Introductie sectie -->
      <section class="py-5">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-8 mx-auto text-center">
              <h4 class="text-warning">Onze Heldinnen!</h4>
              <h2 class="display-5 fw-bold mt-2 mb-3 text-warning">Zoek voor een speler</h2>
              <p class="lead mb-4 text-warning">Zoek je favoriete speler op in de database. <br> Begin door hier onder een naam in te typen</p>
              <img class="mx-auto img-fluid" src="bootstrap5-plain-assets/images/blue-400-horizontal.png" alt="" data-removed="true">
              <hr>
              </ht>
            </div>
          </div>
        </div>
      </section>
      <!-- Zoekveld sectie -->
      <section>
        <div id="center" class="input-group mb-3">
          <span class="input-group-text bg-warning" id="basic-addon1"></span>
          <!-- Zoekveld met filterfunctie -->
          <input type="text" id="myInput2" onkeyup="filterFunction()" class="form-control" placeholder="Zoek een speler op naam..." aria-label="Username" aria-describedby="basic-addon1" autocomplete="off">
        </div>
        <!-- Suggesties tabel -->
        <div id="search_suggetion">
          <table id="myTable">
            <tbody id="tbo">
              <tr class="header">
                <th style="width:100%;">Naam</th>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </div>
    <!-- Logo sectie -->
    <div style="background-color: #FFC107;" class="col-lg-2">
      <img style="width: 100%; padding-top: 1rem; height: auto;" src="../resources/logo.png">
      <!-- <img style="width: 100%; padding-top: 1rem; height: auto;" src="../resources/54.png"> -->
        <!-- <img class="mb-3" style="width: 100%; height: auto;" src="../resources/sittardia.png"> -->
    </div>
  </div>
</div>
<!-- SVG achtergrond -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
  <path fill="#f8d000 " fill-opacity="1" d="M0,64L720,288L1440,256L1440,320L720,320L0,320Z"></path>
</svg>
<div id="svg_after_bg"></div>
<?php
// Databaseverbinding
require_once('../includes/connection.php'); //Connection file to enstablish a connection
$sql = "SELECT id,voornaam,achternaam from spelers"; //SQL Query
$query = $dbh->prepare($sql); //Prepare the query:
$query->execute(); //Execute the query:
$results = $query->fetchAll(PDO::FETCH_OBJ); //Assign the data which you pulled from the database (in the preceding step) to a variable.
if ($query->rowCount() > 0) {
  //In case that the query returned at least one record, we can echo the records within a foreach loop:
  $switch = true;
  foreach ($results as $result) {
    if ($switch == true) {
      $array = [[$result->id, $result->voornaam, $result->achternaam]];
      $switch = false;
    } else {
      array_push($array, [$result->id, $result->voornaam, $result->achternaam]);
    }
  }
};
?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Focus op het zoekveld
    const input = document.getElementById("myInput2");
    input.focus();
    let currentFocus = 0;

    // Event listener voor toetsenbordnavigatie
    input.addEventListener("keydown", function (e) {
      const rows = Array.from(document.querySelectorAll("#myTable tr:not(.header)"));
      const visibleRows = rows.filter(row => row.style.display !== "none");

      if (visibleRows.length > 0) {
        // Pijltje naar beneden
        if (e.key === "ArrowDown") {
          currentFocus = (currentFocus + 1) % visibleRows.length;
          updateActiveRow(visibleRows);
        // Pijltje naar boven
        } else if (e.key === "ArrowUp") {
          currentFocus = (currentFocus - 1 + visibleRows.length) % visibleRows.length;
          updateActiveRow(visibleRows);
        // Enter toets
        } else if (e.key === "Enter") {
          e.preventDefault();
          if (currentFocus >= 0 && visibleRows[currentFocus]) {
            visibleRows[currentFocus].querySelector("td").click();
          }
        }
      }
    });

        // Functie om actieve rij te markeren
    function updateActiveRow(rows) {
      // Verwijder de actieve markering van alle rijen
      rows.forEach(row => row.classList.remove("suggestion-active"));
      
      // Voeg de actieve markering toe aan de huidige rij 
      rows[currentFocus].classList.add("suggestion-active");
      
      // Zorg ervoor dat de actieve rij zichtbaar is in het scherm
      rows[currentFocus].scrollIntoView({ block: "nearest" });
      
      // Verander de placeholder van het zoekveld naar de tekst van de actieve rij
      input.placeholder = rows[currentFocus].innerText;
    }

    // Zet PHP-array om naar JavaScript-array
    const jsArray = <?php echo json_encode($array); ?>;

    // Vul de tabel met spelersnamen
    const tableBody = document.getElementById("tbo");
    jsArray.forEach(([id, firstName, lastName]) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `<td onclick="showPlayer('${id}')">${firstName} ${lastName}</td>`;
      tableBody.appendChild(tr);
    });

    // Filterfunctie
    function filterFunction() {
      // Haal de waarde uit het zoekveld en zet deze om naar hoofdletters
      const filter = input.value.toUpperCase();
    
      // Selecteer alle rijen in de tabel behalve de header
      const rows = Array.from(document.querySelectorAll("#myTable tr:not(.header)"));
    
      // Sorteer de rijen alfabetisch op basis van de tekst in de cellen
      rows.sort((a, b) => {
        // Haal de tekst op uit de eerste cel van elke rij
        const textA = a.querySelector("td")?.textContent || ""; // Als er geen tekst is, gebruik een lege string
        const textB = b.querySelector("td")?.textContent || ""; // Als er geen tekst is, gebruik een lege string
        return textA.localeCompare(textB); // Vergelijk de tekst alfabetisch
      });
    
      // Voeg de gesorteerde rijen terug toe aan de tabel
      rows.forEach(row => tableBody.appendChild(row));
    
      // Filter de rijen op basis van de zoektekst
      rows.forEach(row => {
        // Haal de tekst op uit de eerste cel van de rij
        const text = row.querySelector("td")?.textContent || ""; // Als er geen tekst is, gebruik een lege string
        // Controleer of de tekst overeenkomt met de zoektekst
        row.style.display = text.toUpperCase().includes(filter) ? "" : "none"; // Verberg de rij als er geen match is
      });
    }
    // Koppel filterfunctie aan zoekveld
    input.addEventListener("input", filterFunction);

    // Functie om naar spelerpagina te navigeren
    window.showPlayer = function (id) {
      window.location.href = `speler.php?ID=${id}`;
    };

    // Voer filterfunctie uit bij laden van pagina
    filterFunction();
  });
</script>

</body>
<style>
  /* Achtergrondkleur van de pagina */
  body {
    background-color: #036649;
  }

  /* Stijl voor actieve suggestie */
  .suggestion-active {
    background-color: #FFC107;
  }

</style>
</html>