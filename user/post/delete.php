<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

if (isset($_GET["id"]) && canEditPost($connection, $_GET['id'])){

  // Is it safe to just use GET['id'] here. 
  // It should have been checked in canEditPost
  $sql = "DELETE FROM posts WHERE id =" . $_GET['id'];

    if($result = mysqli_query($connection, $sql)) {
      // Set a session message and redirect to welcome
      Helper\Session::setSuccessMessage('Successfully deleted your message.');
    } else {
      // Set a session message and redirect to welcome
      Helper\Session::setErrorMessage('Sorry. Something went wrong, please try again.');
    }

    header("location: /page/welcome.php");
  
} else {
  // Set a session message and redirect to welcome
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
  header("location: /page/welcome.php");
}

