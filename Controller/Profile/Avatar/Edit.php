<?php 
namespace Controller\Profile\Avatar;

use Repository\UserRepository;

/**
 * Profile Controller
 */
class Edit extends \Controller\Base {

  public function view($name)
  {
    $user = UserRepository::getUserByName($name);
    $user->canEditUser();

    $this->setTemplate('/user/profile/avatar-update');
    $this->setData([
      'user' => $user
    ]);
  }
}
