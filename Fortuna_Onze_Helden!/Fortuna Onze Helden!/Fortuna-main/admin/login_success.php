<?php  
 //login_success.php  
 session_start();  
 if(isset($_SESSION["username"])){   
    //Do nothing
 }  
 else{  
    header("location:pdo_login.php");//send back to login page
 }  
 ?>  
 