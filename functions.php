<?php

function canEditPost($username){

  // Potentially change to id soon 
  // Check session username matches post username
  if($_SESSION["username"] === $username){
    return true;
  }
  
}