<?php 
require_once("config.php");
require_once("functions.php");

if (isset($_GET["id"]) || canEditPost($connection, $_GET['id'])){

  // Is it safe to just use GET['id'] here. 
  // It should have been checked in canEditPost
  $sql = "DELETE FROM posts WHERE id =" . $_GET['id'];

    if($result = mysqli_query($connection, $sql)) {
        // Set a param with success on the url and redirect to welcome
        header("location: welcome.php?deleted");
    } else {
      header("location: welcome.php?error");
    }
  
} else {
  header("location: welcome.php?noedit");
}

