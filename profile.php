<?php 
require_once("config.php");

// Check if User exits
if(!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  // Set a session message and redirect to welcome
  setErrorMessage('Sorry, that user does not exist.');
  header("location: welcome.php");
}

$userId = intval($_GET['id']);
$user = getUser($connection, $userId);
$username = $user['username'];
$createdBy = $user['created'];
$isAdmin = $user['is_admin'];

$pageTitle = $username;
include('header.php');?>
<div class="wrapper page-2column">
  <header class="page-header">
    <h1><?php echo $username;?></h1>
  </header>
  <aside class="page-sidebar">
  <p>Profile created: <?php echo $createdBy;?></p>
  <?php if($isAdmin) :?>
    <p>This user is an admin.</p>
  <?php endif;?>
  </aside>
  <main class="page-main">
    <a href="welcome.php">Return to all posts</a>
  </main>
</div>
<?php include('footer.php');?>