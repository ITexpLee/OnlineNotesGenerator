<?php
//<!--The user is redirected to this file after cliking on Activation Link-->
//The link will have to get Values Email and Key.
session_start();
//Connect to database
include "connection.php";
//If email or Key is Missing
if(empty($_GET['email']) || empty($_GET['key'])) {
    echo "<div class='alert alert-danger'>There was an error please Click on the Activation you received by email.</div>";
    exit();
}    
else{
$email = $_GET['email'];
$key = $_GET['key'];
//Preapare for sql database
$email = mysqli_real_escape_string($conn,$email);
$key = mysqli_real_escape_string($conn,$key);    
}
//Check wether a combination of email and key exist.
$sql = "UPDATE myguests SET activation='activated' WHERE (email='$email' && activation='$key') LIMIT 1";
$result = mysqli_query($conn,$sql);
//If query is successful we will check No of affected rows by query
if(mysqli_affected_rows($conn) == 1){
    echo "<div class='alert alert-success'>Your account has been Activated.</div>";
    echo "<a href='index.php' type='button' class='btn-lg btn-success'>Log in</a>";
}
else{
    echo "<div class='alert alert-danger'>Your account could not be Activated.Please try again Later.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>form udemy</title>
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