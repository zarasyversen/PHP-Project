<?php

// Initialize the session
session_start();

// Session is set and is true ????
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}

require_once("config.php");

// Define and init empty variables 
$username = $password = '';
$username_err = $password_err = '';
$passwordOk = $usernameOk = false;

// Process data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  if(empty($username)) {
    $username_err = "Please enter your username";
  } elseif(empty($password)) {
    $password_err = "Please enter your password";
  } else {
    $passwordOk = true;
    $usernameOk = true;
  }

  if($passwordOk && $usernameOk){

    // Prepare select statement 
    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if($statement = mysqli_prepare($connection, $sql)){

      // Bind variables
      mysqli_stmt_bind_param($statement, "s", $param_username);

      // Set params 
      $param_username = $username;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($statement)){

        // Store result 
        mysqli_stmt_store_result($statement);

        // Check if username exists
        if(mysqli_stmt_num_rows($statement) === 1){
          // Bind result variables
          mysqli_stmt_bind_result($statement, $id, $username, $hashed_password);

          if(mysqli_stmt_fetch($statement)){
            if(password_verify($password, $hashed_password)){
              // Password verified - start a session
              $session_lifetime = 86400; //1 day lifetime
              session_set_cookie_params($session_lifetime);
              session_start();
              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              
              // Redirect user to welcome page
              header("location: welcome.php");
            } else {
              // Password is incorrect
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
          $username_err = "No account found with that username";
        }
      } else {
        echo "Ooops something went wrong. Please try again later";
      }
    }
    // Close statement
    mysqli_stmt_close($statement);
  }

  // Close connection
  mysqli_close($connection);
}
$pageTitle = 'Login';
include('header.php');?>
<div class="wrapper">
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
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>    
<?php include('footer.php');?>
