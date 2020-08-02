<?php
//start session
session_start();
//Connect to database
include 'connection.php';
//Get the id of the note
$note_id = $_POST['id'];
//Get id of user
$user_id = $_SESSION['user_id'];
//Run query to delete the note from the database
$sql = "DELETE FROM notes WHERE id='$note_id' && user_id='$user_id'";
$result = mysqli_query($conn,$sql);
if(!$result){
echo 'error';
}

?>