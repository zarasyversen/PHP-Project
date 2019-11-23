<?php 

namespace Helper;

class Session {

  //
  // Set All Messages
  //
  private static function setMessage($type, $message) {
    $sessionMessage = [
      'type' => $type, 
      'msg' => $message
    ];
    $_SESSION["session_message"][] = $sessionMessage;
  }

  //
  // Set Success Message
  //
  public static function setSuccessMessage($message) {
    $type = 'success';
    self::setMessage($type, $message);
  }

  //
  // Set Error Message
  //
  public static function setErrorMessage($message) {
    $type = 'error';
    self::setMessage($type, $message);
  }

  //
  // Show Message if it is Set
  //
  public static function showMessage() {
   if(isset($_SESSION["session_message"])) {
    
    // store it in var before you delete it
    $sessionMessage = $_SESSION['session_message'];

    // remove it
    unset($_SESSION['session_message']);

    // return message 
    return $sessionMessage;
   }
 }

}