<?php 
namespace Controller\Profile\Avatar;

use UserRepository;
use Helper\Session as Session;

/**
 * Profile Controller
 */
class Edit extends \Controller\Base {

  public function view($id) {
  
    $user = UserRepository::getUser($id);
    $user->canEditUser();

    $this->displayTemplate('/user/profile/avatar-update', ['user' => $user]);
  }

}
