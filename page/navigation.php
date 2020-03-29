<nav class="menu">
  <ul class="menu__list">
    <li class="menu__item menu__item--indicator">
       <span>>></span>
    </li>
    <li class="menu__item">
      <a href="/profile/<?php echo Helper\Session::getSessionUserId() ;?>" class="menu__title">My Profile</a>
    </li>
    <li class="menu__item">
      <a href="/page/welcome.php" class="menu__title">All Posts</a>
    </li>
    <li class="menu__item">
      <a href="/reset/password">Reset Password</a>
    </li> 
    <li class="menu__item">
      <a href="/logout" class="menu__title">Log Out</a>
    </li>
  </ul>
</nav>
