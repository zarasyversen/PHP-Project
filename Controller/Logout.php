<?php 
namespace Controller;

class Logout {

  public static function view() {
    include(BASE . '/session/logout.php');
  }

}
