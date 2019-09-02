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

        $fileTmp = $_FILES["file"]["tmp_name"];
      
        // Check Image Size 
        $imageWidth = getimagesize($fileTmp)[0];
    
        if($imageWidth <= 200) {

          // Upload file to directory
          if(move_uploaded_file($fileTmp, $targetFilePath)){

            $fileName = mysqli_real_escape_string($connection, $fileName);

            $sql = "UPDATE users 
              SET avatar = '$fileName'
              WHERE id =" . (int) $userId;

            if (mysqli_query($connection, $sql)) {
             setSuccessMessage('Successfully uploaded your image.');
            } else {
              setErrorMessage('File upload failed, please try again.');
            }
          } else {
             setErrorMessage('Sorry, there was an error uploading your file.');
          }

        } else {
          setErrorMessage('Sorry, Maximum Width is 200px');
        }
        
    } else {
         setErrorMessage('Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.');
    }
} else {
     setErrorMessage('Please select a file to upload.');
}

header('Location: profile.php?id=' . $userId);