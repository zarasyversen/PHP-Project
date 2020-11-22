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
  private static function getUser($where) : User
  {
    $thisUser = DB::selectFirst('*', self::TABLE_NAME, $where);

    if ($thisUser) {
      $user = new User();
      $user->setId((int)$thisUser['id']);  
      $user->setName($thisUser['username']);
      $user->setIsAdmin($thisUser['is_admin']);
      $user->setCreatedAt($thisUser['created_at']);
      $user->setPassword($thisUser['password']);
      $user->setAvatar($thisUser['avatar']);
      
      return $user;
    }

    throw new \Exceptions\NotFound("Sorry, that user does not exist");
  }

  /**
   * Get User By Id
   * Returns User
   */
  public static function getUserById(int $userId)
  {
    return self::getUser(['id' => $userId]);
  }

  /**
   * Get User By Name
   * Returns User
   */
  public static function getUserByName($userName)
  {
    return self::getUser(['username' => $userName]);
  }

  /**
   * Upload Avatar
   */
  public static function uploadAvatar(int $userId, $fileName)
  {
    if (DB::update(self::TABLE_NAME, ['avatar' => $fileName], ['id', $userId])) {
      return true;
    }

    return false;
  }


  /**
   * Delete Avatar
   */
  public static function deleteAvatar(int $userId)
  {
    if (DB::update(self::TABLE_NAME, ['avatar' => NULL], ['id', $userId])) {
      return true;
    }

    return false;
  }

  /**
   * Check if User already exists
   */
  public static function doesUserExist($userName)
  {
    $row = DB::selectFirst('id', self::TABLE_NAME, ['username' => $userName], null, 'ASC');

    if ($row['id'] !== null) {
      return true;
    }
  }

  /**
   * Create User
   */
  public static function createUser($userName, $password)
  {
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
   * Set User Token when Logged in
   */
  public static function setUserToken($userId)
  {
    $token = bin2hex(random_bytes(70));

    if (DB::update(self::TABLE_NAME, ['token' => $token], ['id', $userId])) {
      return $token;
    }
  }

  public static function getUserFromToken($userToken)
  {
    return DB::selectFirst('id', self::TABLE_NAME, ['token' => $userToken], null, 'ASC')['id'];
  }


  /**
   * Reset Password
   */
  public static function resetPassword($password)
  {
    if (DB::update(self::TABLE_NAME, ['password' => $password], ['id', Session::getSessionUserId()])) {
      return true;
    }

    return false;
  }
}
