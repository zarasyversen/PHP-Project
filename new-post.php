
<?php 
require_once "config.php";
$title = $message = '';
$title_err = $message_err = $error = '';
$titleOk = $messageOk = false;

// Process data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = trim($_POST["title"]);
  $message = trim($_POST["message"]);

  if(empty($title)){
    $title_err = "Please enter a title";
  } else {
    $titleOk = true;
  }

  if(empty($message)){
    $message_err = "Please enter a message";
  } else {
    $messageOk = true;
  }

  if($titleOk && $messageOk){
    // Prepare an INSERT statement 
    $sql = "INSERT INTO posts (username, title, message) VALUES (?, ?, ?)";

    if($statement = mysqli_prepare($connection, $sql)){

      // Bind variables to prepared statement 
      mysqli_stmt_bind_param($statement, "sss", $param_username, $param_title, $param_message);

      // Set params 
      $param_username = $_SESSION["username"]; 
      $param_title = $title;
      $param_message = $message;

      // Attempt to execute statement 
      if(mysqli_stmt_execute($statement)){
        // Set a session message and redirect to welcome
        $_SESSION["session_message"] = 'Successfully posted your message';
        header("location: welcome.php");

      } else {
        $error = 'Something went wrong, please try again later.';
      }
    }

    // Close statement
    mysqli_stmt_close($statement);
  } 
}
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
      method="post" 
      class="form">
      <h2>Post a message</h2>
      <div class="form__group<?php echo (!empty($title_err)) ? ' has-error' : ''; ?>">
            <label for="title">Title</label>
            <input 
              type="text" 
              name="title" 
              id="title" 
              class="form__input"
              value="<?php echo $title; ?>"
              />
            <p class="form__error">
              <?php echo $title_err; ?>
            </p>
        </div>    
        <div class="form__group<?php echo (!empty($message_err)) ? ' has-error' : ''; ?>">
            <label for="message">Message</label>
            <textarea 
              id="message" 
              name="message" 
              class="form__input"
              placeholder="Please enter your message here..."
              rows="5" 
              cols="33"><?php echo $message ?></textarea>
            <p class="form__error">
              <?php echo $message_err;?>
            </p>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn--primary">Submit message</button>
        </div>
</form>

<?php /* 

Look at flash messages 
 - Set session variable like [message]
 - redirect 
 - check if set 
 - show message 
 - empty var
 - done 

MESSAGES */ ?>
<!-- <?php if(isset($_GET["success"])) :?>
  <h3>Message successfully posted</h3>
<?php elseif(isset($_GET["deleted"])) :?>
  <h3>Message successfully deleted</h3>
<?php elseif(isset($_GET["nopost"])) :?>
   <h3>Sorry, no post found with that id</h3>
 <?php elseif(isset($_GET["noedit"])) :?>
   <h3>Sorry, you are not allowed to edit that post</h3>
   <?php elseif(isset($_GET["error"])) :?>
   <h3>Sorry. something went wrong, please try again.</h3>
<?php endif;?> -->

<?php if($error) :?>
  <h3><?php echo $error;?> </h3>
<?php endif;?>
