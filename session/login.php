<?php
$public_access = true;
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

// Redirect if already logged in
if (Helper\Session::isLoggedIn()) {
  header("location: /page/welcome.php");
  exit;
} 

$username = $password = '';
$username_err = $password_err = '';
$passwordOk = $usernameOk = false;

// Process data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  if (empty($username)) {
    $username_err = "Please enter your username";
  } elseif (empty($password)) {
    $password_err = "Please enter your password";
  } else {
    $passwordOk = true;
    $usernameOk = true;
  }

  if ($passwordOk && $usernameOk) {

    try {
      $user = UserRepository::login($username);
    } catch (\Exceptions\NotFound $e) {
      Helper\Session::setErrorMessage('Sorry, that user does not exist.');
      header("location: /index.php");
      exit;
    }

    if (password_verify($password, $user->getPassword())) {

      // Password verified - start a session
      $session_lifetime = 86400; //1 day lifetime
      session_set_cookie_params($session_lifetime);
      session_start();

      // Store data in session variable
      $_SESSION["user_id"] = $user->getId();
      
      // Redirect user to welcome page
      header("location: /page/welcome.php");
    } else {
      $password_err = "Sorry, that password is incorrect.";
    }
  }
}
$pageTitle = 'Welcome, please log in';
include(BASE . '/page/header.php');?>
  <div class="wrapper">
    <h1>Welcome to our site.</h1>
    <?php include(BASE . '/session/message.php'); ?>
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
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
        <p>Don't have an account? <a href="/session/register.php">Sign up now</a>.</p>
    </form>
  </div>
  <?php include(BASE .'/page/footer.php');?>
