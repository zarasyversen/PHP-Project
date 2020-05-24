<?php
namespace Middleware;

use Middleware\MiddleWareInterface;
use Helper\Session;

class WebAuth implements MiddleWareInterface {

  public function execute() {

    // Redirect if not logged in
    if (!Session::isLoggedIn()) {
      Session::setErrorMessage('Please log in for access');
      header("location: /login");
      exit;
    }

  }

}
