<?php 

namespace Helper;

class Connection {

  public static function getConnection() {
    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "root";
    $dbname = "php_project";

    $connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

    if ($connection) {
      return $connection;
    } else {
    die('Could not connect');
   }

  }
  
}
