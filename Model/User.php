<?php 

namespace Model;

use Helper\Session;

/**
 * User Class
 * Only Get & Set 
 */
class User {

  private $id;
  private $name;
  private $avatar;
  private $isAdmin;
  private $createdAt;
  private $password;

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

  /**
   * Password
   */
  public function setPassword($new_password) { 
    $this->password = $new_password;  
  }
 
  public function getPassword() {
    return $this->password;
  }

  /**
   * Check if User can edit
   */
  public function canEditUser() {

    $activeUser = Session::getActiveUser();

    // Check if same user is logged in
    if ($activeUser->getId() === $this->id) {
      return true;
    }

    // Check if active user is admin
    if ($activeUser->getIsAdmin()) {
      return true;
    }

    throw new \Exceptions\NoPermission("Sorry, you are not allowed to edit this profile");
    
  }

  /**
   * Get User Avatar
   */
  public function getUserAvatar() {

    if ($this->avatar) {
      $filePath = '/images/user/' . $this->id . '/avatar/';
      return $filePath . $this->avatar;
    }

  }

}
