<?php 
namespace Controller\Post;

use PostRepository;
use Helper\Session as Session;

class Edit {

  public static function view($id) {

    $title_err = $message_err = $error = '';
    $titleOk = $messageOk = $confirmDeletePost = false;

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
      } else {
        $titleOk = true;
      }

      if (empty($message)) {
        $message_err = "Please enter a message";
      } else {
        $messageOk = true;
      }

      if ($titleOk && $messageOk) {

        if (PostRepository::edit($id, $title, $message)) {
          Session::setSuccessMessage('Successfully edited your message.');
          header("location: /welcome");
        } else {
          Session::setErrorMessage('Something went wrong, please try again later.');
        }

      }

    }

    $pageTitle = 'Edit Post'; 

    include(BASE . '/user/post/edit.php');
  }

}
