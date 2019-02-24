<?php 
// Registration Form
require_once "config.php";

//Define Variables
$username = $password  = $confirm_password = '';
$username_err = $password_err = $confirm_password_err = '';

//Process Data when form is posted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  //Validate username
  if(empty(trim($_POST["username"]))){

    $usernam_err = "Please enter a username";

  } else {

    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE username = ?";

    // If we are connected and can select?
    if($statement = mysqli_prepare($connection, $sql)){

      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($statement, "s", $param_username);

      // Set parameters
      $param_username = trim($_POST["username"]);

      // Try to execute the prepared statement
      if(mysqli_stmt_execute($statement)){
        // Save in DB (Store the data)
        mysqli_stmt_store_result($statement);

        // What does this check
        if(mysqli_stmt_num_rows($statement) == 1){
          $username_err = "This username is already taken, try again.";
        } else {
          //Can I set this variable earlier? Instead of trim 3 times 
          $username = trim($_POST["username"]);
        }
      } else {
        echo "Oops something went wrong. Please try again.";
      }
    }

    // Close Statement
    mysqli_stmt_close($statement);
  }


  // Validate Password
  if(empty(trim($_POST["password"]))){
    $password_err = "Please enter a password";
  } elseif(strlen(trim($_POST["password"])) < 6){
    $password_err = "Password must be longer than 6 characters";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate Confirm Password 
  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "Please confirm your password";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);

    // If password is empty / if password_err is empty??
    if(empty($password) && ($password != $confirm_password)){
      $confirm_password_err = "Passwords did not match.";
    }
  }

  // Check input errors before inserting data - but are they every emptied though
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

    // Prepare an INSERT statement 
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    if($statement = mysqli_prepare($connection, $sql)){

      // Bind variables to prepared statement 
      mysqli_stmt_bind_param($statement, "ss", $param_username, $param_password);

      // Set params 
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // COOOOL


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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="assets/main.css">
  </head>
  <body>
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
          </span>
        </div>
        <div class="form__group<?php echo (!empty($password_err)) ? ' has-error' : ''; ?>">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form__input" value="<?php echo $password;?>">
          <p class="form__error">
            <?php echo $password_err;?>
          </span>
        </div>
        <div class="form__group<?php echo (!empty($confirm_password_err)) ? ' has-error' : ''; ?>">
          <label for="confirm_password">Confirm   Password</label>
          <input type="text" name="confirm_password" id="confirm_password" class="form__input" value="<?php echo $confirm_password;?>">
          <p class="form__error">
            <?php echo $confirm_password_err;?>
          </span>
        </div>
        <div class="form__group">
          <button type="submit" class="btn btn--primary">Submit</button>
          <input type="reset" class="btn" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
      </form>
    </div>
  </body>
</html>