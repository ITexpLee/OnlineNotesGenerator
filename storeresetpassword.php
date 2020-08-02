<?php
//start session
session_start();
//connection to database
include 'connection.php';
//Check if you received user_id and key.
if(empty($_POST['user_id']) || empty($_POST['key'])) {
    echo "<div class='alert alert-danger'>There was an error in Resetting the Password.</div>";
    exit();
    }  
//Store them in variables                
else{
$user_id = $_POST['user_id'];    
$key = $_POST['key'];
$time = time() - 86400;    
//Preapare for sql database
$user_id = mysqli_real_escape_string($conn,$user_id);
$key = mysqli_real_escape_string($conn,$key);    
}
//Check wether a combination of email and key exist.
$sql = "SELECT user_id FROM forgotpassword WHERE rkey='$key' && user_id='$user_id' && time > '$time' && status='pending'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an Error running the Query.</div>";
    exit();
}    
//If query is successful we will check No of affected rows by query
$count = mysqli_num_rows($result);
if($count !== 1){
    echo "<div class='alert alert-danger'>please try again.</div>";
    exit();
}
//Define the error messages
$errors = "";
$missingPassword = "<p><strong>Please enter a password!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password!</strong></p>";
$invalidPassword = "<p><strong>Your password should atleast be 6 character long and include one capital letter,number and Special Character!</strong></p>";
$differentPassword = "<p><strong>Password don't Match</strong></p>";
//Check password
function test_input($data){
$data = stripslashes($data);
$data = trim($data);
$data = htmlspecialchars($data);
return $data;    
}
        if(empty($_POST["password"])){
            $errors .= $missingPassword;
        }
        else if(!(strlen($_POST["password"]) > 6 and preg_match('@[A-Z]@',$_POST["password"]) and preg_match('@[0-9]@',$_POST["password"]) and preg_match('@[^\w]@',$_POST["password"])
                 )
               ){
            $errors .= $invalidPassword;    
        }
        else{
            $password = test_input($_POST["password"]);
            //Check password
            $password = filter_var($password,FILTER_SANITIZE_STRING);
            if(empty($_POST["password2"])){
                $errors .= $missingPassword2;
            }
            else{
                $password2 = test_input($_POST["password2"]);
                $password2 = filter_var($password2,FILTER_SANITIZE_STRING);
                if($password !== $password2){
                    $errors .= $differentPassword;
                }
            }
        }
//if there are any error messages print them.
    if($errors){
    $resultMessage = "<div class='alert alert-danger'> ". $errors ."</div>";
    echo $resultMessage;
    exit();    
    }
//Prepare variables for Query
$password = mysqli_real_escape_string($conn, $password);
$password = hash('sha256',$password);
$user_id = mysqli_real_escape_string($conn,$user_id);

//Run Query to update user password in myguets Table

$sql = "UPDATE myguests SET password='$password' WHERE user_id='$user_id'";
$result = mysqli_query($conn,$sql);
if(!$result){
echo "<div class='alert alert-danger'>There was a problem Storing new password</div>";
exit();    
}
//Set key status to be used so that it cannot be used again.
$sql = "UPDATE forgotpassword SET status='used' WHERE (rkey='$key' && user_id='$user_id')";
$result = mysqli_query($conn,$sql);
if(!$result){
echo "<div class='alert alert-danger'>Error query</div>";    
}
else{
echo "<div class='alert alert-success'>Your password is updated Successfully.Click here to <a href='index.php'>Login</a></div>";
}
?>