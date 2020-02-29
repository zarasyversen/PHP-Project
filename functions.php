<?php
require_once("helper.php");

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

function getUserId() {
  return $_SESSION["user_id"];
}


