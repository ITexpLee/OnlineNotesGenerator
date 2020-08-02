<?php
//start session
session_start();
//Connect to Database
include 'connection.php';
//Check for Inputs 
    //Define Error messages
     $errors = "";
     $missingEmail = "<p><strong>Please enter your email!</strong></p>";
     $invalidEmail = "<p><strong>Invalid email format!</strong></p>";
     $missingPassword = "<p><strong>Please enter your Password.</strong></p>";
     //Filtering the data
        function test_input($data){
                $data = htmlspecialchars($data);
                $data = trim($data);
                $data = stripslashes($data);
                return $data;
            }
        
//Check the input email
        if(empty($_POST["loginemail"])){
            $errors = $missingEmail;     
        }
        else{
            //to check if the name contains other than white spaces or letters
            $email = filter_var($_POST["loginemail"],FILTER_SANITIZE_EMAIL);
            }
//Check the input password
        if(empty($_POST['loginpassword'])){
            $errors = $missingPassword;     
        }
        else{
            //to check if the name contains other than white spaces or letters
            $password = test_input($_POST["loginpassword"]);
            $password = filter_var($password,FILTER_SANITIZE_STRING);
            }
//Check if errors
    if($errors){
        $resultmessage = '<div class="alert alert-danger">' . $errors . '</div>';
        echo $resultmessage;
        exit();
    }
//If there are No errors
    //Prepare variables for Input
    $email = mysqli_real_escape_string($conn,$email);
    $password = mysqli_real_escape_string($conn,$password);
    //Password encryption
    $password = hash('sha256',$password);
    //Run Query to check Combination of Email and password Exist
    $sql = "SELECT * FROM myguests WHERE email = '$email' && password = '$password' AND activation='activated'";
    $result = mysqli_query($conn,$sql);
        if(!$result){
            echo "There was error Running Query";
        }
    //To check the Number of Rows affected so to make sure there was a Match in the same Row.
    $count = mysqli_num_rows($result);
        if($count !== 1){
            echo "<div class='alert alert-danger'>Wrong Username or Password!</div>";
            //We will store the value of Email and password in $row variable.
        }
        else{
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            //Now we will create Session Varibale
            $_SESSION['user_id']=$row['user_id'];
            $_SESSION['username']=$row['username'];
            $_SESSION['email']=$row['email'];
            //If remember me is Checked
            if(empty($_POST['rememberme'])){
                echo "success";
            }
            else{
                //Create two variables or the authenticators 1 and 2 for Remember ME.
                $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
                $authentificator2 = openssl_random_pseudo_bytes(20);
                
                //Store them in Cookie. This is to make it difficult for cookie to cracked.
                function f1($a, $b){
                    $c = $a. "," .bin2hex($b);
                    return $c;
                }
                $cookievalue = f1($authentificator1,$authentificator2);
                setcookie('rememberme',$cookievalue,time() + 1296000);
                //Run query to store them in Table.
                    function f2($a){
                        $b = hash('sha256',$a);
                        return $b;
                    }
                 $f2authentificator2 = f2($authentificator2);
                 $user_id = $_SESSION['user_id'];
                 $expiration = date('Y-m-d H:i:s',time() + 1296000);
                $sql = "INSERT INTO rememberme (`authentificator1`,`f2authentificator2`,`user_id`,`expires`)
                        VALUES('$authentificator1','$f2authentificator2','$user_id','$expiration')";
                $result = mysqli_query($conn,$sql);
                        if(!$result){
                            echo "<div class='alert alert-danger'>There was an error in storing data to remember you next time.</div>";
                        }
                        else{
                            echo "success";
                        }
                
            }
        }
?>



