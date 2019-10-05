<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$newPasswordOk = false;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if(empty($new_password)){
        $new_password_err = "Please enter the new password.";
    } elseif(strlen($new_password) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } elseif(empty($confirm_password)) {
        $confirm_password_err = "Please confirm the password.";
    } elseif($new_password != $confirm_password) {
        $confirm_password_err = "Password did not match.";
    } else {
        $newPasswordOk = true;
    }

    if($newPasswordOk === true){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($statement = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($statement, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($statement)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($statement);
    }
    
    // Close connection
    mysqli_close($connection);
}
$pageTitle = 'Reset Password';
include('../page/header.php');?>
<div class="wrapper">
    <h2>Reset Password</h2>
    <p>Please fill out this form to reset your password.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="post"> 
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
            <a href="../page/welcome.php">Cancel</a>
        </div>
    </form>
</div>    
<?php include('../page/footer.php');?>