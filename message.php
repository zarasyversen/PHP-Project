<?php 
// I dont need config, should I only add functions? 
require_once("functions.php");
$sessionMessage = showMessage();
?>
<?php if($sessionMessage) :
  $messageType = $sessionMessage[0];
  $message = $sessionMessage[1];
  ?>
  <div class="session-message <?php echo $messageType;?>">
    <?php if($messageType === 'success'):?>
      <svg class="icon icon-checkbox session-message__icon" width="30px" height="30px" viewBox="0 0 159 159" xmlns="http://www.w3.org/2000/svg"><g transform="translate(1 1)" stroke="black" stroke-width="15" fill="none" fill-rule="evenodd"><path d="M39 91l23 24 56-73"/></g></svg>
    <?php elseif($messageType === 'error') :?>
      <svg class="icon icon-cross session-message__icon" width="30px" height="30px" viewBox="0 0 68 83" xmlns="http://www.w3.org/2000/svg"><title>Group</title><g stroke="#000" stroke-width="15" fill="none" fill-rule="evenodd"><path d="M6 78L62 5M62 78L6 5"/></g></svg>
    <?php endif; ?>

    <p>
    <?php echo $message; ?>
    </p>
  </div>
<?php endif; ?>