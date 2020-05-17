<?php

namespace Middleware;

use Middleware\AuthInterface;
use Helper\Session;

class WebAuth implements AuthInterface {

  public function execute() {
    Session::checkIfLoggedIn();
  }

}
