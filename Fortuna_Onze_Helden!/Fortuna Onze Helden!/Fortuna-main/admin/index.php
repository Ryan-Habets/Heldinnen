<?php
require_once("login_success.php");
// include database connection file
require_once 'dbconfig.php';
// Code for record deletion
if (isset($_REQUEST['del'])) {
    //Get row id
    $uid = intval($_GET['del']);
    //Qyery for deletion
    $sql = "delete from spelers WHERE  id=:id";
    // Prepare query for execution
    $query = $dbh->prepare($sql);
    // bind the parameters
    $query->bindParam(':id', $uid, PDO::PARAM_STR);
    // Query Execution
    $query->execute();
    // Mesage after updation
    echo "<script>alert('Record Updated successfully');</script>";
    // Code for redirection
    echo "<script>window.location.href='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Overzicht Spelers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../resources/Favicon.ico">
    <style type="text/css">

    </style>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div id="goback">
        <button style="position:absolute; right:10px; top:10px; z-index: 100;" onclick="goBack()" type="button" class="btn btn-dark">Logout</button>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3>Overzicht Spelers</h3>
                <hr />
                <a href="insert.php"><button class="btn btn-primary">Voeg een nieuwe speler toe</button></a>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">
                        <thead>
                            <th>#</th>
                            <th>achternaam</th>
                            <th>voornaam</th>
                            <th>afbeelding</th>
                            <th>nationaliteit</th>
                            <th>Aanpassen</th>
                            <th>Verwijderen</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * from spelers";
                            //Prepare the query:
                            $query = $dbh->prepare($sql);
                            //Execute the query:
                            $query->execute();
                            //Assign the data which you pulled from the database (in the preceding step) to a variable.
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            // For serial number initialization
                            if ($query->rowCount() > 0) {
                                //In case that the query returned at least one record, we can echo the records within a foreach loop:
                                foreach ($results as $result) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlentities($result->id); ?></td>
                                        <td><?php echo htmlentities($result->achternaam); ?></td>
                                        <td><?php echo htmlentities($result->voornaam); ?></td>
                                        <td><img style="height: 40px; width: auto" src="../images/<?php echo $result->afbeelding; ?>"> </td>
                                        <td><?php echo htmlentities($result->nationaliteit); ?></td>

                                        <td><a href="update.php?id=<?php echo htmlentities($result->id); ?>"><button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></a></td>

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
        function goBack() {
            window.location.href = "./logout.php";
        }
    </script>
</body>
</html>