<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$postId = (int)$_GET['id'];

try {
 $post = PostRepository::getPost($postId);
 $post->isEditable();

  if (PostRepository::delete($_GET["id"])) {
    Helper\Session::setSuccessMessage('Successfully deleted your message.');
  } else {
    Helper\Session::setErrorMessage('Sorry. Something went wrong, please try again.');
  }
} catch (\Exceptions\NotFound $e) {
  Helper\Session::setErrorMessage('Sorry, that post does not exist.');
} catch (\Exceptions\NoPermission $e) {
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
} finally {
  header("location: /page/welcome.php");
}
