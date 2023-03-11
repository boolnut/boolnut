<?php

namespace Boolnut\Core\Router;

use Exception;

class Router extends Routes
{
    /*
     * This function loads the routes from a file. In this framework, the routes are stored in app/routes.php.
     */

    public static function load($files)
    {

        $router = new static;


        if (!is_array($files)) {
            throw new Exception('The routes file must be an array.');
        }
        if (empty($files)) {
            throw new Exception('The routes file must not be empty.');
        }
        foreach ($files as $file) {
            require $file;
            return $router;
        }














        // $arr = array();
        // foreach ($files as $file) {
        //     require $file;
        //     $arr[] = $router;
        // }

        // $router = $GET = $POST = array();
        // //   $root = object;
        // for ($i = 0; $i < count($arr); $i++) {
        //     foreach ($arr[$i] as $key => $value) {
        //         $GET =  array_merge($GET, $value['GET']);
        //         $POST =  array_merge($POST, $value['POST']);
        //     }
        //     //   $root['routes'] = $arr[$i]->routes['GET'];
        //     //  $root['routes']['POST'] =


        // }
        // $router['routes']['GET'] = $GET;
        // $router['routes']['POST'] = $POST;

        // echo '<pre>';
        // print_r($router);
        // die("vf");

        // require_once "./bloc/api.php";
        // require_once "./bloc/channels.php";
        // require "./bloc/web.php";


        // $out = array();
        // foreach ($arr as $key => $value) {
        //     $out[] = (object)array_merge((array)$arr2[$key], (array)$value);
        // }


        // echo '<pre>';
        // print_r($router);
        // die("Vf");

        // return $router;
        // require $files;
        // return $router;
    }

    /*
     * This function directs the user to the route based on the request type.
     */
    public function direct($uri, $requestType)
    {
        // print_r($this->routes);
        // die("vf");

        // print_r($uri);
        // print_r($requestType);
        //die();
        //  print_r($uri);

        // $this->routes['GET'] = array('login' => 'Web\WebController@index');

        // $this->routes['GET'] = array('api/login' => 'Web\WebController@index');



        if (array_key_exists($uri, $this->routes[$requestType])) {


            //die();
            try {
                return $this->callAction(
                    ...explode('@', $this->routes[$requestType][$uri])
                );
            } catch (Exception $e) {

                header('HTTP/1.0 404 Unauthorized');
                return errorEngineView('error/404');
            }
        }

        foreach ($this->routes[$requestType] as $key => $value) {
            $pattern = preg_replace('#\(/\)#', '/?', $key);
            //$pattern = str_replace(".", "", $pattern);
            $pattern = "@^" . preg_replace('/{([\w\-]+)}/', '(?<$1>[\w\-]+)', $pattern) . "$@D";
            preg_match($pattern, $uri, $matches);
            array_shift($matches);
            if ($matches) {
                $action = explode('@', $value);
                try {
                    return $this->callAction($action[0], $action[1], $matches);
                } catch (Exception $e) {
                    die("Vfv");
                    header('HTTP/1.0 404 Not Found');
                    return errorEngineView('error/404');
                }
            }
        }

        header('HTTP/1.0 404 Not Found');
        return errorEngineView('error/404');
        //throw new Exception('No route defined for this URI.');
    }

    /*
     * This function calls the controller for an action.
     */
    protected function callAction($controller, $action, $vars = [])
    {
        $controller = "Boolnut\\App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new Exception("{$controller} does not respond to the {$action} action.");
        }
        return $controller->$action($vars);
    }
}
