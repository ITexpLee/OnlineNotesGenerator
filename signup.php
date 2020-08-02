<?php    
//Start session
session_start();
//Connection Check
include 'connection.php';
//Php Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//<!--Check Inputs-->
//  <!--Define Error Message-->
$errors = ""; 
$missingUsername = "<p><strong>Please enter a username!</strong></p>";
$missingEmail = "<p><strong>Please enter an email!</strong></p>";
$invalidEmail = "<p><strong>Invalid email format!</strong></p>";
$missingPassword = "<p><strong>Please enter a password!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password!</strong></p>";
$invalidPassword = "<p><strong>Your password should atleast be 6 character long and include one capital letter,number and Special Character!</strong></p>";
$differentPassword = "<p><strong>Password don't Match</strong></p>";
//  filtering function
    function test_input($data){
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = stripslashes($data);
        return $data;
    }
// <!--Get username,password and Email-->
        //Check Username
        if(empty($_POST["username"])){
            $errors .= $missingUsername;
        }
        else{
            $username = test_input($_POST["username"]);
            //to check if the name contains other than white spaces or letters
            $username = filter_var($username,FILTER_SANITIZE_STRING);
            }    
        //Check Email
        if(empty($_POST["email"])){
            $errors .= $missingEmail;
        }
        else{
            //to check if the name contains other than white spaces or letters
            $email = filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
                if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $errors .= $invalidEmail;
                } 
            }
        //Check password
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
// if there are any errors store and Print errors       
    if($errors){
        $resultmessage = "<div class='alert alert-danger'>. $errors .</div>";
        echo $resultmessage;
        exit();
    }   
//Else
// if there are No errors.

    //We will prepare variables for queries.
    $username = mysqli_real_escape_string($conn,$username);
    $email = mysqli_real_escape_string($conn,$email);
    $password = mysqli_real_escape_string($conn,$password);
    $password = hash('sha256',$password);
    //To check wether username already exists in the Database.
    
    $sql = "SELECT * FROM myguests WHERE username = '$username'";
    $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "<div class='alert alert-success'>Username does not exist</div>";
            exit();
        }
        $results = mysqli_num_rows($result);
        if($results){
            echo "<div class='alert alert-danger'>That Username is already registered.Do you want to login?</div>";
            exit();
        } 
    //To check wether email pre exist or Not
    
    $sql = "SELECT * FROM myguests WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "<div class='alert alert-success'>Email not registered.</div>";
            exit();
        }
        $results = mysqli_num_rows($result);
        if($results){
            echo "<div class='alert alert-danger'>Email is already registered.</div>";    
            exit();
        }
//Create Unique Activation Code

$activationkey = bin2hex(openssl_random_pseudo_bytes(16));
        //Now 1 byte is 8 bits.
        // 16 bytes means 16*8 = 128bits.
        // 4bits form 1 hexa decimal number or character.
        // So we get 128/4 characters = 32. Ex.A=1010;

// <!-- Now we must enter the elements in myguests Table -->

    $sql = "INSERT INTO myguests (`username`,`email`,`password`,`activation`)
            VALUES ('$username','$email','$password','$activationkey')";
    $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "<div class='alert alert-danger'>Error Inserting the user details in Database.</div>";
            exit();
        }
// Now send an email to the user containing a link to activate.php with their email and activation code.
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
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    //Set TCP port to connect to 
    $mail->Port = 587;         
$mail->setFrom('desaiananya777@gmail.com','AnunayAnand'); //<!--Mail of sender-->
$mail->addAddress($email);  //<!--receiver email-->   
$mail->isHTML(true); //html tags are taken in consideration
$mail->Subject = 'Confirm your Registration';   //Subject of Email
//Body of email for Html users
$mail->Body = "<div class='alert alert-danger text-center'>Please click on this link to activate your Account:<br><br>
     http://localhost/my%20projects/udemy2k19login/activate.php?email=". urlencode($email) ."&key=$activationkey</div>";    
//Body of email for non-HTML users
$mail->AltBody = "Please click on this link to activate your Account:   http://localhost/my%20projects/udemy2k19login/activate.php?email=". urlencode($email) ."&key=$activationkey";
//Send mail
  $mail->send();
    echo "<div class='alert alert-success'>Thank You for Registering! A confirmation email will be sent to $email.Please click on activation link to activate your Account.</div>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?> 