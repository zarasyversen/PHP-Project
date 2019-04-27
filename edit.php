<?php

// Is user logged in - > login.php
// Is it the right user -> 404 
// Get Id from param 
// Load in post with the id, else 404 
// Be able to edit the message
// Save the message 
// or Cancel (return to welcome.php)


require_once("config.php");

function getPost($connection){
  $postId = htmlspecialchars($_GET["id"]);

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
$pageTitle = 'Edit Post';
include('header.php');?>
<div class="wrapper">
  <h1>Edit your post</h1>
  <?php if($post = getPost($connection)) :?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
      method="post" 
      class="form">
      <div class="form__group">
            <label for="title">Title</label>
            <input 
              type="text" 
              name="title" 
              id="title" 
              class="form__input"
              value="<?php echo $post['title']; ?>"
              />
        </div>    
        <div class="form__group">
            <label for="message">Message</label>
            <textarea 
              id="message" 
              name="message" 
              class="form__input"
              placeholder="Please enter your message here..."
              rows="5" 
              cols="33"><?php echo $post['message'] ?></textarea>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn--primary">Save message</button>
        </div>
      </form>
  <?php endif;?>
</div>
