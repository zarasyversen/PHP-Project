<?php 
namespace Controller;

use Repository\UserRepository;
use Repository\PostRepository;
use Helper\Session as Session;

/**
 * Profile Controller
 */
class Profile extends \Controller\Base {

  public function view($id)
  {
    try {
      $user = UserRepository::getUserById($id);
      $postList = PostRepository::getAllUserPosts($user->getId());
      $canEdit = $user->canEditUser();
    } catch (\Exceptions\NoPermission $e) {
      $canEdit = false;
    }

    $this->displayTemplate(
      '/user/profile',
      [
        'user' => $user,
        'canEdit' => $canEdit,
        'postList' => $postList
      ]
    );
  }
}
