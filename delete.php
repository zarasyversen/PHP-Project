<?php 
require_once("config.php");
require_once("functions.php");

if (isset($_GET["id"])) {
  $postId = htmlspecialchars($_GET["id"]);

  if(is_numeric($postId)) {

    //
    // Check if posts exists before deleting 
    //
    $post = getPost($connection, $postId);
    if($post){

      $sql = "DELETE FROM posts WHERE id =" . $postId;

      if($result = mysqli_query($connection, $sql)) {
          // Set a param with success on the url and redirect to welcome
          header("location: welcome.php?deleted");
      } else {
        header("location: welcome.php?error");
      }
    } else {
      header("location: welcome.php?nopost");
    }

  } else {
    header("location: welcome.php?nopost");
  }

}

