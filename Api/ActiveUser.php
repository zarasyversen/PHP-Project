<?php 
namespace Api;

use Helper\Session as Session;

class ActiveUser extends \Controller\Base {

  public function view()
  {
    $activeUser = Session::getActiveUser();

    $this->setData([
      'activeUser' => $activeUser
    ]);
  }
}
