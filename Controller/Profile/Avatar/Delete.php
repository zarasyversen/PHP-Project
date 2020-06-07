<?php 
namespace Controller\Profile\Avatar;

use Repository\UserRepository;
use Helper\Session as Session;

class Delete {

  public function view($id)
  {
    $user = UserRepository::getUserById($id);
    $user->canEditUser();
   
    if (UserRepository::deleteAvatar($id)) {
      Session::setSuccessMessage('Successfully deleted your avatar.');
    } else {
      Session::setErrorMessage('Sorry. Something went wrong, please try again.');
    }

    $url = '/profile/' .$id;
    header('Location:' . $url);
  }
}
