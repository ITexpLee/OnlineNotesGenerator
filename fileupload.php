<?php 
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["filesToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//Check wether the file is of img format or not.
if(isset($_POST["submit"])){
    $check = getimagesize($_FILES["filesToUpload"]["tmp_name"]);
        if($check !== false){
            echo "File is an image - ".$check["mime"].".";
            $uploadOk = 1;
        else{
            echo "FILE is not an image.";
            $uploadOk = 0;
            }    
        }
    }
?>