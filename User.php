<?php 

/**
 * User Class
 */
class User {

  public $id;
  public $name;
  public $avatar;
  public $isAdmin;
  public $createdAt;

  /**
   * Id 
   */
  public function setId($new_id) { 
    $this->id = $new_id;  
  }
 
  public function getId() {
    return $this->id;
  }

  /**
   * Name
   */
  public function setName($new_name) { 
    $this->name = $new_name;  
  }
 
  public function getName() {
    return $this->name;
  }

  /**
   * Avatar
   */
  public function setAvatar($new_avatar) { 
    $this->avatar = $new_avatar;  
  }
 
  public function getAvatar() {
    return $this->avatar;
  }

  /**
   * Is Admin 
   */
  public function setIsAdmin($new_admin) { 
    $this->isAdmin = $new_admin;  
  }
 
  public function getIsAdmin() {
    return $this->isAdmin;
  }

  /**
   * Created At
   */
  public function setCreatedAt($new_created_at) { 
    $this->createdAt = $new_created_at;  
  }
 
  public function getCreatedAt() {
    return $this->createdAt;
  }

  public static function getSessionUserId() {
    return $_SESSION["user_id"];
  }

  public function canEditUser() {

    // Check if same user is logged in
    if (self::getSessionUserId() === $this->id) {
      return true;
    }

    // Check if logged in user is admin
    if (UserRepository::getIsAdmin(self::getSessionUserId())) {
      return true;
    }
    
  }

  public function getUserAvatar() {

    if ($this->avatar) {
      $filePath = '/images/user/' . $this->id . '/avatar/';
      return $filePath . $this->avatar;
    }

  }

}
