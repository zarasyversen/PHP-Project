<?php 
namespace Controller\Post;

use Model\Post;
use Repository\PostRepository;
use Helper\Session as Session;

class Create extends \Controller\Base {

  public function view()
  {
    $user = Session::getActiveUser();
    $title = $message = '';
    $title_err = $message_err = '';
    $titleOk = $messageOk = false;
    $postList = PostRepository::getAllPosts();

    $this->setTemplate('/user/post/new-post');

    // Process data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && count($_POST) > 0) {
      $title = trim($_POST["title"]);
      $message = trim($_POST["message"]);

      if (empty($title)) {
        $title_err = "Please enter a title";
        $this->setTemplate('/user/post/post');
        $this->setData([
          'user' => $user,
          'title' => $title,
          'message' => $message,
          'title_err' => $title_err,
          'message_err' => $message_err,
          'postList' => $postList
        ]);
      } elseif (empty($message)) {
        $message_err = "Please enter a message";
        $this->setTemplate('/user/post/post');
        $this->setData([
          'user' => $user,
          'title' => $title,
          'message' => $message,
          'title_err' => $title_err,
          'message_err' => $message_err,
          'postList' => $postList
        ]);
      } else {
        $post = new Post(); 
        $post->setTitle($title);
        $post->setMessage($message);
        $post->setUserId($user->getId());

        try {
          PostRepository::save($post);
          $this->setData(['session_success' =>'Successfully posted your message']);
        } catch (\Exceptions\NotSaved $e){
          $this->setData(['session_error' =>'Something went wrong, please try again later.']);
        } finally {
          return $this->redirect("/welcome");
        }
      }
    } 
  }
}
