<?php 
// Initialize session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php 
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
</div>

<?php include('footer.php');?>