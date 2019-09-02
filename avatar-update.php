<?php 
require_once("config.php");

// Check if User exits
if(!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  setErrorMessage('Sorry, that user does not exist.');
  header("location: welcome.php");
} elseif (!canEditUser($connection, intval($_GET['id']))) {
  // Check if User can edit
  setErrorMessage('Sorry, you are not allowed to edit this profile.');
  header("location: profile.php?id=" . intval($_GET['id']));
}

$userId = intval($_GET['id']);
$hasAvatar = hasUserAvatar($connection, $userId);

$pageTitle = 'Update Avatar';
include('header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1>Update Avatar</h1>
  </header>
  <aside class="page-sidebar">
    <h2>Current Avatar</h2>
    <img src="images/user/avatar/<?php echo $hasAvatar;?>"/>
  </aside>
  <main class="page-main">
    <h2>Update your Avatar</h2>
    <form class="form" action="avatar-upload.php" method="post" enctype="multipart/form-data">
      <div class="form__group">
        <label for="avatar">Upload New Avatar:</label>
        <input type="file" class="form__input file" name="file" id="avatar">
        <input type="hidden" name="user" value="<?php echo $userId;?>"/>
      </div>
      <button type="submit" class="btn btn--primary" name="submit">Upload</button>
    </form>
    <a href="profile.php?id=<?php echo $userId;?>">Cancel</a>
  </main>
</div>