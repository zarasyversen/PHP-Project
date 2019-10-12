<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$pageTitle = 'Welcome';
include(BASE . '/page/header.php');?>
<div class="wrapper">
  <div class="page-header">
    <h1>Hi, <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span>. Welcome to our site.</h1>
  </div>
  <?php include(BASE . '/session/message.php'); ?>
  <?php include(BASE . '/user/post/new-post.php'); ?>
  <?php include(BASE . '/list/posts.php'); ?>
</div>  

<?php include(BASE . '/page/footer.php');?>