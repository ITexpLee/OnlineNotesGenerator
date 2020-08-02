<?php
//session start
session_start();
//load database
include 'connection.php';
//get user id
$user_id = $_SESSION['user_id'];
//Run query to delete empty notes
$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($conn,$sql);
if(!$result){
    echo "<div class='alert alert-danger'>An Error Occured!</div>";
    exit();
}
//Run other Query to look for Notes made by user
$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY time DESC";
if($result = mysqli_query($conn,$sql)){
    //Checking if No. of Rows is greater than 0
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $note_id = $row['id'];
            $note = $row['note'];
            $time = $row['time'];
            $time = date("F d, Y h:i:s A",$time);
            //Echo the notes
        echo"<div class='note'>
            <div class='col-xs-5 col-sm-3 delete'>
                <button class='btn btn-danger btn-lg w-100'>
                Delete
                </button>
            </div>
            <div class='noteheader' id='$note_id'>
                <div class='text'>$note</div>
                <div class='timetext'>$time</div>
            </div>
        </div>";    
        }
    }
    else{
    echo "<div class='alert alert-danger'>You have not created any Notes yet!</div>";
    }
}
else{
    echo "<div class='alert alert-danger'>An Error Occured!</div>";
    echo "Unable to execute: $sql." .mysqli_error($conn);
}

?>