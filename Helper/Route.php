<?php 

namespace Helper;

class Route {

  private static $isPublic = false;
  // private static $routes = [];

  private static function getRoutes() {

    // self::$routes = 
    return [
      '/' => [
        'public' => true,
        'controller' => 'Controller\Index'
      ],
      '/login' => [
        'public' => true,
        'controller' => 'Controller\Login'
      ],
      '/logout' => [
        'public' => true,
        'controller' => 'Controller\Logout'
      ],
      '/register' => [
        'public' => true,
        'controller' => 'Controller\Register'
      ],
      '/reset/password' => [
        'public' => true,
        'controller' => 'Controller\ResetPassword'
      ],
      '/welcome' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Welcome'
      ],
      '/post/create' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Post\Create'
      ],
      '/post/edit' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Post\Edit'
      ],
      '/post/delete' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Post\Delete'
      ],
      '/profile' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Profile'
      ],
      '/profile/avatar/create' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Profile\Avatar\Create'
      ],
      '/profile/avatar/edit' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Profile\Avatar\Edit'
      ],
      '/profile/avatar/delete' => [
        'public' => self::$isPublic,
        'controller' => 'Controller\Profile\Avatar\Delete'
      ]
    ];
  }

  public static function get($requestedUrl) {

    // How to set content of static array? 
    // self::setRoutes();
    $routes = self::getRoutes();

    $requestedPath = self::getRequestedPath($requestedUrl);
    $param = self::getParam($requestedUrl);
    
    // If requested path exists in routes
    if (array_key_exists($requestedPath, $routes)) {

      $page = $routes[$requestedPath];
      $isPublic = $page['public'];
      $controller = $page['controller'];

      // Check Login if page is not public
      if (!$isPublic) {
        checkIfLoggedIn();
      }

      // Set Param
      $_GET['id'] = $param;

      // Call controller
      $page = $controller::view();

      // Show Page
      include(BASE . $page);

    } else {

      // Return default page for now
      include(BASE. '/session/login.php');
    }

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