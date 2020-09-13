<?php 
$hasAvatar = $user->getUserAvatar();
$pageTitle = $user->getName();
include(BASE . '/view/page/header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1><?php echo $user->getName() ?></h1>
  </header>
  <?php include(BASE . '/view/session/message.php'); ?>
  <aside class="page-sidebar">
  <p>Profile created: <?php echo $user->getFormattedDate()?></p>
  <?php if ($user->getIsAdmin()) :?>
    <p>This user is an admin.</p>
  <?php endif;?>
  <?php if ($hasAvatar) :?>
    <img src="<?php echo $hasAvatar;?>" alt=""/>
    <?php if ($canEdit) :?>
      <a href="/profile/<?php echo strtolower($user->getName());?>/avatar/edit"
        title="Upload Avatar Image">Edit Avatar</a>
    <?php endif;?>
  <?php elseif ($canEdit) :?>
    <form class="form" 
          action="/profile/<?php echo strtolower($user->getName());?>/avatar/create"
          method="post" 
          enctype="multipart/form-data">
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
      <?php include(BASE . '/view/list/posts.php'); ?>
    </section>
    <a href="/welcome">Return to all posts</a>
  </main>
</div>
<?php include(BASE . '/view/page/footer.php');?>