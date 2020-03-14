  
<?php
$public_access = true;
require_once("config.php");

$requestedUrl = $_SERVER['REQUEST_URI'];

// get any slash followed by digits
$regex = '(\/\d+)'; 

// find param (any match for '/123')
preg_match($regex, $requestedUrl, $matches);

// Make param to string
$match = implode('', $matches);

// Remove param from url to find path
$requestedPath = str_replace($match, '', $requestedUrl); 

// get param but remove slash
$param = str_replace('/', '', $match); 

switch ($requestedPath) {
  case '/profile':

    $_GET['id'] = $param;
    include(BASE . '/user/profile.php');
    exit;

    // include user/profile.php?id;
    break;

  case '/profile/avatar/create':
    // include user/profile/avatar-upload.php;
    break;

  case '/profile/avatar/edit':
    // include user/profile/avatar-update.php;
    break;

  case '/profile/avatar/delete':
    // include user/profile/avatar-delete.php;
    break;

  default: 
    include(BASE . '/session/login.php');
}
?>