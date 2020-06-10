<?php 
namespace Controller\Profile\Avatar;

use Repository\UserRepository;
use Helper\Session as Session;

class Delete {

  public function view($name)
  {
    $user = UserRepository::getUserById($name);
    $user->canEditUser();
   
    if (UserRepository::deleteAvatar($user->getId())) {
      Session::setSuccessMessage('Successfully deleted your avatar.');
    } else {
      Session::setErrorMessage('Sorry. Something went wrong, please try again.');
    }

    $url = '/profile/' .$name;
    header('Location:' . $url);
  }
}
