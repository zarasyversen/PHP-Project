<?php 
namespace Controller\Profile\Avatar;

use Repository\UserRepository;
use Helper\Session as Session;

/**
 * Profile Controller
 */
class Edit extends \Controller\Base {

  public function view($id)
  {
    $user = UserRepository::getUserById($id);
    $user->canEditUser();

    $this->displayTemplate('/user/profile/avatar-update', ['user' => $user]);
  }
}
