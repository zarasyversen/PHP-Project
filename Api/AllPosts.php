<?php 
namespace Api;

use Repository\PostRepository;

/**
 * All Posts
 */
class AllPosts extends \Controller\Base {

  public function view()
  {
    $postList = PostRepository::getAllPosts();
    
    $this->setData([
      'postList' => $postList
    ]);
  }
}
