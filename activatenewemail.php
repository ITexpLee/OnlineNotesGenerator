<?php
//<!--The user is redirected to this file after cliking on Link received on Email to prove the new Email address-->
//The link will have to get Values Email,new email and Key.
session_start();
//Connect to database
include "connection.php";
//If email,new email or Key is Missing show Error
if(empty($_GET['email']) || empty($_GET['key']) || empty($_GET['newemail'])) {
    echo "<div class='alert alert-danger'>There was an error please Click on the Activation you received by email.</div>";
    exit();
}    
else{
//Store them in three variables    
$email = $_GET['email'];
$key = $_GET['key'];
$newemail = $_GET['newemail'];   
//Preapare for sql database
$email = mysqli_real_escape_string($conn,$email);
$key = mysqli_real_escape_string($conn,$key);
$newemail = mysqli_real_escape_string($conn,$newemail);    
}
//Run Query to update Email
$sql = "UPDATE myguests SET email='$newemail', activation2='0' WHERE (email='$email' && activation2='$key') LIMIT 1";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error running the Query</div>";
}
//If query is successful we will check No of affected rows by query
if(mysqli_affected_rows($conn) == 1){     //It checks the last inserted,updated or deleted query.
    //We destroy the session as well as setcookie because otherwise the user will be able to login with previous email until remember me is alive.
    session_destroy();
    setcookie("rememberme","",time()-3600);
    echo "<h1>Email Activation</h1>";
    echo "<div class='alert alert-success'>Your email has been updated.</div>";
    echo "<a href='index.php' type='button' class='btn-lg btn-success'>Log in</a>";
}
else{
    echo "<div class='alert alert-danger'>Your email could not be Updated.Please try again Later.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Activate New email page</title>
    <meta charset="utf-8"/>
    <meta name="author" content="anunay anand"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!--Fonts-->        
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine|Hepta+Slab|Roboto|Bellota">
<!--Google icons-->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!--font awesome 5 icons-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<!-- font awesome 4 icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--Personal Js File-->    
<script src="index.js"></script>
    </head>
<body>
    
    </body>
</html>