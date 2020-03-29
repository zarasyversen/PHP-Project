  
<?php
$public_access = true;
require_once("config.php");

$requestedUrl = $_SERVER['REQUEST_URI'];

return Helper\Route::get($requestedUrl);
?>