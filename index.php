<?php
require_once("config.php");

$requestedUrl = $_SERVER['REQUEST_URI'];

try {
  Helper\Route::get($requestedUrl);
} catch(\Exceptions\NotFound | \Exception $e) {
  http_response_code(400);
  $pageTitle = "Page Not Found";
  include(BASE . '/view/page/404.php');
}
?>