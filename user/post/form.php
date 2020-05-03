<form action="/post/create" 
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