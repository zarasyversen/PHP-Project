<?php 

namespace Helper;

class Route {

  private static $isPublic = false;

  /*
   * Routes
  **/
  // private static $array = [
  //   '/profile' => [
  //     'public' => $isPublic,
  //     'controller' => 'Controller\Profile'
  //   ]
    // ],
    // '/profile/avatar/create' => [
    //   'public' => $isPublic,
    //   'controller' => 'Controller\Profile\Avatar\Create'
    // ],
    // '/profile/avatar/edit' => [
    //   'public' => $isPublic,
    //   'controller' => 'Controller\Profile\Avatar\Edit'
    // ],
    // '/profile/avatar/delete' => [
    //   'public' => $isPublic,
    //   'controller' => 'Controller\Profile\Avatar\Delete'
    // ]
  // ];

  public static function get($requestedUrl) {

    $requestedPath = self::getRequestedPath($requestedUrl);
    $getParam = self::getParam($requestedUrl);

    var_dump($requestedPath);
    var_dump($getParam);
    die('ha');

    // checkIfLoggedIn();
    // $_GET['id'] = $param;
    // $page = Controller\User::showProfile();
    // include(BASE . $page);

  }


  private static function getMatches($requestedUrl) {
    // get any slash followed by digits
    $regex = '(\/\d+)'; 

    // find param (any match for '/123')
    preg_match($regex, $requestedUrl, $matches);

    // Make param to string - return $match
    return implode('', $matches);
  }

  private static function getRequestedPath($requestedUrl) {

    $match = self::getMatches($requestedUrl);
    
    // Remove param from url to find path
    $requestedPath = str_replace($match, '', $requestedUrl); 

    return $requestedPath;

  }

  private static function getParam($requestedUrl) {

    $match = self::getMatches($requestedUrl);
    
    // get param but remove slash
    $param = str_replace('/', '', $match);

    return $param;
  }

}