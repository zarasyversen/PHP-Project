<?php 
namespace Controller;

use Helper\Session as Session;
use Repository\PostRepository;

class Welcome extends \Controller\Base {

  public function view()
  {
    $activeUser = Session::getActiveUser();

    $posts = new PostRepository();
    $postList = $posts->getAllPosts();

    $pageTitle = 'Welcome';
    $this->displayTemplate(
      '/page/welcome',
      [
        'pageTitle' => $pageTitle,
        'activeUser' => $activeUser,
        'postList' => $postList
      ]
    );
  }
}
