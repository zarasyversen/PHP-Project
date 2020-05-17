<?php
namespace Middleware;

//
// Interface can not be called interface.php lol
// Needs to have the same filename as interface name.
// Parse error: syntax error, unexpected 'Interface' (T_INTERFACE) when implements
//
interface AuthInterface {
  
  public function execute();

}
