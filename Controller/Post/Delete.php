<?php 
namespace Controller\Post;

use Repository\PostRepository;

class Delete extends \Controller\Base {

  public function view($id)
  {
    $post = PostRepository::getPost($id);
    $post->isEditable();
  
    if (PostRepository::delete($id)) {
      $this->setData(['session_success' =>'Successfully deleted your message.']);
    } else {
      $this->setData(['session_error' =>'Sorry. Something went wrong, please try again.']);
    }

    $this->redirect("/welcome");
  }
}
