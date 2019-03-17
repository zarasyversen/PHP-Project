
<?php 
require_once "config.php";
$title = $content = '';
$title_err = $message_err = $success = '';
$postOk = false;

// Process data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = trim($_POST["title"]);
  $message = trim($_POST["message"]);
  $success = '';

  if(empty($title)){
    $title_err = "Please enter a title";
  } elseif(empty($message)){
    $message_err = "Please enter a message";
  } else {
    $postOk = true;
  }

  if($postOk){
    // Prepare an INSERT statement 
    $sql = "INSERT INTO posts (username, title, message) VALUES (?, ?, ?)";

    if($statement = mysqli_prepare($connection, $sql)){

      // Bind variables to prepared statement 
      mysqli_stmt_bind_param($statement, "sss", $param_username, $param_title, $param_message);

      // Set params 
      $param_username = $_SESSION["username"]; // Can this fail? 
      $param_title = $title;
      $param_message = $message;

      // Attempt to execute statement 
      if(mysqli_stmt_execute($statement)){
        $success = 'Message successfully posted.';
      } else {
        $success = 'Something went wrong, please try again later.';
      }
    }

    // Close statement
    mysqli_stmt_close($statement);
  } 

  // Close connection
  mysqli_close($connection);
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
      method="post" 
      class="form">
      <h2>Post a message</h2>
      <div class="form__group<?php echo (!empty($title_err)) ? ' has-error' : ''; ?>">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form__input">
            <p class="form__error">
              <?php echo $title_err; ?>
            </p>
        </div>    
        <div class="form__group<?php echo (!empty($message_err)) ? ' has-error' : ''; ?>">
            <label for="message">Message</label>
            <textarea id="message" name="message" class="form__input" placeholder="Please enter your message here..." rows="5" cols="33"></textarea>
            <p class="form__error">
              <?php echo $message_err;?>
            </p>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn--primary">Submit message</button>
        </div>
</form>
<?php if($success) :?>
  <h3><?php echo $success; ?></h3>
<?php endif;?>
