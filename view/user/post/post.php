<?php 
$pageTitle = 'Create a Post';
include(BASE . '/view/page/header.php');?>
<div class="wrapper">
  <div class="page-header">
    <h1>Hi, <?php echo $user->getName() ?>. Welcome to our site.</h1>
  </div>
  <?php include(BASE . '/view/session/message.php'); ?>
  <?php include(BASE . '/view/user/post/form.php'); ?>
  <?php include(BASE . '/view/list/posts.php'); ?>
</div>  

<?php include(BASE . '/view/page/footer.php');?>