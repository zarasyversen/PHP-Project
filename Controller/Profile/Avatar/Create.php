<?php 
namespace Controller\Profile\Avatar;

use Repository\UserRepository;

class Create extends \Controller\Base {

  public function view($name)
  {
    $user = UserRepository::getUserByName($name);
    $user->canEditUser();
    $id = $user->getId();

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
              mkdir($targetDir, 0744, true);
            }

            // Upload file to directory
            if (move_uploaded_file($fileTmp, $targetFilePath)) {

              if (UserRepository::uploadAvatar($id, $fileName)) {
                $this->setData(['session_success' =>'Successfully uploaded your image.']);
              } else {
                $this->setData(['session_error' =>'File upload failed, please try again.']);
              }

            } else {
              $this->setData(['session_error' =>'Sorry, there was an error uploading your file.']);
            }

          } else {
            $this->setData(['session_error' =>'Sorry, Maximum Width is 200px']);
          }

        } else {
         $this->setData(['session_error' =>'Sorry, Maximum file size is 80kb.']);
        }

      } else {
        $this->setData(['session_error' =>'Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.']);
      }

    } else {
      $this->setData(['session_error' =>'Please select a file to upload.']);
    }

    $url = '/profile/' .$name;
    return $this->redirect($url);
  }
}
