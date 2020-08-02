 <?php
//<!--The user is redirected to this file after cliking on Activation Link-->
//The link will have to get Values Email and Key.
session_start();
//Connect to database
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Reset</title>
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
<body><!--Reset Password-->
    <div class="container">
        <div class="row w-100">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h1>Reset password:</h1>
                <div id="resultmessage"></div>
<?php
    if(empty($_GET['user_id']) || empty($_GET['key'])) {
    echo "<div class='alert alert-danger'>There was an error please Click on the link you received by email.</div>";
    exit();
    }  
//Store them in variables                
else{
$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400;    
//Preapare for sql database
$user_id = mysqli_real_escape_string($conn,$user_id);    
$key = mysqli_real_escape_string($conn,$key);    
}
//Check wether a combination of email and key exist.
$sql = "SELECT user_id FROM forgotpassword WHERE (rkey='$key' && user_id='$user_id' && time > '$time' && status='pending')";
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
                //Print reset password form then.
echo "<form method='post' id='passwordreset'>
        <input type=hidden name=key value=$key>
        <input type=hidden name=user_id value=$user_id>
        <div class='form-group'>
            <label for='password'>Enter your new password:</label>
            <input type='password' name='password' id='password' class='form-control' placeholder='Enter new password'/>
        </div>
        <div class='form-group'>
            <label for='password'>Re-enter password</label>
            <input type='password' name='password2' id='password2' class='form-control' placeholder='Enter new password'/>
        </div>
        <input type='submit' value='Reset Password' name='resetpassword' class='btn btn-success btn-lg'/>
      </form>";
?>                              
            </div>
        </div>
    </div>
  <script>
    //<!-- Now put an ajax code here to send this data to storeResetpassword php page-->
$(document).ready(function () {
    $("#passwordreset").submit(function () {
    event.preventDefault();
    //Collect user Input
    var datapost = $("#passwordreset").serialize();   
    //send them to signup.php using Ajax
        $.ajax({
        url: "storeresetpassword.php",
        type: "POST",
        data: datapost,
        success: function(data){
            if(data){
            $("#resultmessage").html(data);
            }
        },
        error: function(){
            $("#resultmessage").html("<div class='alert alert-danger'>There was some error in Ajax call please try again Later.</div>")
            }    
        });    
    });
});
    </script>

    </body>
</html>