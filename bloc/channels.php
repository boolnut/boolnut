<?php


use Boolnut\Core\Router\Router;


$router = new Router();

$router->getArray([
    #get routes
    'login' => 'Web\WebController@index'
]);