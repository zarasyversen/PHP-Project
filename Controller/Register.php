<?php 
namespace Controller;

use Repository\UserRepository;
use Helper\Session as Session;

class Register extends \Controller\Base {

  public function view()
  {
    // Redirect if already logged in
    if (Session::isLoggedIn()) {
      header("location: /welcome");
      exit;
    }

    //Define Variables
    $username = $password  = $confirm_password = '';
    $userOk = $passwordOk = false;

     $this->setData([
      'missingUsername' => false, 
      'missingPassword' => false,
      'confirmPassword' => false
    ]);

    //Process Data when form is posted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $username = trim($_POST["username"]);
      $password = trim($_POST["password"]);
      $confirm_password = trim($_POST["confirm_password"]);

      // Validate Username
      if (empty($username)) {
        $this->setData('missingUsername', "Please enter a username");
      } elseif (UserRepository::doesUserExist($username)) {
         $this->setData('missingUsername', "This username is already taken, try again.");
      } elseif (empty($password)) {
        $this->setData('missingPassword', "Please enter a password");
      } elseif (empty($confirm_password)) {
        $this->setData('confirmPassword', "Please confirm your password");
      } elseif (strlen($password) < 6) {
        $this->setData('missingPassword', "Password must be longer than 6 characters");
      } elseif ($password != $confirm_password) {
        $this->setData('confirmPassword', "Passwords did not match.");
      } else {

        try {
          UserRepository::createUser($username, $password);
          $this->setData(['success' => 'Successfully created your account, please log in.']);
          Session::setSuccessMessage('Successfully created your account, please log in.');
          header("location: /login");
        } catch (\Exceptions\NotSaved $e){
          $this->setData(['error' => 'Successfully created your account, please log in.']);
          Session::setErrorMessage('Something went wrong, please try again later.');
          header("location: /register");
        } finally {
          exit; 
        }
      }
    }

    $pageTitle = 'Sign Up';
    $this->setData([
      'pageTitle' => $pageTitle,
      'username' => $username,
    ]);
    $this->setTemplate('session/register');
  }
}
