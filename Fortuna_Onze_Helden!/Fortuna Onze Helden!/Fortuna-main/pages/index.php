<html>
<head>
  <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
  <link rel="stylesheet" href="../css/kb.css">
  <link rel="stylesheet" href="../css/index.css">
  <link href="../bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<a href="../admin/pdo_login.php"><img src="../resources/fortuna_museam.jpg" alt="logo" style="width: 100px; position: absolute; margin-top: 5px; margin-left: 5px;"></a>
<div class="container">
  <div class="row text-center">
    <div class="col-lg-10">
      <section class="py-5">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-8 mx-auto text-center">
              <h4 class="text-warning" data-removed="true">Onze Helden!</h4>
              <h2 class="display-5 fw-bold mt-2 mb-3 text-warning">Zoek voor een speler</h2>
              <p class="lead mb-4 text-warning">Zoek je favoriete speler op in de database. <br> Begin door hier onder een naam in te typen</p>
              <img class="mx-auto img-fluid" src="bootstrap5-plain-assets/images/blue-400-horizontal.png" alt="" data-removed="true">
              <hr>
              </ht>
            </div>
          </div>
        </div>
      </section>
      <section>
        <div id="center" class="input-group mb-3">
          <span class="input-group-text bg-warning" id="basic-addon1"></span>
          <input type="text" id="myInput2" onkeyup="filterFunction()" class="form-control" placeholder="Zoek een speler op naam..." aria-label="Username" aria-describedby="basic-addon1" autocomplete="off">
        </div>
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
    <div style="background-color: #FFC107;" class="col-lg-2">
      <img style="width: 100%; padding-top: 1rem; height: auto;" src="../resources/logo.png">
      <img style="width: 100%; padding-top: 1rem; height: auto;" src="../resources/54.png">
      <img class="mb-3" style="width: 100%; height: auto;" src="../resources/sittardia.png">
    </div>
  </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
  <path fill="#f8d000 " fill-opacity="1" d="M0,64L720,288L1440,256L1440,320L720,320L0,320Z"></path>
</svg>
<div id="svg_after_bg"></div>
<?php
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
    const input = document.getElementById("myInput2");
    input.focus();
    let currentFocus = 0;

    input.addEventListener("keydown", function (e) {
      const rows = Array.from(document.querySelectorAll("#myTable tr:not(.header)"));
      const visibleRows = rows.filter(row => row.style.display !== "none");

      if (visibleRows.length > 0) {
        if (e.key === "ArrowDown") {
          currentFocus = (currentFocus + 1) % visibleRows.length;
          updateActiveRow(visibleRows);
        } else if (e.key === "ArrowUp") {
          currentFocus = (currentFocus - 1 + visibleRows.length) % visibleRows.length;
          updateActiveRow(visibleRows);
        } else if (e.key === "Enter") {
          e.preventDefault();
          if (currentFocus >= 0 && visibleRows[currentFocus]) {
            visibleRows[currentFocus].querySelector("td").click();
          }
        }
      }
    });

    function updateActiveRow(rows) {
      rows.forEach(row => row.classList.remove("suggestion-active"));
      rows[currentFocus].classList.add("suggestion-active");
      rows[currentFocus].scrollIntoView({ block: "nearest" });
      input.placeholder = rows[currentFocus].innerText;
    }

    // Convert a PHP array to a JS Array
    const jsArray = <?php echo json_encode($array); ?>;

    // Populate the table
    const tableBody = document.getElementById("tbo");
    jsArray.forEach(([id, firstName, lastName]) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `<td onclick="showPlayer('${id}')">${firstName} ${lastName}</td>`;
      tableBody.appendChild(tr);
    });

    // Sort and filter function
    function filterFunction() {
      const filter = input.value.toUpperCase();
      const rows = Array.from(document.querySelectorAll("#myTable tr:not(.header)"));

      // Sort rows alphabetically
      rows.sort((a, b) => {
        const textA = a.querySelector("td")?.textContent || "";
        const textB = b.querySelector("td")?.textContent || "";
        return textA.localeCompare(textB);
      });

      // Append sorted rows back to the table
      rows.forEach(row => tableBody.appendChild(row));

      // Filter rows
      rows.forEach(row => {
        const text = row.querySelector("td")?.textContent || "";
        row.style.display = text.toUpperCase().includes(filter) ? "" : "none";
      });
    }

    // Attach the filter function to the input
    input.addEventListener("input", filterFunction);

    // Function to navigate to a player's page
    window.showPlayer = function (id) {
      window.location.href = `speler.php?ID=${id}`;
    };

    // Initial sorting
    filterFunction();
  });
</script>

</body>
<style>
  /* kleur veranderen in de styles.css werkt niet hij word overwritten */
  body {
    background-color: #036649;
  }

    .suggestion-active {
    background-color: #FFC107;
  }

</style>
</html>