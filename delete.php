<?php 
require_once("config.php");
require_once("functions.php");

if (isset($_GET["id"])) {
  $postId = htmlspecialchars($_GET["id"]);
  $post = getPost($connection, $postId);

  // Check if posts exists && check for valid ID 
  if($post && is_numeric($postId)) {

    //
    // Check if user edit the post 
    //
    if(canEditPost($post['username'])){

      $sql = "DELETE FROM posts WHERE id =" . $postId;

      if($result = mysqli_query($connection, $sql)) {
          // Set a param with success on the url and redirect to welcome
          header("location: welcome.php?deleted");
      } else {
        header("location: welcome.php?error");
      }
    } else {
      header("location: welcome.php?noedit");
    }

  } else {
    header("location: welcome.php?nopost");
  }

}

