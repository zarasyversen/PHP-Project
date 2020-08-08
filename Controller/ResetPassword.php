<?php 
namespace Controller;

use Repository\UserRepository;
use Helper\Session as Session;

class ResetPassword extends \Controller\Base {

  public function view()
  {
    $new_password = $confirm_password = "";

    $this->setData([
      'newPasswordError' => false,
      'confirmPasswordError' => false
    ]);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $new_password = trim($_POST["new_password"]);
      $confirm_password = trim($_POST["confirm_password"]);

      // Validate New Password
      if (empty($new_password)) {
        $this->setData('newPasswordError', "Please enter the new password.");
      } elseif (strlen($new_password) < 6) {
        $this->setData('newPasswordError', "Password must have at least 6 characters.");
      } elseif (empty($confirm_password)) {
        $this->setData('confirmPasswordError', "Please confirm the password.");
      } elseif ($new_password != $confirm_password) {
        $this->setData('confirmPasswordError', "Password did not match.");
      } else {
        if (UserRepository::resetPassword(password_hash($new_password, PASSWORD_DEFAULT))) {
          session_destroy();
          session_start();
          $this->setData(['session_success' => 'Successfully changed your password, please log in again.']);
          return $this->redirect("/login");
        } else {
          $this->setData(['session_error' => 'Something went wrong, please try again later.']);
          return $this->redirect("/welcome");
        }
      }
    }

    $pageTitle = 'Reset Password';
    $this->setData([
      'pageTitle' => $pageTitle
    ]);
    $this->setTemplate('session/reset-password');
  }
}
