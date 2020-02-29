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
      $user->setId($thisUser['id']);  
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

    $isAdmin = Helper\DB::selectFirst(self::TABLE_NAME, $where, null, 'ASC', $select);

    // Make in to int
    if ((int)$isAdmin['is_admin'] === 1) {
      return true;
    }

  }
// Can this be a static function
  // public static function hasUserAvatar(int $userId) {

  //   $where = [
  //     'id' => $userId
  //   ];

  //   $select = 'avatar';

  //   $avatar = Helper\DB::selectFirst(self::TABLE_NAME, $where, null, 'ASC', $select);

  //   if ($avatar) {
  //     $filePath = '/images/user/' . $userId . '/avatar/';
  //     return $filePath . $avatar;
  //   }
    
  // }

}