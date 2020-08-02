<?php

//To check wether the user is Not logged in and if cookie exist
if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){
    
    //Our function first f1 for Cookie $c = $a. "," .bin2hex($b); 
        //Our second function for storage in table $b = hash('sha256',$a);

    //Extract authentificator1 and 2 from Cookie
    //Explode function divides the string on a criteria like comma here and return a series of strings in an Array.
    //We will also use a list here and the values of array returned by explode will be tranffered to list items.
    
    list($authentificator1, $authentificator2) = explode(',',$_COOKIE['rememberme']);
    
    //This is how we get authentificator 2.
    
    $authentificator2 = hex2bin($authentificator2);
    
    //Now we saved authentificator 1 as it is but converted authentificator before sending in Table
    
    $f2authentificator2 = hash('sha256',$authentificator2);
    
    //Now query to check they exist in table
    
    $sql = "SELECT * FROM rememberme where authentificator1 = '$authentificator1'";
    $result = mysqli_query($conn,$sql);
        if(!$result){
        echo "<div class='alert alert-danger'>There was an error in storing data to remember you next time.</div>";
        exit();
        }
    $count = mysqli_num_rows($result);
        if($count !== 1){
        echo "<div class='alert alert-danger'>Remember me process has failed $count!</div>";
        exit();    
        }
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
         //if authentificator 2 does not Match we will use hash comparison function
        if(!hash_equals($row['f2authentificator2'], $f2authentificator2)) {
            echo "<div class='alert alert-danger'>There was an error in storing data to remember you next time.</div>";    
        }
        else{
            //Generate new authentificators for User.
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
                        VALUES ('$authentificator1','$f2authentificator2','$user_id','$expiration')";
                $result = mysqli_query($conn,$sql);
                        if(!$result){
                            echo "<div class='alert alert-danger'>There was an error in storing data to remember you next time.</div>";
                        }
                $_SESSION['user_id'] = $row['user_id'];
                //Now we will redirect the user to main page.
                header("location:mainpagelogin.php");
        }
    }   
?>