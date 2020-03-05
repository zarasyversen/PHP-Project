<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$userId = (int)$_GET['id'];

try {
  $user = UserRepository::getUser($userId);
  $user->canEditUser();
} catch (\Exceptions\NotFound $e) {
  Helper\Session::setErrorMessage('Sorry, that user does not exist.');
  header("location: /page/welcome.php");
} catch (\Exceptions\NoPermission $e) {
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit this profile.');
  header("location: /page/welcome.php");
  exit;
} finally {

  if (UserRepository::deleteAvatar($userId)) {
    Helper\Session::setSuccessMessage('Successfully deleted your avatar.');
  } else {
    Helper\Session::setErrorMessage('Sorry. Something went wrong, please try again.');
  }

  header("location: /user/profile.php?id=" . $userId);

}
