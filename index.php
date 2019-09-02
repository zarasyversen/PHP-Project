
<?php
$public_access = true;
require_once("config.php");

$pageTitle = 'Welcome, please log in';
include('header.php');?>
  <div class="wrapper">
    <h1>Welcome to our site.</h1>
    <?php include('login.php');?>
  </div>
  <?php include('footer.php');?>
  </body>
</html>
