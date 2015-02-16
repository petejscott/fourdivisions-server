<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once "Bootstrap.php";

$requestRouter->Route(
	$_REQUEST, 
	$_SERVER);

?>