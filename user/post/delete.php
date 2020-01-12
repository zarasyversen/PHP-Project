<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

if (isset($_GET["id"]) && canEditPost($connection, $_GET['id'])){

  if (PostRepository::delete($_GET["id"])) {
    Helper\Session::setSuccessMessage('Successfully deleted your message.');
  } else {
    Helper\Session::setErrorMessage('Sorry. Something went wrong, please try again.');
  }

  header("location: /page/welcome.php");

} else {
  // Set a session message and redirect to welcome
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
  header("location: /page/welcome.php");
}

