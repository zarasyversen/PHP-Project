<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

$title = $message = '';
$title_err = $message_err = $error = '';
$titleOk = $messageOk = $confirmDeletePost = false;

// Check if user can edit
if(!isset($_GET['id']) || !canEditPost($connection, $_GET['id'])) {
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
  header("location: /welcome.php");
}

$postId = $_GET['id'];
$post = PostRepository::getPost($postId);

//
// Save New Edited Post 
// 
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

    $title = mysqli_real_escape_string($connection, $title);
    $message = mysqli_real_escape_string($connection, $message);

    if (PostRepository::edit($postId, $title, $message)) {
      Helper\Session::setSuccessMessage('Successfully edited your message.');
      header("location: /page/welcome.php");
    } else {
      Helper\Session::setErrorMessage('Something went wrong, please try again later.');
    }
  }

}

$pageTitle = 'Edit Post';
include(BASE .'/page/header.php');?>
<div class="wrapper">
  <h1>Edit your post</h1>
    <form action="edit.php?id=<?php echo $post->getPostId(); ?>"
      method="post" 
      class="form">
      <div class="form__group<?php echo (!empty($message_err)) ? ' has-error' : ''; ?>">
            <label for="title">Title</label>
            <input 
              type="text" 
              name="title" 
              id="title" 
              class="form__input"
              value="<?php echo $post->getTitle() ?>"
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
              cols="33"><?php echo $post->getMessage() ?></textarea>
            <p class="form__error">
              <?php echo $message_err;?>
            </p>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn--primary">Save new message</button>
        </div>
    </form>

    <div class="post__actions">
      <button type="button" class="btn btn--primary delete js-delete-post">Delete Post</button>
      <a href="/page/welcome.php">Cancel</a>
    </div>
</div>
<script>
  var deleteAction = document.querySelector('.js-delete-post');

  function deletePost() {
    var confirmed = confirm('Are you sure you want to delete your post?');

    if(confirmed){
      window.location.href = "delete.php?id=<?php echo $postId; ?>";
    } 
  }

  deleteAction.addEventListener('click', deletePost);
</script>
