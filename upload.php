<?php
require_once("config.php");
$statusMsg = '';

// File upload path
$targetDir = "images/user/avatar/";
$userId = $_POST["user"];
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {

    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif');

    if(in_array($fileType, $allowTypes)){

        // Upload file to directory
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){

          $fileName = mysqli_real_escape_string($connection, $fileName);

          $sql = "UPDATE users 
            SET avatar = '$fileName'
            WHERE id =" . (int) $userId;

          if (mysqli_query($connection, $sql)) {
           $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
          } else {
            $statusMsg = "File upload failed, please try again.";
          }
        } else {
          $statusMsg = "Sorry, there was an error uploading your file.";
        }
    } else {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.';
    }
} else {
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
?>