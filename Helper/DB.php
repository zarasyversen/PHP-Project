<?php 
namespace Helper;

/**
 * Database
 */
class DB {

  protected static $connection;
  protected static $dbh;

  /**
   * Database Connection
   */
  public static function getConnection() {
   
    if (!isset(self::$connection)) {
      $dbhost = "localhost"; // 127
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

  private static function getPdo() {

    if (!isset(self::$dbh)) {
      $dsn = 'mysql:dbname=php_project;host=127.0.0.1';
      $user = 'root';
      $password = 'root';

      try {
          self::$dbh = new \PDO($dsn, $user, $password);
      } catch (\PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
    }
    
    // Show Errors
    self::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return self::$dbh;
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

    $dbh = self::getPdo();
    //
    // Prepare Data to use in SQL
    //
    list($column, $columnValue) = $where;

    $prepareSet = [];
    foreach($set as $key => $val) {
        $prepareSet[] = "`$key` = :$key";
    };

    //
    // Prepare SQL
    //
    $sql = "UPDATE `$tableName` ";
    $sql .= "SET " . implode(", " , $prepareSet);
    $sql .= " WHERE `" .$column. "`  ";

    //
    // Prepare Statement
    //
    $sth = $dbh->prepare($sql);

    // Bind params
    foreach ($set as $key => $val) {
      $sth->bindValue(':'.$key, $val);
    }

    // Bind Where
    $sth->bindParam(':'.$column, $columnValue);

    try {
    $sth->execute();
    return true;

    } catch(\PDOException $e) {
        echo $e;
    } 

  }

  public static function insert($tableName, $insert) {

    $dbh = self::getPdo();

    $insertKeys = [];
    $placeHolders = [];
    foreach($insert as $key => $val) {
        $insertKeys[] = "`$key`";
        $placeHolders[] = ":$key";
    }

    //
    // Prepare SQL
    //
    $sql = "INSERT `$tableName` ";
    $sql .= "(" . implode(", ", $insertKeys) . ")";
    $sql .= " VALUES (" . implode(", ", $placeHolders) . ")";

    //
    // Prepare Statement
    //
    $sth = $dbh->prepare($sql);

    // Bind params
    foreach ($insert as $key => $val) {
      $sth->bindValue(':'.$key, $val);
    }

    try {
      $sth->execute();
      return true;
    } catch(\PDOException $e) {
        echo $e;
    }

  }

  public static function select($tableName, $where = null, $order = null, $sort = null) {
    $dbh = self::getPdo();

    //
    // Prepare SQL
    //
    $sql = "SELECT * ";
    $sql .= "FROM `$tableName`";

    if ($where) {

      $whereKeys = [];
      foreach($where as $key => $val) {
          $whereKeys[] = "`$key` = :$key";
      }

      $sql .= " WHERE " . implode(", ", $whereKeys);
    }

    if ($order) {
      $sql .= " ORDER BY `$order`";
    }

    if ($sort) {
      $sql .= " `$sort`";
    }

    // var_dump($sql);
    // die('hej');


    $stmt = $dbh->query($sql);

    return $stmt->fetchAll();
  }

}
