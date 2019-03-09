<?php 

// Initialize session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="assets/main.css">
</head>
<body>
    <div class="page-header">
        <h1>Hi, <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span>. Welcome to our site.</h1>
    </div>
    <p>
      <a href="reset-password.php">Reset Your Password</a>
    </p>
    <p>
      <a href="logout.php">Sign Out of Your Account</a>
    </p>
</body>
</html>