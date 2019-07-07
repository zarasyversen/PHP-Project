<?php 
require_once('config.php');

$pageTitle = 'Welcome';
include('header.php');?>
<div class="wrapper">
  <div class="page-header">
    <h1>Hi, <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span>. Welcome to our site.</h1>
  </div>
  <p>
    <a href="reset-password.php">Reset Your Password</a>
  </p>
  <p>
    <a href="logout.php">Sign Out of Your Account</a>
  </p>
  <?php var_dump(getUsername($connection, 22));?>
  <?php include('message.php'); ?>
  <?php include('new-post.php'); ?>
  <?php include('posts.php'); ?>
</div>

<?php include('footer.php');?>