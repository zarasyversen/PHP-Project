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

    //
    // Unable to do this, it does not have the same variable scope.
    // $this->includeFile('/user/profile.php', ['user' => $user, 'canEdit' => $canEdit]);
    include(BASE . '/user/profile.php');
  }

}
