
<?php 
$title = $content = '';
$title_err = $content_err = '';

// Validate title - not empty
// Validate content - not empty 
// Prepare statement to insert post in db 
// Add username as well 



?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
      method="post" 
      class="form">
      <h2>Post a message</h2>
      <div class="form__group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
            <label for="post_title">Title</label>
            <input type="text" name="post_title" id="post_title" class="form__input" value="<?php echo $title; ?>">
            <p class="form__error">
              <?php echo $title_err; ?>
            </p>
        </div>    
        <div class="form__group <?php echo (!empty($content_err)) ? 'has-error' : ''; ?>">
            <label for="post_content">Content</label>
            <textarea id="post_content" name="post_content" rows="5" cols="33">Please enter your message here...</textarea>
            <p class="form__error">
              <?php echo $content_err;?>
            </p>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn--primary">Submit message</button>
        </div>
        
</form>
