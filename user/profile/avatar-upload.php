<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

// Check if User exits
if(!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  setErrorMessage('Sorry, that user does not exist.');
  header("location: /page/welcome.php");
} elseif (!canEditUser($connection, intval($_GET['id']))) {
  // Check if User can edit
  setErrorMessage('Sorry, you are not allowed to edit this profile.');
  header("location: /user/profile.php?id=" . intval($_GET['id']));
}

$userId = intval($_GET['id']);
$timestamp = time();
$targetDir = BASE . "/images/user/" . $userId . "/avatar/";
$fileName = $timestamp . "_" . basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName ;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);



if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {

  $allowTypes = array('jpg','png','jpeg','gif');

  //
  // Check if file is allowed type
  //
  if (in_array($fileType, $allowTypes)) {

    $fileTmp = $_FILES["file"]["tmp_name"];
    $fileSize = filesize($fileTmp);
    $maxFileSize = 80000; // 80kb

    //
    // Check FileTmp and FileSize
    //
    if ($fileTmp && $fileSize < $maxFileSize) {
    
      // Set Image Variables
      list($imageWidth, $imageHeight) = getimagesize($fileTmp);
      $maxImageWidth = 200;
    
      // No bigger than 200px wide
      if ($imageWidth <= $maxImageWidth) {

        //
        // Create Folder for User if it does not exist
        //
        if (!is_dir($targetDir)) {
          mkdir($targetDir, 0744, true); // TEST
        }

        // Upload file to directory
        if (move_uploaded_file($fileTmp, $targetFilePath)) {

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
     setErrorMessage('Sorry, Maximum file size is 80kb.');
    }

  } else {
    setErrorMessage('Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.');
  }

} else {
  setErrorMessage('Please select a file to upload.');
}

header('Location: /user/profile.php?id=' . $userId);