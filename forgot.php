<?php
//start session
session_start();
//connection establishment to database
include 'connection.php';
//check userinput 
    //check error messages
$errors = "";
$missingEmail = "<p><strong>Please enter your email address!</strong></p>";
$invalidEmail = "<p><strong>Invalid email Format!</strong></p>";
//Get email Store errors
if(empty($_POST['forgotemail'])){
    $errors .= $missingEmail;
}
else{
    //to check if the name contains other than white spaces or letters
    $email = filter_var($_POST["forgotemail"],FILTER_SANITIZE_EMAIL);
    if(!filter_var($email,FILTER_SANITIZE_EMAIL)){
        $errors .= $invalidEmail;
    }
}    
if($errors){
    $result = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $result;
    exit();
}
    //Prepare variables for Query
        $email = mysqli_real_escape_string($conn,$email);
    //To check if email exist in the table
        $sql = "SELECT * FROM myguests WHERE email='$email'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "<div class='alert alert-danger'>There was an error running Query.</div>";
        }
        $count = mysqli_num_rows($result);
        //count should be 1 if successful and 0 if unsuccessful so if email not found $results = 0 and !0 = true as 0 is false.Thus if will run only when email is not found.
        if($count !== 1){
            echo "<div class='alert alert-danger'>The Email does not exist on our Database.</div>";
            exit();
        }
        //Fetch the record of user from database.
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $user_id = $row['user_id'];
            //Create a key for changing the password.
            $key = bin2hex(openssl_random_pseudo_bytes(16));
        //Insert user details in the table of forgotpassword
            $time = time();
            $status = 'pending';
            $sql = "INSERT INTO forgotpassword (`user_id`,`rkey`,`time`,`status`) VALUES ('$user_id','$key','$time','$status')";
            $result = mysqli_query($conn,$sql);
        //If there was an error 
        if(!$result){
            echo "<div class='alert alert-danger'>Error Inserting the user details in Database.</div>";
            exit();
        }
// Now send an email to the user containing a link to resetpassword.php with their email and key.
//Including phpmailer and its parameters
require_once "PHPMailer/PHPMailerAutoload.php";
require_once "PHPMailer/smtp.php";
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/Exception.php";    
try{
    $mail = new PHPMailer;
    //enable SMTP debugging
    $mail->SMTPDebug = 0;   
    //Set Php mailer to use SMTP
    $mail->isSMTP();
    //Set SMTP host
    $mail->Host='smtp.gmail.com';
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;                          
    //Provide username and password     
    $mail->Username = "desaiananya777@gmail.com";                 
    $mail->Password = "awesomepapa";                           
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = 'tls';      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    //Set TCP port to connect to 
    $mail->Port = 587;         
$mail->setFrom('desaiananya777@gmail.com','AnunayAnand'); //<!--Mail of sender-->
$mail->addAddress($email);  //<!--receiver email-->   
$mail->isHTML(true); //html tags are taken in consideration
$mail->Subject = 'Insert your new Password';   //Subject of Email
//Body of email for Html users
$mail->Body = "<div class='alert alert-danger text-center'>Please click on this link to generate password:<br><br>
     http://localhost/my%20projects/udemy2k19login/reset_password.php?user_id=$user_id&key=$key</div>";        

//Send mail
  $mail->send();
    echo "<div class='alert alert-success'>A Reset link will be sent to $email.Please click on the link to Reset your Password.</div>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>