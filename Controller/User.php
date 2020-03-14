<?php 
namespace Controller;

/**
 * User Controller
 */
class User {

  public static function showProfile() {
    return '/user/profile.php';
  }

  public static function showCreateAvatar() {
    return '/user/profile/avatar-upload.php';
  }

  public static function showUpdateAvatar() {
    return '/user/profile/avatar-update.php';
  }

  public static function showDeleteAvatar() {
    return '/user/profile/avatar-delete.php';
  }

}
