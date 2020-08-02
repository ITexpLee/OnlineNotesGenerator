<?php
//start session 
session_start();
//connect to database
include 'connection.php';
//get the user id and new email of the user 
$id = $_SESSION['user_id'];
$newemail = $_POST['email'];
//Run a query to check if the email already exist in database
$sql = "SELECT * FROM myguests WHERE email='$newemail'";
$result = mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);
//Check count is greater than 0
if($count>0){
    echo "<div class='alert alert-danger'>There is already a user registered with that Email. Please choose another one.</div>";
    exit();
}

//Get the current email of the User
$sql = "SELECT * FROM myguests WHERE user_id='$id'";    
$result = mysqli_query($conn,$sql);
if(!$result){
echo "<div class='alert alert-danger'>something is wrong</div>";
exit();
}
//To store the number of rows        
$count = mysqli_num_rows($result);
    if($count == 1){
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        //We have got access to the only Row we wanted
        $email = $row['email'];
    }
    else{
        echo "There was an error retreiving the Email from Database";
        exit();
    } 

//Create Unique Activation Code

$activationkey = bin2hex(openssl_random_pseudo_bytes(16));

//Insert the new activation key in myguests table
$sql = "UPDATE myguests SET activation2='$activationkey' WHERE user_id='$id'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error inserting the user details into the database.</div>";
    exit();
}
//Send the email to the user to redirect to activatenewemail.php with current email,new email and the key
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
$mail->addAddress($newemail);  //<!--receiver email-->   
$mail->isHTML(true); //html tags are taken in consideration
$mail->Subject = 'Email Update for your Online Notes App';   //Subject of Email
//Body of email for Html users
$mail->Body = "<div class='alert alert-danger text-center'>Please click on this link to prove it's your Account:<br><br>
     http://localhost/my%20projects/udemy2k19login/activatenewemail.php?email=". urlencode($email) . "&newemail=" .urlencode($newemail) . "&key=$activationkey</div>";    
//Send mail
  $mail->send();
    echo "<div class='alert alert-success'>A confirmation email will be sent to $newemail.Please click on activation link to prove your new Email Account.</div>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>