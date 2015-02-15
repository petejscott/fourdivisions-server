<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once "Bootstrap.php";

// If $_REQUEST contains 'controller' that matches a registered route's ControllerName
// and it contains 'action' that matches an action in a registered route's Action array, 
// and the registered route has a valid ControllerObject and a method that corresponds to 
// the "action" key, then that method on that ControllerObject should be executed.

// Currently, the data is RETURNED from the Route call, which is fine and we should keep 
// for the sake of testability, but it should also print the response. It probably makes more sense 
// to have an abstract controller the others can extend, and have a switch in there to flip between 
// returning a response and printing a response.

$requestRouter->Route(
	$_REQUEST, 
	$_SERVER);

?>