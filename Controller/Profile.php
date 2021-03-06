<?php 
namespace Controller;

use Repository\UserRepository;
use Repository\PostRepository;
use Helper\Session as Session;

/**
 * Profile Controller
 */
class Profile extends \Controller\Base {

  public function view($name)
  {
    try {
      $user = UserRepository::getUserByName($name);
      $postList = PostRepository::getAllUserPosts($user->getId());
      $canEdit = $user->canEditUser();
    } catch (\Exceptions\NoPermission $e) {
      $canEdit = false;
    }

    $this->setTemplate('/user/profile');
    $this->setData([
        'user' => $user,
        'canEdit' => $canEdit,
        'postList' => $postList
      ]);
  }
}
