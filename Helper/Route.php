<?php 

namespace Helper;

class Route {

  private static $isPublic = false;
  private static $routes = [];

  /*
   * Routes
  **/
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

  private static function setRoutes() {
    self::$routes = [
        '/profile' => [
          'public' => self::$isPublic,
          'controller' => 'Controller\Profile'
        ]
    ];
  }

  public static function get($requestedUrl) {
    $requestedPath = self::getRequestedPath($requestedUrl);
    $getParam = self::getParam($requestedUrl);

    self::setRoutes();

    var_dump($requestedPath);
    var_dump($getParam);
    var_dump(self::$routes);
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