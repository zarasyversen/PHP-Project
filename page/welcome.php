<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$pageTitle = 'Welcome';
include(BASE . '/page/header.php');?>
<div class="wrapper">
  <div class="page-header">
    <!-- Leave session username here? -->
    <h1>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>. Welcome to our site.</h1>
  </div>
  <?php include(BASE . '/session/message.php'); ?>
  <?php include(BASE . '/user/post/new-post.php'); ?>
  <?php include(BASE . '/list/posts.php'); ?>
</div>  

<?php include(BASE . '/page/footer.php');?>