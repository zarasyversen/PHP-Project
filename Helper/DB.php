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

    $dsn = 'mysql:dbname=php_project;host=127.0.0.1';
    $user = 'root';
    $password = 'root';

    try {
        $dbh = new \PDO($dsn, $user, $password);
    } catch (\PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    // Show Errors
    $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


    //
    // Prepare Data to use in SQL
    //
    list($column, $columnValue) = $where;

    $values = [];
    $emptyVals = [];
    foreach($set as $key => $val) {
        $values[] = "$val";
        $prepareSet[] = "$key = ?";
    };


    //
    // Prepare SQL
    //
    $sql = "UPDATE `$tableName` ";
    $sql .= "SET `" . implode(" " , $prepareSet) . "`";
    $sql .= " WHERE " .$column. " = ?";

    //
    // Prepare Statement
    //
    $sth = $dbh->prepare($sql);

    // Array to bind all key and values, including WHERE. 
    // $sqlValues = array_merge($set, [$column => $columnValue]);

    // Bind params
    foreach ($set as $key => $val) {
      $sth->bindParam($key, $val);
    }

    // Bind Where
    $sth->bindParam($column, $columnValue);

    // Array with only values to pass in the execute
    $values[] = $columnValue;

    try {
    $sth->execute($values);

    } catch(\PDOException $e) {
        echo $e;
    } 

  }

  // public static function insert($tableName, $insertValues) {

  //   $rows = [];
  //   $values = [];
  //   $emptyVals = [];

    // foreach($insertValues as $key => $val) {
    //     $rows[] = "$key";
    //     $values[] = "$val";
    //     $emptyVals[] = "?";
    // }

  //   $sql = "INSERT INTO ".$tableName." (" .implode(', ', $rows). ") VALUES (" .implode(', ', $emptyVals). ")";


  //   if ($statement = mysqli_prepare(self::$connection, $sql)) {

  //     // $valsz = implode(',', $rows);
  //     // var_dump($valsz);

  //     // // Bind variables to prepared statement
  //     // mysqli_stmt_bind_param($statement, "iss", implode(', ', $rows));

  //     // // Set params
  //     // $param_table = $tableName;

  //     // Set dynamic params
  //     for($i = 0; count($rows) > $i; $i++) {

  //       $param_{"$rows[$i]"} = $values[$i];
  //       var_dump($rows[$i]);
  //       var_dump($values[$i]);

  //     }

  //     echo $param_table;
  //     echo $param_userid;
  //     echo $param_title;
  //     echo $param_message;

  //     die('hej');

  //     // $param_userid = $post->getUserId();
  //     // $param_title = $post->getTitle();
  //     // $param_message = $post->getMessage();

  //     // Attempt to execute statement 
  //     if (mysqli_stmt_execute($statement)) {
  //       return true;
  //     }

  //     // Close statement
  //     mysqli_stmt_close($statement);
  //   }

  //   throw new \Exceptions\NotSaved("Unable to save post");
  // }
  
}
