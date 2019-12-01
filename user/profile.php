<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

// Check if User exits
if (!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  // Set a session message and redirect to welcome
  Helper\Session::setErrorMessage('Sorry, that user does not exist.');
  header("location: /page/welcome.php");
}

$userId = intval($_GET['id']);
$user = getUser($connection, $userId);
$username = $user['username'];
$createdBy = $user['created'];
$isAdmin = $user['is_admin'];
$canEdit = canEditUser($connection, $userId);
$hasAvatar = hasUserAvatar($connection, $userId);

$pageTitle = $username;
include(BASE . '/page/header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1><?php echo $username;?></h1>
  </header>
  <?php include(BASE . '/session/message.php'); ?>
  <aside class="page-sidebar">
  <p>Profile created: <?php echo $createdBy;?></p>
  <?php if($isAdmin) :?>
    <p>This user is an admin.</p>
  <?php endif;?>
  <?php if ($hasAvatar) :?>
    <img src="<?php echo $hasAvatar;?>"/>
    <?php if ($canEdit) :?>
      <a href="/user/profile/avatar-update.php?id=<?php echo $userId;?>" title="Upload Avatar Image">Edit Avatar</a>
    <?php endif;?>
  <?php elseif($canEdit) :?>
    <form class="form" action="/user/profile/avatar-upload.php?id=<?php echo $userId;?>" method="post" enctype="multipart/form-data">
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
      <h2>Posts by <?php echo $username; ?></h2>
      <?php if($posts = getAllUserPosts($connection, $userId)): ?>
        <ul>
          <?php foreach($posts as $post):?>
            <li>
              <article class="post profile__post">
                <header class="post__header">
                  <h2 class="post__title"><?php echo $post['title']; ?></h2>
                </header>
                <p class="post__message"><?php echo Helper\Markdown::render($post['message']); ?></p>
                <footer class="post__footer">
                  <p class="post__details">
                    <?php if($post['updated']):?>
                        Updated on
                      <?php else: ?>
                        Posted on
                    <?php endif;?>
                    <?php $date = date($post['updated']) ? date($post['updated']) : date($post['created']);?>
                    <time datetime="<?php echo $date; ?>">
                      <?php echo date_format(new DateTime($date), 'g:ia \o\n l jS F Y'); ?>.
                    </time> 
                    <?php if(canEditPost($connection, $post['id'])) :?>
                      <a href="user/post/edit.php?id=<?php echo $post['id']; ?>">Edit</a>
                    <?php endif;?>
                  </p>
                </footer>
              </article>
            </li>
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