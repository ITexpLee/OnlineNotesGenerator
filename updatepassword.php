<?php
//session start 
session_start();
//connect to Database
include 'connection.php';
//fetch the user_id from database
$user_id = $_SESSION['user_id'];
//define error messages
$errors = "";
$missingPassword = "<p><strong>Please enter a password!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password!</strong></p>";
$invalidPassword = "<p><strong>Your password should atleast be 6 character long and include one capital letter,number and Special Character!</strong></p>";
$differentpassword = "<p>The passwords entered do not Match!</p>";
$incorrectcurrentpassword = "<p>The password you entered is incorrect and does not Match your current password.</p>";
$missingcurrentpassword = "<p>Current password box is empty.</p>";
//check errors for Current password
if(empty($_POST['currentpassword'])){
    $errors .= $missingcurrentpassword;
}
        else if(!(strlen($_POST["currentpassword"]) > 6 and preg_match('@[A-Z]@',$_POST["currentpassword"]) and preg_match('@[0-9]@',$_POST["currentpassword"]) and preg_match('@[^\w]@',$_POST["currentpassword"])
                 )
               ){
            $errors .= $incorrectcurrentpassword;    
        }
else{
$currentpassword = filter_var($_POST['currentpassword'],FILTER_SANITIZE_STRING);
}
//Check if there are No errors
if($errors){
$resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}
//prepare the password for query 
$currentpassword = mysqli_real_escape_string($conn,$currentpassword);
//Hash the current password as it is stored in table
$currentpassword = hash('sha256',$currentpassword);
//Check if given password is correct
$sql = "SELECT * FROM myguests WHERE user_id='$user_id'";
$result = mysqli_query($conn,$sql);
//to check how many rows were affected
$count = mysqli_num_rows($result);
if($count !== 1){
    echo "<div class='alert alert-danger'>There was a problem running Query</div>";
    exit();
}
//Fetch the value from table
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
//check if both Match
if($currentpassword != $row['password']){
    $errors .= $incorrectcurrentpassword;
}

//Get the New password entered by User
if(empty($_POST['password'])){
    $errors .= $missingPassword;
}
else if(!(strlen($_POST['password']) and preg_match('@[A-Z]@',$_POST['password']) and preg_match('@[0-9]@',$_POST['password']) and preg_match('@[^\w]@',$_POST["password"])
                    )
                  ){
    $errors .= $invalidPassword;
}
else{
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    if(empty($_POST['password2'])){
        $errors .= $missingPassword2;
    }
    else{
        $password2 = filter_var($_POST['password2'],FILTER_SANITIZE_STRING);
        if($password != $password2){
            $errors .= $differentpassword;
        }
    }
}

if($errors){
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}
//Prepare it for query
$password = mysqli_real_escape_string($conn,$password);
$password = hash('sha256',$password);
//Query
$sql = "UPDATE myguests SET password='$password' WHERE user_id='$user_id'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "<div class='alert alert-danger'>The password could not be reset please try again later.</div>";
    exit();
}
//success message
echo "<div class='alert alert-success'>Your password was updated</div>";

?>