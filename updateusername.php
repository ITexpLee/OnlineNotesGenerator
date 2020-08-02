<?php
//start session
session_start();
//connect to database
include 'connection.php';
//Get user id from the database
$id = $_SESSION['user_id'];
//Define the error message
$errors = "";
$missingUsername = "<p><strong>Please enter a username!</strong></p>";
//Get the username from the ajax file
if(empty($_POST["username"])){
    $errors .= $missingUsername;
}
else{
     //to check if the name contains other than white spaces or letters
        $username = filter_var($_POST["username"],FILTER_SANITIZE_STRING);
}
if($errors){
    $resultmessage =  '<div class="alert alert-danger">'. $errors .'</div>';
    echo $resultmessage;
    exit();
}
//Prepare the variable for sql.

$username = mysqli_real_escape_string($conn,$username);

//Run Query to update Database

$sql = "UPDATE myguests SET username='$username' WHERE user_id='$id'";
$result = mysqli_query($conn,$sql);

if(!$result){
    echo "<div class='alert alert-danger'>There was an error storing the new username in the database</div>";
}

?>