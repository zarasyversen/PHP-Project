<?php 
namespace Controller\Profile\Avatar;

use UserRepository;
use Helper\Session as Session;

class Delete {

  public static function view($id) {

    try {
      $user = UserRepository::getUser($id);
      $user->canEditUser();
    } finally {
      
      if (UserRepository::deleteAvatar($id)) {
        Session::setSuccessMessage('Successfully deleted your avatar.');
      } else {
        Session::setErrorMessage('Sorry. Something went wrong, please try again.');
      }

      $url = '/profile/' .$id;
      header('Location:' . $url);
    }

  }

}
