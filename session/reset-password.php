<?php 
 
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$newPasswordOk = false;
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $new_password = trim($_POST["new_password"]);
  $confirm_password = trim($_POST["confirm_password"]);

  // Validate New Password
  if (empty($new_password)) {
      $new_password_err = "Please enter the new password.";
  } elseif (strlen($new_password) < 6) {
      $new_password_err = "Password must have at least 6 characters.";
  } elseif (empty($confirm_password)) {
      $confirm_password_err = "Please confirm the password.";
  } elseif ($new_password != $confirm_password) {
      $confirm_password_err = "Password did not match.";
  } else {
      $newPasswordOk = true;
  }

  // Reset Password
  if ($newPasswordOk === true) {

    if (UserRepository::resetPassword(password_hash($new_password, PASSWORD_DEFAULT))) {
      session_destroy();
      session_start();
      Helper\Session::setSuccessMessage('Successfully changed your password, please log in again.');
      header("location: /login");
      exit;
    } else {
      Helper\Session::setErrorMessage('Something went wrong, please try again later.');
      header("location: /welcome");
      exit;
    }
  }
}
$pageTitle = 'Reset Password';
include(BASE . '/page/header.php');?>
<div class="wrapper">
    <h2>Reset Password</h2>
    <p>Please fill out this form to reset your password.</p>
    <form action="/reset/password" class="form" method="post"> 
        <div class="form__group<?php echo (!empty($new_password_err)) ? ' has-error' : ''; ?>">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form__input" value="<?php echo $new_password; ?>">
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