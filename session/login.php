<?php
include(BASE . '/page/header.php');?>
  <div class="wrapper">
    <h1>Welcome to our site.</h1>
    <?php include(BASE . '/session/message.php'); ?>
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="/login"
      method="post" class="form">
        <div class="form__group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form__input" value="<?php echo $username; ?>">
            <p class="form__error">
              <?php echo $username_err; ?>
            </p>
        </div>    
        <div class="form__group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form__input">
            <p class="form__error">
              <?php echo $password_err;?>
            </p>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn--primary">Login</button>
        </div>
        <p>Don't have an account? <a href="/register">Sign up now</a>.</p>
    </form>
  </div>
<?php include(BASE .'/page/footer.php');?>
