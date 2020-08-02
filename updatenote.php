<?php
//start session
session_start();
//connect to database
include 'connection.php';
//get the id of note sent through Ajax
$id = $_POST['id'];
//get the content of the note sent through Ajax
$note = $_POST['note'];
//get the time.
$time = time();
//run query to update the Note
$sql = "UPDATE notes SET note='$note' , time='$time' WHERE id='$id'";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo 'error';
}
?>