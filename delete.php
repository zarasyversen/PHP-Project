<?php 
require_once("config.php");
require_once("functions.php");

if (isset($_GET["id"]) || canEditPost($connection, $_GET['id'])){

  // Is it safe to just use GET['id'] here. 
  // It should have been checked in canEditPost
  $sql = "DELETE FROM posts WHERE id =" . $_GET['id'];

    if($result = mysqli_query($connection, $sql)) {
        // Set a session message and redirect to welcome
        $_SESSION["session_message"] = 'Successfully deleted your message';
        header("location: welcome.php");
    } else {
      // Set a session message and redirect to welcome
      $_SESSION["session_message"] = 'Sorry. Something went wrong, please try again.';
      header("location: welcome.php?error");
    }
  
} else {
  // Set a session message and redirect to welcome
  $_SESSION["session_message"] = 'Sorry, you are not allowed to edit that post';
  header("location: welcome.php");
}

