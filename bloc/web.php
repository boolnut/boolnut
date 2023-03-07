<?php

use Boolnut\Core\Router\Router;


$router = new Router();

$router->getArray([
    #get routes
    '' => 'Web\WebController@index',
]);

 //$router->get('', 'web\WebController@index');