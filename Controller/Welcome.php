<?php 
namespace Controller;

use Helper\Session as Session;

class Welcome extends \Controller\Base {

  public function view() {
    $activeUser = Session::getActiveUser();

    $pageTitle = 'Welcome';
    $this->displayTemplate(
      '/page/welcome',
      [
        'pageTitle' => $pageTitle,
        'activeUser' => $activeUser
      ]
    );
  }

}
