<?php
require_once("helper.php");

//
// Routing 
//

function setMessage($type, $message) {
  $sessionMessage = [
    'type' => $type, 
    'msg' => $message
  ];
  $_SESSION["session_message"][] = $sessionMessage;
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

function getUser($connection, $userId) {
  if (is_numeric($userId)) {

    // Get Post from DB 
    $sql = "SELECT * FROM users WHERE id =" . mysqli_real_escape_string($connection, $userId);

    if ($result = mysqli_query($connection, $sql)) {

      if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_array($result)) {

          // Create a user array with keys and the user info
          $user = [
            'username' => $row['username'], 
            'created' => $row['created_at'],
            'is_admin' => (int)$row['is_admin']
          ];

          return $user;
        }

      }
      return false;
    }
    return false;
  } 
  return false;
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
    
    // Check if user has posted the post
    if ($_SESSION["user_id"] === $post['user_id']) {
      return true;
    }

    // Check if logged in user is admin
    if (getIsAdmin($connection, $_SESSION["user_id"])) {
      return true;
    }

  }

  return false;  
}

function canEditUser($connection, $userId) {

  // Check id is valid
  if (is_numeric($userId)) {

    $user = getUser($connection, $userId);

    // Check user exists
    if ($user) {

      //
      // Move $_SESSION["user_id"] to its own function
      // then use in avatar-upload
      //

      // Check if same user is logged in
      if ($_SESSION["user_id"] === $userId) {
        return true;
      }

      // Check if logged in user is admin
      if(getIsAdmin($connection, $_SESSION["user_id"])) {
        return true;
      }

    }
    return false;
  }
  return false;
}

function hasUserAvatar($connection, $userId) {
  if (is_numeric($userId)) {

    $sql = "SELECT avatar FROM users WHERE id =" . mysqli_real_escape_string($connection, $userId);

    $row = getSQLRow($sql, $connection);

    if ($row) {
      $avatar = $row['avatar'];

      if ($avatar) {
        $filePath = '/images/user/' . $userId . '/avatar/';
        return $filePath . $avatar;
      }

      return false;

    }
    return false; 
  } 
  return false;
}

function getPost($connection, $postId){
  if (is_numeric($postId)) {

    // Get Post from DB 
    $sql = "SELECT * FROM posts WHERE id =" . mysqli_real_escape_string($connection, $postId);

    if ($result = mysqli_query($connection, $sql)) {

      if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_array($result)) {

          // Create a post array with keys and the post info
          $post = [
            'title' => $row['title'], 
            'message' => $row['message'],
            'created' => $row['created_at'],
            'user_id' => (int)$row['user_id'],
            'id' => (int)$row['id']
          ];

          // Add each post to posts 
          return $post;
        }

      }

    }

  } 

  return false;

}

function getAllUserPosts($connection, $userId) {
  if (is_numeric($userId)) {

    $sql = "SELECT * FROM posts WHERE user_id =" . mysqli_real_escape_string($connection, $userId);

    if ($result = mysqli_query($connection, $sql)) {

     if (mysqli_num_rows($result) > 0) {

      $posts = [];

      while($row = mysqli_fetch_array($result)) {

        // Create a post array with keys and the post info
        $post = [
          'id' => $row['id'], 
          'user_id' => $row['user_id'], 
          'title' => $row['title'], 
          'message' => $row['message'],
          'created' => $row['created_at'],
          'updated' => $row['updated_at']
        ];

        // Add each post to posts 
        array_push($posts, $post);
      }

      return $posts;

      }

    }

  } 

  return false;
}

function getUsername($connection, $userId) {
  if (is_numeric($userId)) {

    $sql = "SELECT username FROM users WHERE id =" . mysqli_real_escape_string($connection, $userId);

    $row = getSQLRow($sql, $connection);

    if ($row) {

      $username = $row['username'];

      return $username;
    }

   return false;
    
  } 

  return false;

}

function getIsAdmin($connection, $userId) {
  if (is_numeric($userId)) {

    $sql = "SELECT is_admin FROM users WHERE id =" . mysqli_real_escape_string($connection, $userId);

    $row = getSQLRow($sql, $connection);

    if ($row) {

      // Make it return integer instead of string
      $isAdmin = (int) $row['is_admin'];

      return $isAdmin;
    }

    return false; 
  } 

  return false;

}

function getUserId() {
  return $_SESSION["user_id"];
}


//
// MarkDown for Posts
//
function renderMarkDown($string) {

  $functions = array(
    'links' => function($string) {
      $regex = '/\[([\w\s\d]+)\]\((.+)\)/';
      preg_match_all($regex, $string, $matches);

      list($fullLink, $title, $url) = $matches;

      foreach ($fullLink as $key => $value) {

        $string = str_replace(
          $value, 
          '<a href="' .$url[$key]. '" title="' .$title[$key]. '">' .$title[$key]. '</a>', 
          $string
        );
      }
      return $string;
    },
    'heading' => function($string) {
      preg_match_all('/^(#{1,6})\s(.+)/m', $string, $matches);
      list($markdown, $hashes, $heading) = $matches;

      foreach ($markdown as $key => $value) {

        $headingLevel = strlen($hashes[$key]);

        $string = str_replace(
          $value, 
          '<h' .$headingLevel. '>' .$heading[$key]. '</h' .$headingLevel. '>', 
          $string
        );
      }
      return $string;
    },
    'boldText' => function($string) {
      return preg_replace('/\*([^\*]+)\*/', '<strong>$1</strong>', $string);
    },
    'empatiseText' => function($string) {
      return preg_replace('/\_([^\*]+)\_/i', '<em>$1</em>', $string);
    }

  );

  // Wish I could do something like this? 
  // $functions = array(
  //   'links' => links($string),
  //   'heading' => heading($string),
  //   'boldText' => boldText($string),
  //   'empatiseText' => empatiseText($string)
  // );

  foreach($functions as $function) {
    $string = $function($string);
  }

  return $string;
}

