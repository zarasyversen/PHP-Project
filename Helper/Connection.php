<?php 
namespace Helper;

/**
 * Connection to Database
 */
class Connection {

  protected static $connection;

  public static function getConnection() {
   
    if (!isset(self::$connection)) {
      $dbhost = "localhost";
      $dbusername = "root";
      $dbpassword = "root";
      $dbname = "php_project";

      //
      // BUT If I change details / it errors 
      // It shows before my die, do i want that 
      //
      $connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

      if ($connection) {
        self::$connection = $connection;
      } else {
        die('Unable to Connect to Database');
      }

    } 
   
   return self::$connection;
  }
  
}
