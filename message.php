<?php 
require_once("functions.php");
$errorMessage = showMessage();
?>
<?php if($errorMessage) :?>
  <p class="session-message">
    <svg class="icon icon-checkbox session-message__icon" width="30" height="30" viewBox="0 0 159 159" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" stroke="black" stroke-width="15" fill="none" fill-rule="evenodd"><path d="M39 91l23 24 56-73"/></g></svg>
    Message: <?php echo $errorMessage; ?>
  </p>
<?php endif; ?>
  