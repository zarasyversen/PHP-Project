<?php

function canEditPost($username){

  // Potentially change to id soon 
  // Check session username matches post username
  if($_SESSION["username"] === $username){
    return true;
  }
  
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
            'username' => $row['username']
          ];

          // Add each post to posts 
          return $post;
        }
      } else {
        return false;
      }
    }
  }
}