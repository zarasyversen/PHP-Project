<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$activeUser = Helper\Session::getActiveUser();

$pageTitle = 'Welcome';
include(BASE . '/page/header.php');?>
<div class="wrapper">
  <div class="page-header">
    <h1>Hi, <?php echo $activeUser->getName() ?>. Welcome to our site.</h1>
  </div>
  <?php include(BASE . '/session/message.php'); ?>
  <?php include(BASE . '/user/post/new-post.php'); ?>
  <?php include(BASE . '/list/posts.php'); ?>
</div>  

<?php include(BASE . '/page/footer.php');?>