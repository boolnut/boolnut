<?php
use Boolnut\Core\Router\Request;
use Boolnut\Core\Router\Router;


require 'vendor/autoload.php';
require 'core/bootstrap.php';

spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});


//This is where we load the routes from the routes file.
try {
	Router::load('bloc/web.php')->direct(Request::uri(), Request::method());
} catch (Exception $e) {
	return $e;
}
