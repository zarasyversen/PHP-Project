<?php 
require_once("config.php");

if (isset($_GET["id"])) {
  $postId = htmlspecialchars($_GET["id"]);

  if($postId) {

    // Get Post from DB 
    $sql = "DELETE FROM posts WHERE id =" . mysqli_real_escape_string($connection, $postId);

    if($result = mysqli_query($connection, $sql)) {

        // Set a param with success on the url and redirect to welcome
        header("location: welcome.php?deleted");
    } 
  } else {
        $error = 'Something went wrong, please try again later.';
  }

}

