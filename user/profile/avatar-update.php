<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

//
// Get user id from session not params
// if its admin, show another link and pass id in param
// if params dont exist, use session
//
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
}

$hasAvatar = $user->getUserAvatar();
$pageTitle = 'Update Avatar';
include(BASE . '/page/header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1>Update Avatar</h1>
  </header>
  <?php include(BASE . '/session/message.php'); ?>
  <aside class="page-sidebar">
    <h2>Current Avatar</h2>
    <img src="<?php echo $hasAvatar;?>"/>
  </aside>
  <main class="page-main">
    <h2>Update your Avatar</h2>
    <form class="form" action="/user/profile/avatar-upload.php?id=<?php echo $userId;?>" method="post" enctype="multipart/form-data">
      <div class="form__group">
        <label for="avatar">Upload New Avatar:</label>
        <input type="file" class="form__input file" name="file" id="avatar">
      </div>
      <button type="submit" class="btn btn--primary" name="submit">Upload</button>
    </form>
    <button type="button" class="btn btn--primary delete js-delete-avatar">Delete Avatar</button>
    <a href="/profile.php?id=<?php echo $userId;?>">Cancel</a>
  </main>
</div>
<script>
  var deleteAction = document.querySelector('.js-delete-avatar');

  function deleteAvatar() {
    var confirmed = confirm('Are you sure you want to delete your avatar?');

    if(confirmed){
      window.location.href = "avatar-delete.php?id=<?php echo $userId; ?>";
    } 
  }

  deleteAction.addEventListener('click', deleteAvatar);
</script>
