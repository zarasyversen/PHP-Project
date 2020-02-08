
<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
$title = $message = '';
$title_err = $message_err = $error = '';
$titleOk = $messageOk = false;

// Process data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = trim($_POST["title"]);
  $message = trim($_POST["message"]);

  if (empty($title)) {
    $title_err = "Please enter a title";
  } else {
    $titleOk = true;
  }

  if (empty($message)) {
    $message_err = "Please enter a message";
  } else {
    $messageOk = true;
  }

  if ($titleOk && $messageOk) {

    $post = new Post(); 
    $post->setTitle($title);
    $post->setMessage($message);
    $post->setUserId((int)$_SESSION["user_id"]);

    try {
      PostRepository::save($post);
      Helper\Session::setSuccessMessage('Successfully posted your message');
    } catch (\PDOException $e){
      Helper\Session::setErrorMessage('Something went wrong, please try again later.');
    } finally {
      header("location: /page/welcome.php");
      exit;
    }

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
              placeholder="Title"
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
