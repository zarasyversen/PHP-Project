<?php 

namespace Repository;

use Model\User;
use Helper\DB;
use Helper\Session;

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
  
    $thisUser = DB::selectFirst(self::TABLE_NAME, $where);

    if ($thisUser) {
      $user = new User();
      $user->setId((int)$thisUser['id']);  
      $user->setName($thisUser['username']);
      $user->setIsAdmin($thisUser['is_admin']);
      $user->setCreatedAt($thisUser['created_at']);
      $user->setAvatar($thisUser['avatar']);
      
      return $user;
    }

    throw new \Exceptions\NotFound("Sorry, that user does not exist");
  }

  /**
   * Upload Avatar
   */
  public static function uploadAvatar(int $userId, $fileName) {

    $set = [
      'avatar' => $fileName
    ];

    $where = ['id', $userId];

    if (DB::update(self::TABLE_NAME, $set, $where)) {
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

    if (DB::update(self::TABLE_NAME, $set, $where)) {
      return true;
    }

    return false;
  }

  /**
   * Check if User already exists
   */
  public static function doesUserExist($userName) {

    $where = [
      'username' => $userName
    ];

    $select = 'id';

    $row = DB::selectFirst(self::TABLE_NAME, $where, null, 'ASC', $select);

    if ($row['id'] !== null) {
      return true;
    }
  }

  /**
   * Create User
   */
  public static function createUser($userName, $password) {
    $insert = [
      'username' => $userName,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    if (DB::insert(self::TABLE_NAME, $insert)) {
      return true;
    }

    throw new \Exceptions\NotSaved("Unable to create user");

  }

  /**
   * Login User
   */
  public static function login($userName) {
    $where = [
      'username' => $userName
    ];

    $select = 'id, username, password';

    $thisUser = DB::selectFirst(self::TABLE_NAME, $where, null, 'ASC', $select);

    if ($thisUser) {
      $user = new User();
      $user->setId((int)$thisUser['id']);  
      $user->setName($thisUser['username']);
      $user->setPassword($thisUser['password']);
      return $user;
    }

    throw new \Exceptions\NotFound("Sorry, that user does not exist");
  }

  /**
   * Reset Password
   */
  public static function resetPassword($password) {

    $set = [
      'password' => $password
    ];

    $where = ['id', Session::getSessionUserId()];

    if (DB::update(self::TABLE_NAME, $set, $where)) {
      return true;
    }

    return false;
  }

}