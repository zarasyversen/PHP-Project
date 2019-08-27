<?php 
require_once("config.php");

// Check if User exits
if(!isset($_GET['id']) || !getUser($connection, intval($_GET['id']))) {
  // Set a session message and redirect to welcome
  setErrorMessage('Sorry, that user does not exist.');
  header("location: welcome.php");
}

$userId = intval($_GET['id']);
$user = getUser($connection, $userId);

echo $user['username'];
echo $user['created'];
echo $user['is_admin'];