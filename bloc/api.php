<?php

use Boolnut\Core\Router\Router;

$router = new Router();

$router->getArray([
    #get routes
    "api/login" => "Web\WebController@index",
    "api/checking" => "Web\WebController@index",
]);
