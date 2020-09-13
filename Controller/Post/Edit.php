<?php 
namespace Controller\Post;

use Repository\PostRepository;

class Edit extends \Controller\Base {

  public function view($id)
  {
    $title_err = $message_err = '';
    $titleOk = $messageOk = false;

    $post = PostRepository::getPost($id);
    $post->isEditable();

    /**
     * Save New Edited Post
     * Service Manager is glue
     */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $title = trim($_POST["title"]);
      $message = trim($_POST["message"]);

      if (empty($title)) {
        $title_err = "Please enter a title";
      } elseif (empty($message)) {
        $message_err = "Please enter a message";
      } else {
        if (PostRepository::edit($id, $title, $message)) {
          $this->setData(['session_success' =>'Successfully edited your message.']);
          return $this->redirect("/welcome");
        } else {
          $this->setData(['session_error' =>'Something went wrong, please try again later.']);
        }
      }
    }

    $pageTitle = 'Edit Post';
    $this->setData([
      'pageTitle' => $pageTitle,
      'post' => $post,
      'title_err' => $title_err,
      'message_err' => $message_err
    ]);
    $this->setTemplate('/user/post/edit');
  }
}
