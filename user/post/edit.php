<?php
$title = $message = '';
$title_err = $message_err = $error = '';
$titleOk = $messageOk = $confirmDeletePost = false;

$postId = (int)$_GET['id'];

try {
  $post = PostRepository::getPost($postId);
  $post->isEditable();
} catch (\Exceptions\NotFound $e) {
  Helper\Session::setErrorMessage('Sorry, that post does not exist.');
  header("location: /welcome");
} catch (\Exceptions\NoPermission $e) {
  Helper\Session::setErrorMessage('Sorry, you are not allowed to edit that post.');
  header("location: /welcome");
  exit;
}

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

    if (PostRepository::edit($postId, $title, $message)) {
      Helper\Session::setSuccessMessage('Successfully edited your message.');
      header("location: /welcome");
    } else {
      Helper\Session::setErrorMessage('Something went wrong, please try again later.');
    }
  }

}

$pageTitle = 'Edit Post';
include(BASE .'/page/header.php');?>
<div class="wrapper">
  <h1>Edit your post</h1>
    <form action="/post/<?php echo $post->getPostId(); ?>/edit"
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
      <a href="/welcome">Cancel</a>
    </div>
</div>
<script>
  var deleteAction = document.querySelector('.js-delete-post');

  function deletePost() {
    var confirmed = confirm('Are you sure you want to delete your post?');

    if (confirmed) {
      window.location.href = "/post/<?php echo $post->getPostId(); ?>/delete";
    } 
  }

  deleteAction.addEventListener('click', deletePost);
</script>
