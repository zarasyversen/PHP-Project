<?php 
namespace Controller;

use UserRepository;
use Helper\Session as Session;

class Register {

  public static function view() {

    // Redirect if already logged in
    if (Session::isLoggedIn()) {
      header("location: /welcome");
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
          Session::setSuccessMessage('Successfully created your account, please log in.');
          header("location: /login");
        } catch (\Exceptions\NotSaved $e){
          Session::setErrorMessage('Something went wrong, please try again later.');
          header("location: /register");
        } finally {
          exit; 
        }
      }
    }

    $pageTitle = 'Sign Up';
    include(BASE . '/session/register.php');
  }

}
