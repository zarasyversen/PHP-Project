<?php 
namespace Controller;

use UserRepository;
use Helper\Session as Session;

/**
 * Profile Controller
 */
class Profile extends \Controller\Base {

  public function view($id) {

    try {
      $user = UserRepository::getUser($id);
      $canEdit = $user->canEditUser();
    } catch (\Exceptions\NoPermission $e) {
      $canEdit = false;
    }

    $this->displayTemplate('/user/profile', ['user' => $user, 'canEdit' => $canEdit]);
  }

}
