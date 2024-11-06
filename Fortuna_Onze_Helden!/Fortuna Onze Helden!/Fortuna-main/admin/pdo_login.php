<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "fortunamusea";
$message = "";
try {
     $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     if (isset($_POST["login"])) {
          if (empty($_POST["username"]) || empty($_POST["password"])) {
               $message = '<label>All fields are required</label>';
          } else {
               $query = "SELECT * FROM users WHERE username = :username";
               $statement = $connect->prepare($query);
               $statement->execute(
                    array(
                         'username'     =>     $_POST["username"]
                    )
               );
               $results = $statement->fetchAll(PDO::FETCH_OBJ);
               $count = $statement->rowCount();
               foreach ($results as $result) {
                    echo $result->password;
               }
               if ($count > 0) {
                    foreach ($results as $result) {
                        // Debugging: Print the hashed password from the database
                        error_log("Database password hash: " . $result->password);
                        // Debugging: Print the plain-text password
                        error_log("Entered password: " . $_POST["password"]);
                        if (password_verify($_POST["password"], $result->password)) {
                            $_SESSION["username"] = $_POST["username"];
                            header("location:index.php");
                        } else {
                            $message = '<label>Wrong password</label>';
                        }
                    }
                }
          }
     }
} catch (PDOException $error) {
     $message = $error->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
     <title>Login</title>
     <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div id="goback">
     <button style="position:absolute; right:10px; top:10px;" onclick="goBack()" type="button" class="btn btn-dark">Ga Terug</button>
</div>
<body>
     <br />
     <div class="container" style="width:500px;">
          <?php
          if (isset($message)) {
               echo '<label class="text-danger">' . $message . '</label>';
          }
          ?>
          <h3>Login Page</h3><br />
          <p id="demo">-</p>
          <form method="post">
               <label>Username</label>
               <input type="text" name="username" class="form-control" />
               <br />
               <label>Password</label>
               <input type="password" name="password" class="form-control" />
               <br />
               <input type="submit" name="login" class="btn btn-info" value="Login" />
          </form>
     </div>
     <br />
</body>
</html>
<script>
     //Javascript for auto redirect
     var start = 30;
     document.getElementById("demo").innerHTML = "redirect after " + start + " seconds";
     // Update the count down every 1 second
     var x = setInterval(function() {
          start--;
          document.getElementById("demo").innerHTML = "redirect after " + start + " seconds";
          if (start <= 0) {
               window.location.href = '../pages/index.php';
          }
     }, 1000);

     function goBack() {
          window.location.href = "../pages/index.php";
     }
</script>