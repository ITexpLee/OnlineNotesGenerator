<?php
if(isset($_SESSION['user_id']) && $_GET['logout'] == 1){
//Destroy session
    session_destroy();
//Destroy the cookie for remember me
    setcookie("rememberme","",time()-3600);
}
?>