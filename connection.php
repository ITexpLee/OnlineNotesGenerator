<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "udemy2k19";    
//Connect to Database
$conn = mysqli_connect($servername,$username,$password,$database);
    if(!$conn){
    die("connection failed: ".mysqli_connect_error());
    }
?>