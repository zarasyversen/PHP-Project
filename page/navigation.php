<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

?>
<nav class="menu">
  <ul class="menu__list">
    <li class="menu__item">
      <a href="/user/profile.php?id=<?php echo getUserId();?>" class="menu__title">My Profile</a>
    </li>
    <li class="menu__item">
      <a href="/page/welcome.php" class="menu__title">All Posts</a>
    </li>
    <li class="menu__item">
      <a href="/session/reset-password.php">Reset Password</a>
    </li> 
    <li class="menu__item">
      <a href="/session/logout.php" class="menu__title">Log Out</a>
    </li>
  </ul>
</nav>