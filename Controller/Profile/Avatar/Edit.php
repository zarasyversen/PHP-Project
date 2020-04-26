<?php 
namespace Controller\Profile\Avatar;

use UserRepository;
use Helper\Session as Session;

class Edit {

  public static function view($id) {

    try {
      $user = UserRepository::getUser($id);
      $user->canEditUser();
    } catch (\Exceptions\NotFound $e) {
      Session::setErrorMessage('Sorry, that user does not exist.');
      header("location: /welcome");
      exit;
    } catch (\Exceptions\NoPermission $e) {
      Session::setErrorMessage('Sorry, you are not allowed to edit this profile.');
      header("location: /welcome");
      exit;
    }

    include(BASE . '/user/profile/avatar-update.php');
  }

}
