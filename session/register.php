<?php 
include(BASE . '/page/header.php');?>
<div class="wrapper">
  <?php include(BASE . '/session/message.php'); ?>
  <form action="/register" 
    method="post" class="form">
    <h1>Sign up</h1>
    <p>Please fill in this form to create an account.</p>
    <div class="form__group<?php echo (!empty($username_err)) ? ' has-error' : ''; ?>">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" class="form__input" value="<?php echo $username;?>">
      <p class="form__error">
        <?php echo $username_err;?>
      </p>
    </div>
    <div class="form__group<?php echo (!empty($password_err)) ? ' has-error' : ''; ?>">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" class="form__input" value="<?php echo $password;?>">
      <p class="form__error">
        <?php echo $password_err;?>
      </p>
    </div>
    <div class="form__group<?php echo (!empty($confirm_password_err)) ? ' has-error' : ''; ?>">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm_password" class="form__input" value="<?php echo $confirm_password;?>">
      <p class="form__error">
        <?php echo $confirm_password_err;?>
      </p>
    </div>
    <div class="form__group actions">
      <button type="submit" class="btn btn--primary">Submit</button>
      <input type="reset" class="btn" value="Reset">
    </div>
    <p>Already have an account? <a href="/login">Login here</a>.</p>
  </form>
</div>
<?php include(BASE . '/page/footer.php');?>