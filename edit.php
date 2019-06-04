<?php
require_once("config.php");
require_once("functions.php");
$title = $message = '';
$title_err = $message_err = $error = '';
$titleOk = $messageOk = $confirmDeletePost = false;

if (isset($_GET["id"])) {
  $postId = htmlspecialchars($_GET["id"]);
  $post = getPost($connection, $postId);

  //
  // Check if user can edit the post
  //
  if(!canEditPost($post['username'])){
    header("location: welcome.php?noedit");
  }

} else {
  header("location: welcome.php?nopost");
}


//
// Save New Edited Post 
// 
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

    /// Stop sql injection 
    $title = mysqli_real_escape_string($connection, $title);
    $message = mysqli_real_escape_string($connection, $message);

    $sql = "UPDATE posts 
            SET title = '$title', 
                message = '$message',
                updated_at = now()
            WHERE id =" . $postId;

    if (mysqli_query($connection, $sql)) {
       // Set a param with success on the url and redirect to welcome
        header("location: welcome.php?success");
    } else {
      $error = 'Something went wrong, please try again later.';
    }
  }

  mysqli_close($connection);
}

$pageTitle = 'Edit Post';
include('header.php');?>
<div class="wrapper">
  <h1>Edit your post</h1>
  <?php if($post) :?>
    <form action="edit.php?id=<?php echo $postId; ?>"
      method="post" 
      class="form">
      <div class="form__group<?php echo (!empty($message_err)) ? ' has-error' : ''; ?>">
            <label for="title">Title</label>
            <input 
              type="text" 
              name="title" 
              id="title" 
              class="form__input"
              value="<?php echo $post['title']; ?>"
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
              cols="33"><?php echo $post['message'] ?></textarea>
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
        <a href="/welcome.php">Cancel</a>
      </div>
  <?php endif;?>
  <?php if($error) :?>
    <h3><?php echo $error;?> </h3>
  <?php endif;?>
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
