<?php 

namespace Helper;

class Route {

  /**
   * Routes
   */
  private static function routes() {
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
      '/post/{id}/edit' => [
        'controller' => 'Controller\Post\Edit'
      ],
      '/post/{id}/delete' => [
        'controller' => 'Controller\Post\Delete'
      ],
      '/profile/{id}' => [
        'controller' => 'Controller\Profile'
      ],
      '/profile/{id}/avatar/create' => [
        'controller' => 'Controller\Profile\Avatar\Create'
      ],
      '/profile/{id}/avatar/edit' => [
        'controller' => 'Controller\Profile\Avatar\Edit'
      ],
      '/profile/{id}/avatar/delete' => [
        'controller' => 'Controller\Profile\Avatar\Delete'
      ]
    ];
  }

  /**
   * Get Route
   * Get/Set Params, Pass to controller
   */
  public static function get($requestedUrl) {

    // Get our Routes Array
    $routes = self::routes();

    foreach ($routes as $route => $data) {

      /**
       * Check if the requestedUrl matches against a route in our array.
       */
      $regex = self::getRegex($route);
      if (self::matchRoute($regex, $requestedUrl)) {

        /**
         * Get The Route Data
         */
        $isPublic = isset($data['public']) ? $data['public'] : false; 
        $controllerName = $data['controller'];
        $controllerMethod = 'view';

        // Check Login if page is not public
        if (!$isPublic) {
          checkIfLoggedIn();
        }

        // Params from requested Url
        $urlParams = self::getUrlParams($regex, $requestedUrl); 

        // Params required for our controller
        $controllerParams = self::getFuncArgNames($controllerName, $controllerMethod);

        // Params for this view
        $viewParams = self::getViewParams($urlParams, $controllerParams);

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

        } catch(\Exceptions\NotFound $e) {

          Session::setErrorMessage($e->getMessage());
          header("location: /welcome");
          exit;

        } catch (\Exceptions\NoPermission $e) {

          Session::setErrorMessage($e->getMessage());
          header("location: /welcome");
          exit;

        } catch(\Exception $e) {

          Session::setErrorMessage($e->getMessage());
          header("location: /welcome");
          exit;

        }

      }
    }

  }

  /**
   * Get Route Regex : Stolen from Laravel
   * Returns String
   */
  private static function getRegex($route) {
    $route = preg_replace('/\{(.*)\}/', '(?P<$1>[^/]++)', $route);
    return '#^' . $route . '$#sDu';
  }

  /**
   * Check if RequestedUrl matches against a route
   * Returns Bool
   */
  private static function matchRoute($regex, $requestedUrl) {
    return (preg_match($regex, $requestedUrl) === 1);
  }

  /**
   * Get the params passed in the requestedUrl
   * Returns Array []
   */
  private static function getUrlParams($regex, $requestedUrl) {
      preg_match($regex, $requestedUrl, $matches);
      return $matches;
  }

  /**
   * Get Function Argument Names from specified method in controller
   * Returns Array []
   */
  private static function getFuncArgNames($controller, $method) {
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
  private static function getViewParams($urlParams, $controllerParams) {
    $params = [];

    foreach ($controllerParams as $param) {
      $params[$param] = $urlParams[$param] ?? '';
    }

    return $params;
  }

}
