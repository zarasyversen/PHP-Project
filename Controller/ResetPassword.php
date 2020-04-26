<?php 
namespace Controller;

class ResetPassword {

  public static function view() {
    include(BASE . '/session/reset-password.php');
  }

}
