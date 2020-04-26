<?php 
namespace Controller;

use UserRepository;

/**
 * Profile Controller
 */
class Profile {

  public static function view($id) {

    // var_dump("My Id Is " . $id);
    // die('hej');

    try {
      $user = UserRepository::getUser($id);
      $canEdit = $user->canEditUser();
    } catch (\Exceptions\NotFound $e) {
      Helper\Session::setErrorMessage('Sorry, that user does not exist.');
      header("location: /welcome");
      exit;
    } catch (\Exceptions\NoPermission $e) {
      $canEdit = false;
    }

    include(BASE . '/user/profile.php');
  }

}
