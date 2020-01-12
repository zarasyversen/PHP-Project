<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$postId = (int)$_GET['id'];

try {
 $post = PostRepository::getPost($postId);
} catch (\Exceptions\NotFound $e) {
  Helper\Session::setErrorMessage('Sorry, that post does not exist.');
  header("location: /page/welcome.php");
} 

try {
  $post->isEditable();

  //
  // If this is not in the try I can delete anything
  // 
  if (PostRepository::delete($_GET["id"])) {
    Helper\Session::setSuccessMessage('Successfully deleted your message.');
  } else {
    Helper\Session::setErrorMessage('Sorry. Something went wrong, please try again.');
  }

  header("location: /page/welcome.php");

} catch (\Exceptions\NoPermission $e) {
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
  header("location: /page/welcome.php");
}

