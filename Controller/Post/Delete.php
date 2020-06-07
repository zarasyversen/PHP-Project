<?php 
namespace Controller\Post;

use Repository\PostRepository;
use Helper\Session as Session;

class Delete {

  public function view($id)
  {
    $post = PostRepository::getPost($id);
    $post->isEditable();
  
    if (PostRepository::delete($id)) {
      Session::setSuccessMessage('Successfully deleted your message.');
    } else {
      Session::setErrorMessage('Sorry. Something went wrong, please try again.');
    }

    header("location: /welcome");
  }
}
