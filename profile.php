<?php 
require_once("config.php");

// Check if User exits
if(!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  // Set a session message and redirect to welcome
  setErrorMessage('Sorry, that user does not exist.');
  header("location: welcome.php");
}

$userId = intval($_GET['id']);
$user = getUser($connection, $userId);
$username = $user['username'];
$createdBy = $user['created'];
$isAdmin = $user['is_admin'];
$canEdit = canEditUser($connection, $userId);
$hasAvatar = hasUserAvatar($connection, $userId);


$pageTitle = $username;
include('header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1><?php echo $username;?></h1>
  </header>
  <?php include('message.php'); ?>
  <aside class="page-sidebar">
  <p>Profile created: <?php echo $createdBy;?></p>
  <?php if($isAdmin) :?>
    <p>This user is an admin.</p>
  <?php endif;?>
  <?php if ($canEdit) :?>
    <?php if ($hasAvatar):?>
      <img src="images/user/avatar/<?php echo $hasAvatar;?>"/>
      <a href="avatar-upload.php?id=<?php echo $userId;?>" title="Upload Avatar Image">Edit Avatar</a>
    <?php else :?>
      <form action="upload.php" method="post" enctype="multipart/form-data">
        Upload Avatar:
        <input type="file" name="file">
        <input type="hidden" name="user" value="<?php echo $userId;?>"/>
        <button type="submit" name="submit">Upload</button>
      </form>
    <?php endif;?>
  <?php endif;?>
  </aside>
  <main class="page-main">
    <a href="welcome.php">Return to all posts</a>
  </main>
</div>
<?php include('footer.php');?>