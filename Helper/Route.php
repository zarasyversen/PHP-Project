<?php 

namespace Helper;

use \Exceptions\NotFound;
use \Exceptions\NoPermission;

class Route {

  /**
   * Routes
   */
  private static function routes()
  {
    return [
      '/' => [
        'controller' => 'Controller\Login'
      ],
      '/login' => [
        'controller' => 'Controller\Login'
      ],
      '/logout' => [
        'controller' => 'Controller\Logout'
      ],
      '/register' => [
        'controller' => 'Controller\Register'
      ],
      '/reset/password' => [
        'controller' => 'Controller\ResetPassword',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/welcome' => [
        'controller' => 'Controller\Welcome',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/post/create' => [
        'controller' => 'Controller\Post\Create',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/post/{id}/edit' => [
        'controller' => 'Controller\Post\Edit',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/post/{id}/delete' => [
        'controller' => 'Controller\Post\Delete',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/api/profile/{name}' => [
        'controller' => 'Controller\Profile'
      ],
      '/profile/{name}' => [
        'controller' => 'Controller\Profile',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/profile/{name}/avatar/create' => [
        'controller' => 'Controller\Profile\Avatar\Create',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/profile/{name}/avatar/edit' => [
        'controller' => 'Controller\Profile\Avatar\Edit',
        'middleware' => 'Middleware\WebAuth'
      ],
      '/profile/{name}/avatar/delete' => [
        'controller' => 'Controller\Profile\Avatar\Delete',
        'middleware' => 'Middleware\WebAuth'
      ]
    ];
  }

  /**
   * Get Route
   * Get/Set Params, Pass to controller
   */
  public static function get($requestedUrl)
  {
    // Get our Routes Array
    $routes = self::routes();

    foreach ($routes as $route => $data) {

      /**
       * Check if the requestedUrl matches against a route in our array.
       */
      $regex = self::getRegex($route);
      if (self::matchRoute($regex, $requestedUrl)) {

        /**
         * Middleware
         */
        $hasMiddleware = isset($data['middleware']); 

        if ($hasMiddleware) {
          $middleware = new $data['middleware'];
          $middleware->execute();
        }

        /**
         * Get The Route Data
         */
        $controllerName = $data['controller'];
        $controllerMethod = 'view';

        // Params from requested Url
        $urlParams = self::getUrlParams($regex, $requestedUrl); 

        // Params required for our controller
        $controllerParams = self::getFuncArgNames($controllerName, $controllerMethod);

        // Params for this view
        $viewParams = self::getViewParams($urlParams, $controllerParams);

        // Check if API request, will return json
        $json = preg_match('/(api)/', $requestedUrl);

        /**
         * Create a new instance of the controller,
         * Call controllerMethod and pass the viewParams
         */
        $controller = new $controllerName;

        try {
          call_user_func_array(
            array($controller, $controllerMethod),
            $viewParams
          );

          if ($json) {
            echo json_encode($controller->getData());
          } else {
            $controller->renderHtml();
          }

          return;
        } catch(NotFound | NoPermission | \Exception $e) {
          Session::setErrorMessage($e->getMessage());
          header("location: /welcome");
          return;
        }
      }

    }

    throw new \Exceptions\NotFound("Sorry, Page not found");
  }

  /**
   * Get Route Regex : From Laravel
   * Returns String
   */
  private static function getRegex($route)
  {
    $route = preg_replace('/\{(.*)\}/', '(?P<$1>[^/]++)', $route);
    return '#^' . $route . '$#sDu';
  }

  /**
   * Check if RequestedUrl matches against a route
   * Returns Bool
   */
  private static function matchRoute($regex, $requestedUrl)
  {
    return (preg_match($regex, $requestedUrl) === 1);
  }

  /**
   * Get the params passed in the requestedUrl
   * Returns Array []
   */
  private static function getUrlParams($regex, $requestedUrl)
  {
    preg_match($regex, $requestedUrl, $matches);
    return $matches;
  }

  /**
   * Get Function Argument Names from specified method in controller
   * Returns Array []
   */
  private static function getFuncArgNames($controller, $method)
  {
    $reflection = new \ReflectionClass($controller);
    $function = $reflection->getMethod($method);
    $result = [];

    foreach ($function->getParameters() as $param) {
        $result[] = $param->name;   
    }

    return $result;
  }

  /**
   * Match urlParams against controllerParams
   * Returns Array []
   */
  private static function getViewParams($urlParams, $controllerParams)
  {
    $params = [];

    foreach ($controllerParams as $param) {
      $params[$param] = $urlParams[$param] ?? '';
    }

    return $params;
  }

}
