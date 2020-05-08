<?php
include(BASE . '/page/header.php');?>
<div class="wrapper">
    <h2>Reset Password</h2>
    <p>Please fill out this form to reset your password.</p>
    <form action="/reset/password" class="form" method="post"> 
        <div class="form__group<?php echo (!empty($new_password_err)) ? ' has-error' : ''; ?>">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form__input" value="">
            <p class="form__error"><?php echo $new_password_err; ?></p>
        </div>
        <div class="form__group<?php echo (!empty($confirm_password_err)) ? ' has-error' : ''; ?>">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form__input">
            <p class="form__error"><?php echo $confirm_password_err; ?></p>
        </div>
        <div class="form__group actions">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/welcome">Cancel</a>
        </div>
    </form>
</div>    
<?php include(BASE . '/page/footer.php');?>