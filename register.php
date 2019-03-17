<?php 
// Registration Form
require_once "config.php";

//Define Variables
$username = $password  = $confirm_password = '';
$username_err = $password_err = $confirm_password_err = '';
$userOk = $passwordOk = false;


function doesUsernameExist($connection, $username){

  // Prepare a select statement
  $sql = "SELECT id FROM users WHERE username = ?";

  if($statement = mysqli_prepare($connection, $sql)){

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($statement, "s", $param_username);

    // Set parameters
    $param_username = $username;

    // Try to execute the prepared statement
    if(mysqli_stmt_execute($statement)){

      // Save in DB (Store the data)
      mysqli_stmt_store_result($statement);

      // Check if the username exists in the DB 
      if(mysqli_stmt_num_rows($statement) >= 1){
        return true;
      } 
    } else {
     return false;
    }
  }

  mysqli_stmt_close($stmt);
}


//Process Data when form is posted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);
  $confirm_password = trim($_POST["confirm_password"]);

  // Validate Username
  if(empty($username)){
    $username_err = "Please enter a username";
  } elseif(doesUsernameExist($connection, $username)) {
    $username_err = "This username is already taken, try again.";
  } else {
    $userOk = true; 
  }

  // Validate Passwords
  if(empty($password)){
    $password_err = "Please enter a password";
  } elseif(empty($confirm_password)){
     $confirm_password_err = "Please confirm your password";
  } elseif(strlen($password) < 6){
    $password_err = "Password must be longer than 6 characters";
  } elseif($password != $confirm_password) {
    $confirm_password_err = "Passwords did not match.";
  } else {
    $passwordOk = true;
  }

  // If Username & Password are true, create user
  if($userOk && $passwordOk) {
    // Prepare an INSERT statement 
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    if($statement = mysqli_prepare($connection, $sql)){

      // Bind variables to prepared statement 
      mysqli_stmt_bind_param($statement, "ss", $param_username, $param_password);

      // Set params 
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT); 

      // Attempt to execute statement 
      if(mysqli_stmt_execute($statement)){
        // Redirect to login
        header("location: login.php");
      } else {
        echo "Something went wrong!";
      }
    }

    // Close statement
    mysqli_stmt_close($statement);
  } 

  // Close connection
  mysqli_close($connection);
}
$pageTitle = 'Sign Up';
include('header.php');?>
<div class="wrapper">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
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
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
  </form>
</div>
<?php include('footer.php');?>