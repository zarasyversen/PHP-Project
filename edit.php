<?php
require_once("config.php");
$title = $message = '';
$title_err = $message_err = $error = '';
$titleOk = $messageOk = $confirmDeletePost = false;

if (isset($_GET["id"])) {
  $postId = htmlspecialchars($_GET["id"]);

  // Tried to put all functions in here but no

} else {
  // header("location: 404.php");
  $postId = 20;
}

function getPost($connection, $postId){
  if($postId){
    // Get Post from DB 
    $sql = "SELECT * FROM posts WHERE id =" . $postId;

    if($result = mysqli_query($connection, $sql)) {

      if(mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_array($result)) {

          // Create a post array with keys and the post info
          $post = [
            'title' => $row['title'], 
            'message' => $row['message'],
            'created' => $row['created_at']
          ];

          // Add each post to posts 
          return $post;
        }
      } else {
        return false;
      }
    }
  }
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

//
// Delete Post 
//
if($confirmDeletePost) {
  die('lets delete it');
}

$pageTitle = 'Edit Post';
include('header.php');?>
<div class="wrapper">
  <h1>Edit your post</h1>
  <?php if($post = getPost($connection, $postId)) :?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
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
      // <?php $confirmDeletePost /* = true*/; ?>
      // tried php funtion as well
      console.log('delete me');
    } 
  }

  deleteAction.addEventListener('click', deletePost);
</script>
