<?php 
namespace Helper;

/**
 * Database
 */
class DB {

  protected static $dbh;

  /**
   * PDO Connection
   */
  private static function getPdo()
  {
    if (!isset(self::$dbh)) {
      $dsn = 'mysql:dbname=php-project;host=127.0.0.1';
      $user = 'root';
      $password = '';

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
  public static function delete($tableName, $where)
  {
    $dbh = self::getPdo();
    list($column, $columnValue) = $where;

     // Prepare SQL
    $sql = "DELETE FROM " .$tableName." WHERE ".$column." = :" .$column;
    $stmt = $dbh->prepare($sql);

    // Bind params
    $stmt->bindValue(':'.$column, $columnValue);
    
    try {
      $stmt->execute();
      return true;
    } catch(\PDOException $e) {
      echo $e;
    }
  }

  /**
   * Update Query
   */
  public static function update($tableName, $set, $where)
  {
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
    $sql .= " WHERE `" .$column. "` = :$column";

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

  /**
   * Insert Query
   */
  public static function insert($tableName, $insert)
  {
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

  /**
   * Select Query : All Items
   */
  public static function select($select, $tableName, $where = null, $order = null, $direction = 'ASC')
  {
    $stmt = self::buildSelectQuery($select, $tableName, $where, $order, $direction);

    $allItems = $stmt->fetchAll();

    if ($allItems !== null) {
      return $allItems;
    } 
  }

  /**
   * Select Query : First Item
   */
  public static function selectFirst($select, $tableName, $where = null, $order = null, $direction = 'ASC')
  {
    $stmt = self::buildSelectQuery($select, $tableName, $where, $order, $direction);

    $firstItem = $stmt->fetch();

    if ($firstItem && $firstItem !== null) {
      return $firstItem;
    }
  }

  /**
   * Select Query : Build SQL
   */
  private static function buildSelectQuery($select, $tableName, $where = null, $order = null, $direction = 'ASC')
  {
    $dbh = self::getPdo();

    /**
     * Prepare SQL
     */
    $sql = "SELECT $select ";
    $sql .= "FROM `$tableName`";

    /**
     * Check Params
     */
    if ($where) {

      $whereKeys = [];
      foreach($where as $key => $val) {
          $whereKeys[] = "`$key` = :$key";
      }

      $sql .= " WHERE " . implode(", ", $whereKeys);
    }

    if ($order) {
      $sql .= " ORDER BY `$order` $direction";
    }
    
    // Prepare SQL
    $stmt = $dbh->prepare($sql);

    // Bind if necessary
    if ($where) {
      foreach ($where as $key => $val) {
        $stmt->bindParam(':'.$key, $val);
      }
    }

    // Execute 
    try {
      $stmt->execute();
      return $stmt;
    } catch(\PDOException $e) {
        echo $e;
    }
  }
}
