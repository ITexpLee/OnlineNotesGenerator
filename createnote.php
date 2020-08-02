<?php
//create session
session_start();
//connect database
include 'connection.php';
//get userid
$user_id = $_SESSION['user_id'];
//get the current time
$time = time();
//Run query to create New node
$sql = "INSERT INTO notes (`user_id`,`note`,`time`) VALUES ('$user_id','','$time')";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "error";
}
else{
    //This function returns the auto generated id in last query
    echo mysqli_insert_id($conn);
}
?>