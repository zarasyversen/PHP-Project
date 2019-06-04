<?php 
require_once("config.php");

if (isset($_GET["id"])) {
  $postId = htmlspecialchars($_GET["id"]);

  if(is_numeric($postId)) {

    // Get Post from DB 
    $sql = "DELETE FROM posts WHERE id =" . $postId;

    if($result = mysqli_query($connection, $sql)) {
        // Set a param with success on the url and redirect to welcome
        header("location: welcome.php?deleted");
    } else {
    }
  } else {
     echo('please enter valid id');
  }

}

