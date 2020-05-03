<?php 
namespace Controller\Profile\Avatar;

use UserRepository;
use Helper\Session as Session;

class Edit {

  public static function view($id) {
  
    $user = UserRepository::getUser($id);
    $user->canEditUser();

    include(BASE . '/user/profile/avatar-update.php');
  }

}
