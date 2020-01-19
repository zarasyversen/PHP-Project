<?php
require_once("helper.php");

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


