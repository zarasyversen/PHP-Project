<?php 
$pageTitle = 'Create a Post';
include(BASE . '/page/header.php');?>
<div class="wrapper">
  <div class="page-header">
    <h1>Hi, <?php echo $user->getName() ?>. Welcome to our site.</h1>
  </div>
  <?php include(BASE . '/session/message.php'); ?>
  <?php include(BASE . '/user/post/form.php'); ?>
  <?php include(BASE . '/list/posts.php'); ?>
</div>  

<?php include(BASE . '/page/footer.php');?>