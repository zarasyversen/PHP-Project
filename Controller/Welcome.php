<?php 
namespace Controller;

use Helper\Session as Session;

class Welcome {

  public static function view() {
    $activeUser = Session::getActiveUser();

    $pageTitle = 'Welcome';
    include(BASE . '/page/welcome.php');
  }

}
