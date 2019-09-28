<?php

//
// Return SQL Row
//
function getSQLRow($params, $connection) {

  $sql = $params;

  if($result = mysqli_query($connection, $sql)) {

    if(mysqli_num_rows($result) > 0) {

      //return row, then can call what you want like [username]
      return mysqli_fetch_assoc($result);
    }

    return false;
  }
  return false;
}
?>