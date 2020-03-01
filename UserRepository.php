<?php 

/**
 * UserRepository Class
 * DB Queries to create User
 */
class UserRepository {

  const TABLE_NAME = 'users';

  /**
   * Get User
   * Returns Object {}
   */
  public static function getUser(int $userId) : User {

    $where = [
      'id' => $userId
    ];
  
    $thisUser = Helper\DB::selectFirst(self::TABLE_NAME, $where);

    if ($thisUser) {
      $user = new User();
      $user->setId((int)$thisUser['id']);  
      $user->setName($thisUser['username']);
      $user->setIsAdmin($thisUser['is_admin']);
      $user->setCreatedAt($thisUser['created_at']);
      $user->setAvatar($thisUser['avatar']);
      
      return $user;
    }

    throw new \Exceptions\NotFound("User $userId does not exist");
  }

  // Can this be a static function
  public static function getIsAdmin(int $userId) {

    $where = [
      'id' => $userId
    ];

    $select = 'is_admin';

    $row = Helper\DB::selectFirst(self::TABLE_NAME, $where, null, 'ASC', $select);

    // Make in to int - should this be set on the user? like username?
    if ((int)$row['is_admin'] === 1) {
      return true;
    }

  }

  public static function getUserName(int $userId) {

    $where = [
      'id' => $userId
    ];

    $select = 'username';

    $row = Helper\DB::selectFirst(self::TABLE_NAME, $where, null, 'ASC', $select);


    if ($row['username'] !== null) {
      $user = new User();
      $user->setName($row['username']);

      return $user;
    }

  }

  /**
   * Upload Avatar
   */
  public static function uploadAvatar(int $userId, $fileName) {

    $set = [
      'avatar' => $fileName
    ];

    $where = ['id', $userId];

    if (Helper\DB::update(self::TABLE_NAME, $set, $where)) {
      return true;
    }

    return false;
  }


  /**
   * Delete Avatar
   */
  public static function deleteAvatar(int $userId) {

    $set = [
      'avatar' => NULL
    ];

    $where = ['id', $userId];

    if (Helper\DB::update(self::TABLE_NAME, $set, $where)) {
      return true;
    }

    return false;
  }

}