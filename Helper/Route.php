<?php 

namespace Helper;

class Route {

  //
  // Get Routes 
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
      '/post/{id}/create' => [
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

  public static function get($requestedUrl) {

    $routes = self::getRoutes();

    foreach ($routes as $route => $data) {
      $regex = self::getRegex($route);

      if (self::matchRoute($regex, $requestedUrl)) {

        $urlParams = self::getUrlParams($regex, $requestedUrl); 
 
        $isPublic = isset($data['public']) ? $data['public'] : false; 
        $controllerName = $data['controller'];
        $controllerMethod = 'view';


        $methodParams = self::getFuncArgNames($controllerName, $controllerMethod);
        $pageParams = self::getParams($methodParams, $urlParams);

        // Check Login if page is not public
        if (!$isPublic) {
          checkIfLoggedIn();
        }

        $controller = new $controllerName;
        try {
          call_user_func_array(
            array($controller, $controllerMethod),
            $pageParams
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

  //
  // Get Route Regex : Stolen from Laravel
  //
  private static function getRegex($route) {
    $route = preg_replace('/\{(.*)\}/', '(?P<$1>[^/]++)', $route);
    return '#^' . $route . '$#sDu';
  }

  //
  // Check if RequestedUrl matches against a route
  //
  private static function matchRoute($regex, $requestedUrl) {
    return (preg_match($regex, $requestedUrl) === 1);
  }

  // Get Id out of params - this regex does not work with multiple {}
  // ['id'] => '22'
  private static function getUrlParams($regex, $requestedUrl) {
      preg_match($regex, $requestedUrl, $matches);
      return $matches;
  }

  //
  // Get Function Arguments from method in controller
  //
  private static function getFuncArgNames($controller, $method) {
    $reflection = new \ReflectionClass($controller);
    $function = $reflection->getMethod($method);
    $result = [];

    foreach ($function->getParameters() as $param) {
        $result[] = $param->name;   
    }

    return $result;
  }

  //
  // Match Controller Method Params against UrlParams
  // Return array of correct params
  //
  private static function getParams($methodParams, $urlParams) {
    $params = [];

    foreach ($methodParams as $param) {
      $params[$param] = $urlParams[$param] ?? '';
    }

    return $params;
  }

}