<?php
$userId = (int)$_GET['id'];

try {
  $user = UserRepository::getUser($userId);
  $user->canEditUser();
} catch (\Exceptions\NotFound $e) {
  Helper\Session::setErrorMessage('Sorry, that user does not exist.');
  header("location: /welcome");
} catch (\Exceptions\NoPermission $e) {
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit this profile.');
  header("location: /welcome");
  exit;
}

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

          if (UserRepository::uploadAvatar($userId, $fileName)) {
            Helper\Session::setSuccessMessage('Successfully uploaded your image.');
          } else {
            Helper\Session::setErrorMessage('File upload failed, please try again.');
          }

        } else {
          Helper\Session::setErrorMessage('Sorry, there was an error uploading your file.');
        }

      } else {
        Helper\Session::setErrorMessage('Sorry, Maximum Width is 200px');
      }

    } else {
     Helper\Session::setErrorMessage('Sorry, Maximum file size is 80kb.');
    }

  } else {
    Helper\Session::setErrorMessage('Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.');
  }

} else {
  Helper\Session::setErrorMessage('Please select a file to upload.');
}

$url = '/profile/' .$userId;
header('Location:' . $url);