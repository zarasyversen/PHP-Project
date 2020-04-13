<?php 

namespace Helper;

class Route {

  // loops thorugh the array of routes, 
  // We need to code that converts "/profile/{id}" into the actual regex
  // that regex is then going over to find /profile/123 and return the controller

  //
  // Routes
  //
  private static function getRoutes() {
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
        'controller' => 'Controller\Welcome'
      ],
      '/post/create' => [
        'controller' => 'Controller\Post\Create'
      ],
      '/post/edit' => [
        'controller' => 'Controller\Post\Edit'
      ],
      '/post/delete' => [
        'controller' => 'Controller\Post\Delete'
      ],
      '/profile' => [
        'controller' => 'Controller\Profile'
      ],
      '/profile/avatar/create' => [
        'controller' => 'Controller\Profile\Avatar\Create'
      ],
      '/profile/avatar/edit' => [
        'controller' => 'Controller\Profile\Avatar\Edit'
      ],
      '/profile/avatar/delete' => [
        'controller' => 'Controller\Profile\Avatar\Delete'
      ]
    ];
  }

  public static function get($requestedUrl) {

    $routes = self::getRoutes();

    $requestedPath = self::getRequestedPath($requestedUrl);
    $param = self::getParam($requestedUrl);
    
    // If requested path exists in routes
    if (array_key_exists($requestedPath, $routes)) {

      $page = $routes[$requestedPath];

      $isPublic = isset($page['public']) ? $page['public'] : false; 
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