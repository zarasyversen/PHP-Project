<?php
include(BASE . '/view/page/header.php');?>
  <div class="wrapper">
    <h1>Welcome to our site.</h1>
    <?php include(BASE . '/view/session/message.php'); ?>
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="/login"
      method="post" class="form">
        <div class="form__group <?php echo $missingUsername ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form__input" value="<?php echo $username; ?>">
            <?php if ($missingUsername) : ?>
                <p class="form__error">Please enter your username</p>
            <?php endif;?> 
        </div>    
        <div class="form__group <?php echo $missingPassword ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form__input">
             <?php if ($missingPassword) : ?>
                <p class="form__error">Please enter your password</p>
            <?php elseif ($wrongPassword) :?>
                <p class="form__error">Sorry, that password is incorrect.</p>
            <?php endif;?>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn--primary">Login</button>
        </div>
        <p>Don't have an account? <a href="/register">Sign up now</a>.</p>
    </form>
  </div>
<?php include(BASE .'/view/page/footer.php');?>
