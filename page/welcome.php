<?php 
include(BASE . '/page/header.php');?>
<div class="wrapper">
  <div class="page-header">
    <h1>Hi, <?php echo $activeUser->getName() ?>. Welcome to our site.</h1>
  </div>
  <?php include(BASE . '/session/message.php'); ?>
  <?php include(BASE . '/user/post/new-post.php'); ?>
  <section class="posts">
    <h2>Posts</h2>
    <?php include(BASE . '/list/posts.php'); ?>
  </section>
</div>  

<?php include(BASE . '/page/footer.php');?>