<?php 
namespace Controller\Profile\Avatar;

use UserRepository;
use Helper\Session as Session;

class Create {

  public function view($id) {

    $user = UserRepository::getUser($id);
    $user->canEditUser();

    $timestamp = time();
    $targetDir = BASE . "/images/user/" . $id . "/avatar/";
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

              if (UserRepository::uploadAvatar($id, $fileName)) {
                Session::setSuccessMessage('Successfully uploaded your image.');
              } else {
                Session::setErrorMessage('File upload failed, please try again.');
              }

            } else {
              Session::setErrorMessage('Sorry, there was an error uploading your file.');
            }

          } else {
            Session::setErrorMessage('Sorry, Maximum Width is 200px');
          }

        } else {
         Session::setErrorMessage('Sorry, Maximum file size is 80kb.');
        }

      } else {
        Session::setErrorMessage('Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.');
      }

    } else {
      Session::setErrorMessage('Please select a file to upload.');
    }

    $url = '/profile/' .$id;
    header('Location:' . $url);
    
  }

}
