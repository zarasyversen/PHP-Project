<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

// Check if User exits
if (!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  // Set a session message and redirect to welcome
  Helper\Session::setErrorMessage('Sorry, that user does not exist.');
  header("location: /page/welcome.php");
}

$userId = intval($_GET['id']);
$user = UserRepository::getUser($userId);
// $username = $user['username'];
// $createdBy = $user['created'];
// $isAdmin = $user['is_admin'];
// $canEdit = User::canEditUser($user->getId());
// $hasAvatar = hasUserAvatar($connection, $userId);
$hasAvatar = $user->getUserAvatar();
$canEdit = $user->canEditUser();

$pageTitle =  $user->getName();
include(BASE . '/page/header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1><?php echo $user->getName() ?></h1>
  </header>
  <?php include(BASE . '/session/message.php'); ?>
  <aside class="page-sidebar">
  <p>Profile created: <?php echo $user->getCreatedAt()?></p>
  <?php if ($user->getIsAdmin()) :?>
    <p>This user is an admin.</p>
  <?php endif;?>
  <?php if ($hasAvatar) :?>
    <img src="<?php echo $hasAvatar;?>"/>
    <?php if ($canEdit) :?>
      <a href="/user/profile/avatar-update.php?id=<?php echo $user->getId();?>" title="Upload Avatar Image">Edit Avatar</a>
    <?php endif;?>
  <?php elseif ($canEdit) :?>
    <form class="form" action="/user/profile/avatar-upload.php?id=<?php $user->getId();?>" method="post" enctype="multipart/form-data">
      <div class="form__group">
        <label for="avatar">Upload Avatar:</label>
        <input type="file" name="file" id="avatar">
      </div>
      <button type="submit" class="btn btn--primary" name="submit">Upload</button>
    </form>
  <?php endif;?>
  </aside>
  <main class="page-main">
    <section class="profile__posts">
      <h2>Posts by <?php echo $user->getName() ?></h2>
      <?php 
      $posts = new PostRepository();
      if ($postList = $posts->getAllUserPosts($user->getId())): ?>
        <ul>
          <?php foreach($postList as $post):?>
            <?php include(BASE .'/list/post.php');?>
          <?php endforeach; ?>
        </ul>
      <?php else : ?>
        <p>Sorry, no posts available yet. </p>
      <?php endif; ?>
    </section>
    <a href="/page/welcome.php">Return to all posts</a>
  </main>
</div>
<?php include(BASE . '/page/footer.php');?>