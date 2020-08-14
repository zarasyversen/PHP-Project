<?php 
namespace Controller\Profile\Avatar;

use Repository\UserRepository;

class Delete extends \Controller\Base {

  public function view($name)
  {
    $user = UserRepository::getUserByName($name);
    $user->canEditUser();
   
    if (UserRepository::deleteAvatar($user->getId())) {
      $this->setData(['session_success' =>'Successfully deleted your avatar.']);
    } else {
      $this->setData(['session_error' =>'Sorry. Something went wrong, please try again']);
    }

    $url = '/profile/' .$name;
    return $this->redirect($url);
  }
}
