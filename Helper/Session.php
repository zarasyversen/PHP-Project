<?php 

namespace Helper;

use Repository\UserRepository;

class Session {

  protected static $currentUserId;

  //
  // Set All Messages
  //
  private static function setMessage($type, $message)
  {
    $sessionMessage = [
      'type' => $type, 
      'msg' => $message
    ];
    $_SESSION["session_message"][] = $sessionMessage;
  }

  //
  // Set Success Message
  //
  public static function setSuccessMessage($message)
  {
    $type = 'success';
    self::setMessage($type, $message);
  }

  //
  // Set Error Message
  //
  public static function setErrorMessage($message)
  {
    $type = 'error';
    self::setMessage($type, $message);
  }

  //
  // Show Message if it is Set
  //
  public static function showMessage()
  {
    if (isset($_SESSION["session_message"])) {
      // store it in var before you delete it
      $sessionMessage = $_SESSION['session_message'];

      // remove it
      unset($_SESSION['session_message']);

      // return message
      return $sessionMessage;
    }
  }

  public static function setCurrentUser($userId = false) 
  {
    self::$currentUserId = $userId;
  }

  //
  // Get Session User Id
  //
  public static function getSessionUserId()
  {
    if (self::$currentUserId) {
      return self::$currentUserId;
    } elseif (isset($_COOKIE["CurrentUser"])) {
      return $_COOKIE["CurrentUser"];
    }
  }

  //
  // Create Active User Object
  //
  public static function getActiveUser()
  {
    try {
      return UserRepository::getUserById(self::getSessionUserId());
    } catch (\Exceptions\NotFound $e) {
      self::setErrorMessage('Sorry, that user does not exist.');
    }
  }

  //
  // Check User is Logged In
  //
  public static function isLoggedIn()
  {
    if (self::$currentUserId || isset($_COOKIE["CurrentUser"])) {
      return true;
    }
  }
}
