<?php

namespace Boolnut\Core\Router;

class Routes
{
    /*
     * This is the routes array. So far it only works for GET and POST but this can be changed.
     */
    public $routes = [

        'GET' => [],
        'POST' => [],

    ];

    /*
     * This function gets the GET route based on the URI and passes it off to the controller.
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }
    /*
     * This function gets the POST route based on the URI and passes it off to the controller.
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }
    /*
     * This function using array notation routing gets the GET routes. PHP does not support function overloading (also known as method overloading in OOP), so we cannot name this function get even though it has a different number of parameters than the get function used for routing without array notation.
     */
    public function getArray($routes)
    {
        $this->routes['GET'] = $routes;
    }
    /*
     * This function using array notation routing gets the POST routes. PHP does not support function overloading (also known as method overloading in OOP), so we cannot name this function post even though it has a different number of parameters than the post function used for routing without array notation.
     */
    public function postArray($routes)
    {
        $this->routes['POST'] = $routes;
    }
}
