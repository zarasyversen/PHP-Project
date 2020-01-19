<?php 
namespace Helper;

/**
 * Database
 */
class DB {

  protected static $connection;

  /**
   * Database Connection
   */
  public static function getConnection() {
   
    if (!isset(self::$connection)) {
      $dbhost = "localhost";
      $dbusername = "root";
      $dbpassword = "root";
      $dbname = "php_project";

      $connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

      if ($connection) {
        self::$connection = $connection;
      } else {
        die('Unable to Connect to Database');
      }

    } 
   
   return self::$connection;
  }

  /**
   * Delete Query
   */
  public static function delete($tableName, $where) {

    list($column, $columnValue) = $where;

    // Escape Strings
    $tableName = mysqli_real_escape_string(self::$connection, $tableName);
    $column = mysqli_real_escape_string(self::$connection, $column);

    // Create SQL
    $sql = "DELETE FROM " .$tableName." WHERE ".$column." = ? ";

    //Prepare statement
    if ($statement = mysqli_prepare(self::$connection, $sql)) {

      // Bind variables to prepared statement
      mysqli_stmt_bind_param($statement, "i", $param_value);

      // Set params
      $param_value = $columnValue;

      // Attempt to execute statement 
      if (mysqli_stmt_execute($statement)) {
        return true;
      }

      // Close statement
      mysqli_stmt_close($statement);
    }

  }

  public static function update($tableName, $set, $where) {

    $cols = [];
    list($column, $columnValue) = $where;

    foreach($set as $key => $val) {
        $cols[] = "$key = '" . mysqli_real_escape_string(self::$connection, $val). "'";
    }

    $sql = "UPDATE ".$tableName." SET " . implode(', ', $cols) . " WHERE " .$column. " = ?";
 
    //Prepare statement
    if ($statement = mysqli_prepare(self::$connection, $sql)) {

      // Bind variables to prepared statement
      mysqli_stmt_bind_param($statement, "i", $param_value);

      // Set params
      $param_value = $columnValue;

      // Attempt to execute statement 
      if (mysqli_stmt_execute($statement)) {
        return true;
      }

      // Close statements
      mysqli_stmt_close($statement);
    }

  }
  
}
