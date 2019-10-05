
<?php
$public_access = true;
require_once("config.php");

$pageTitle = 'Welcome, please log in';
include(BASE . '/page/header.php');?>
  <div class="wrapper">
    <h1>Welcome to our site.</h1>
    <?php include(BASE .'/session/login.php');?>
  </div>
  <?php include(BASE .'/page/footer.php');?>
  </body>
</html>
