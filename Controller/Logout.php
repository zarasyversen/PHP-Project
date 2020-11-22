<?php 
namespace Controller;
use Helper\Session as Session;

class Logout extends \Controller\Base {

  public function view()
  {

    setcookie("CurrentUser", "", time()-3600);

    // Redirect to login page
    $this->redirect("/login");
  }
}
