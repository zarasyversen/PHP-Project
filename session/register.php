<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

// Redirect if already logged in
if (Helper\Session::isLoggedIn()) {
  header("location: /page/welcome.php");
  exit;
} 

//Define Variables
$username = $password  = $confirm_password = '';
$username_err = $password_err = $confirm_password_err = '';
$userOk = $passwordOk = false;

//Process Data when form is posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);
  $confirm_password = trim($_POST["confirm_password"]);

  // Validate Username
  if (empty($username)) {
    $username_err = "Please enter a username";
  } elseif (UserRepository::doesUserExist($username)) {
    $username_err = "This username is already taken, try again.";
  } else {
    $userOk = true; 
  }

  // Validate Passwords
  if (empty($password)) {
    $password_err = "Please enter a password";
  } elseif (empty($confirm_password)) {
     $confirm_password_err = "Please confirm your password";
  } elseif (strlen($password) < 6) {
    $password_err = "Password must be longer than 6 characters";
  } elseif ($password != $confirm_password) {
    $confirm_password_err = "Passwords did not match.";
  } else {
    $passwordOk = true;
  }

  // If Username & Password are true, create user
  if ($userOk && $passwordOk) {
    try {
      UserRepository::createUser($username, $password);
      Helper\Session::setSuccessMessage('Successfully created your account, please log in.');
      header("location: /login");
    } catch (\Exceptions\NotSaved $e){
      Helper\Session::setErrorMessage('Something went wrong, please try again later.');
      header("location: /register");
    } finally {
      exit; 
    }
  }
}
$pageTitle = 'Sign Up';
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