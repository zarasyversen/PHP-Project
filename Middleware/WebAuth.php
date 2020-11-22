<?php
namespace Middleware;

use Middleware\MiddleWareInterface;
use Helper\Session;
use Repository\UserRepository;

class WebAuth implements MiddleWareInterface
{

  public function execute($requestedUrl)
  {

    // Check if API request, auth with token
    $apiRequest = preg_match('/(api)/', $requestedUrl);

    if ($apiRequest) {
      $headers = apache_request_headers();
      $userLoggedIn = false;

      if(isset($headers['Authorization'])) {
        $token = $headers['Authorization'];

        if (UserRepository::getUserFromToken($token)) {
          Session::setCurrentUser(UserRepository::getUserFromToken($token));
          $userLoggedIn = true;
        }
      } 

      if (!$userLoggedIn) {
        echo json_encode(['error' => ['code' => 401, 'message' => 'Please log in for access']]);
        exit;
      }

    } else {

      // Redirect if not logged in
      if (!Session::getSessionUserId()){
        Session::setErrorMessage('Please log in for access');
        header("location: /login");
        exit;
      }
    }
  
  }
}
