<?php

function setMessage($type, $message) {
  $sessionMessage = [$type, $message];
  $_SESSION["session_message"] = $sessionMessage;
}

function setSuccessMessage($message) {
  $type = 'success';
  setMessage($type, $message);
}

function setErrorMessage($message) {
  $type = 'error';
  setMessage($type, $message);
}

// Show Message if it is Set
function showMessage() {
 if(isset($_SESSION["session_message"])) {
  
  // store it in var before you delete it
  $sessionMessage = $_SESSION['session_message'];

  // remove it
  unset($_SESSION['session_message']);

  // return message 
  return $sessionMessage;
 }
}

function canEditPost($connection, $postId) {
  
  // 
  // Check if postId is an array
  // 
  if (is_array($postId)) {
    if (isset($postId['id'])) {
      $postId = $postId['id'];
    }

    return false;
  }

  //
  // Get Post 
  // Check it exists and id is valid
  //
  $post = getPost($connection, $postId);
  if ($post && is_numeric($postId)) {

    // Potentially change to id soon 
    // Check session username matches post username
    if($_SESSION["username"] === $post['username']){
      return true;
    }

  }

  return false;  
}

function getPost($connection, $postId){
  if(is_numeric($postId)){

    // Get Post from DB 
    $sql = "SELECT * FROM posts WHERE id =" . mysqli_real_escape_string($connection, $postId);

    if($result = mysqli_query($connection, $sql)) {

      if(mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_array($result)) {

          // Create a post array with keys and the post info
          $post = [
            'title' => $row['title'], 
            'message' => $row['message'],
            'created' => $row['created_at'],
            'username' => $row['username'],
            'id' => $row['id']
          ];

          // Add each post to posts 
          return $post;
        }

      }

    }

  } 

  return false;

}