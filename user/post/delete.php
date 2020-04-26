<?php 
$postId = (int)$_GET['id'];

try {
 $post = PostRepository::getPost($postId);
 $post->isEditable();
} catch (\Exceptions\NotFound $e) {
  Helper\Session::setErrorMessage('Sorry, that post does not exist.');
} catch (\Exceptions\NoPermission $e) {
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
  header("location: /welcome");
  exit;
} finally {
  if (PostRepository::delete($_GET["id"])) {
    Helper\Session::setSuccessMessage('Successfully deleted your message.');
  } else {
    Helper\Session::setErrorMessage('Sorry. Something went wrong, please try again.');
  }
  header("location: /welcome");
} 
