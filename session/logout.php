<?php
// Initialize the session
session_start();
 
// Destroy the session.
session_destroy();
 
// Redirect to index page
header("location: ../index.php");
exit;
?>