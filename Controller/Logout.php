<?php 
namespace Controller;

class Logout extends \Controller\Base {

  public function view()
  {
    // Initialize the session
    session_start();
     
    // Destroy the session.
    session_destroy();
     
    // Redirect to login page
    return $this->redirect("/login");
  }
}
