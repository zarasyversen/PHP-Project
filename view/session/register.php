<?php 
include(BASE . '/view/page/header.php');
?>
<div class="wrapper">
  <?php include(BASE . '/view/session/message.php'); ?>
  <form action="/register" 
    method="post" class="form">
    <h1>Sign up</h1>
    <p>Please fill in this form to create an account.</p>
    <div class="form__group<?php echo $missingUsername ? ' has-error' : ''; ?>">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" class="form__input" value="<?php echo $username;?>">
      <p class="form__error">
        <?php echo $missingUsername;?>
      </p>
    </div>
    <div class="form__group<?php echo $missingPassword ? ' has-error' : ''; ?>">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" class="form__input" value="">
      <p class="form__error">
        <?php echo $missingPassword;?>
      </p>
    </div>
    <div class="form__group<?php echo $confirmPassword ? ' has-error' : ''; ?>">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm_password" class="form__input" value="">
      <p class="form__error">
        <?php echo $confirmPassword ;?>
      </p>
    </div>
    <div class="form__group actions">
      <button type="submit" class="btn btn--primary">Submit</button>
      <input type="reset" class="btn" value="Reset">
    </div>
    <p>Already have an account? <a href="/login">Login here</a>.</p>
  </form>
</div>
<?php include(BASE . '/view/page/footer.php');?>