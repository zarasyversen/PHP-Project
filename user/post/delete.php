<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

if (isset($_GET["id"]) && canEditPost($connection, $_GET['id'])){

  PostRepository::delete($_GET["id"]);

} else {
  // Set a session message and redirect to welcome
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
  header("location: /page/welcome.php");
}

