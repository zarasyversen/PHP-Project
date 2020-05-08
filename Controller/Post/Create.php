<?php 
namespace Controller\Post;

use Post;
use PostRepository;
use Helper\Session as Session;

class Create  extends \Controller\Base {

  public function view() {

    $user = Session::getActiveUser();
    $title = $message = '';
    $title_err = $message_err = '';
    $titleOk = $messageOk = false;

    // Process data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $title = trim($_POST["title"]);
      $message = trim($_POST["message"]);

      if (empty($title)) {
        $title_err = "Please enter a title";
        $this->displayTemplate(
          '/user/post/post', 
          [
            'user' => $user,
            'title' => $title,
            'message' => $message,
            'title_err' => $title_err,
            'message_err' => $message_err
          ]
        );
      } else {
        $titleOk = true;
      }

      if (empty($message)) {
        $message_err = "Please enter a message";
        $this->displayTemplate(
          '/user/post/post', 
          [
            'user' => $user,
            'title' => $title,
            'message' => $message,
            'title_err' => $title_err,
            'message_err' => $message_err
          ]
        );
      } else {
        $messageOk = true;
      }

      if ($titleOk && $messageOk) {

        $post = new Post(); 
        $post->setTitle($title);
        $post->setMessage($message);
        $post->setUserId($user->getId());

        try {
          PostRepository::save($post);
          Session::setSuccessMessage('Successfully posted your message');
        } catch (\Exceptions\NotSaved $e){
          Session::setErrorMessage('Something went wrong, please try again later.');
        } finally {
          header("location: /welcome");
          exit;
        }

      }

    }

    $this->displayTemplate('/user/post/new-post');

  }

}
