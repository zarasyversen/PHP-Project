<?php 
namespace Controller;

use Repository\UserRepository;
use Helper\Session as Session;

class ResetPassword extends \Controller\Base {

  public function view()
  {
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
          Session::setSuccessMessage('Successfully changed your password, please log in again.');
          header("location: /login");
          exit;
        } else {
          Session::setErrorMessage('Something went wrong, please try again later.');
          header("location: /welcome");
          exit;
        }
      }
    }

    $pageTitle = 'Reset Password';
    $this->displayTemplate(
      '/session/reset-password',
      [
        'pageTitle' => $pageTitle,
        'new_password_err' => $new_password_err,
        'confirm_password_err' => $confirm_password_err
      ]
    );
  }
}
