<?php 
namespace Controller;

use Repository\UserRepository;
use Helper\Session as Session;

class Login extends \Controller\Base {

  public function view()
  {
    // Redirect if already logged in
    if (Session::isLoggedIn()) {
      return $this->redirect("/welcome");
    }

    $username = $password = '';
    $passwordOk = $usernameOk = false;

    $this->setData([
      'missingUsername' => false, 
      'missingPassword' => false,
      'wrongPassword' => false
    ]);

    // Process data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $username = trim($_POST["username"]);
      $password = trim($_POST["password"]);

      if (empty($username)) {
        $this->setData('missingUsername', 'Please enter your username');
      } elseif (empty($password)) {
        $this->setData('missingPassword', 'Please enter your password');
      } else {
     
        try {
          $user = UserRepository::getUserByName($username);
        } catch (\Exceptions\NotFound $e) {
          $this->setData(['session_error' =>'Sorry, that user does not exist.']);
          return $this->redirect("/login");
        }

        if (password_verify($password, $user->getPassword())) {

          // Password verified - start a session
          $session_lifetime = 86400; //1 day lifetime
          session_set_cookie_params($session_lifetime);
          session_start();

          // Store data in session variable
          $_SESSION["user_id"] = $user->getId();
          
          // Redirect user to welcome page
          return $this->redirect("/welcome");
        } else {
          $this->setData('missingPassword', 'Sorry, that password is incorrect.');
        }
      }
    }

    $pageTitle = 'Welcome, please log in';

    $this->setData([
      'pageTitle' => $pageTitle,
      'username' => $username,
      'password' => $password
    ]);
    $this->setTemplate('session/login');
    
  }
}
