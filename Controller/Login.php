<?php 
namespace Controller;

use Repository\UserRepository;
use Helper\Session as Session;

class Login extends \Controller\Base {

  public function view() {

    // Redirect if already logged in
    if (Session::isLoggedIn()) {
      header("location: /welcome");
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
          $user = UserRepository::getUserByName($username);
        } catch (\Exceptions\NotFound $e) {
          Session::setErrorMessage('Sorry, that user does not exist.');
          header("location: /login");
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
          header("location: /welcome");
        } else {
          $password_err = "Sorry, that password is incorrect.";
        }
      }
    }

    $pageTitle = 'Welcome, please log in';
    $this->displayTemplate(
      '/session/login', 
      [
        'pageTitle' => $pageTitle,
        'username' => $username,
        'password' => $password,
        'username_err' => $username_err,
        'password_err' => $password_err,

      ]
    );
  }

}
