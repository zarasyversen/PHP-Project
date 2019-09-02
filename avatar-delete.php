<?php 
require_once("config.php");

// Check if User exits
if(!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  setErrorMessage('Sorry, that user does not exist.');
  header("location: welcome.php");
} elseif (!canEditUser($connection, intval($_GET['id']))) {
  // Check if User can edit
  setErrorMessage('Sorry, you are not allowed to edit this profile.');
  header("location: profile.php?id=" . intval($_GET['id']));
} else {

 $sql = "UPDATE users 
        SET avatar = NULL
        WHERE id =" . intval($_GET['id']);

    if($result = mysqli_query($connection, $sql)) {
      setSuccessMessage('Successfully deleted your avatar.');
    } else {
      setErrorMessage('Sorry. Something went wrong, please try again.');
    }
    header("location: profile.php?id=" . intval($_GET['id']));
}
