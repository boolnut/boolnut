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
        $router = new static();

        if (!is_array($files)) {
            throw new Exception("The routes file must be an array.");
        }
        if (empty($files)) {
            throw new Exception("The routes file must not be empty.");
        }
        foreach ($files as $file) {
            require $file;
        }

        $arr = [];
        foreach ($files as $file) {
            require $file;
            $arr[] = $router;
        }
        $GET = $POST = [];
        for ($i = 0; $i < count($arr); $i++) {
            foreach ($arr[$i] as $key => $value) {
                $GET = array_merge($GET, $value["GET"]);
                $POST = array_merge($POST, $value["POST"]);
            }
        }
        $router->routes["GET"] = $GET;
        $router->routes["POST"] = $POST;
        return $router;
    }

    /*
     * This function directs the user to the route based on the request type.
     */
    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            try {
                return $this->callAction(
                    ...explode("@", $this->routes[$requestType][$uri])
                );
            } catch (Exception $e) {
                header("HTTP/1.0 404 Unauthorized");
                return errorEngineView("error/404");
            }
        }

        foreach ($this->routes[$requestType] as $key => $value) {
            $pattern = preg_replace("#\(/\)#", "/?", $key);
            //$pattern = str_replace(".", "", $pattern);
            $pattern =
                "@^" .
                preg_replace("/{([\w\-]+)}/", '(?<$1>[\w\-]+)', $pattern) .
                "$@D";
            preg_match($pattern, $uri, $matches);
            array_shift($matches);
            if ($matches) {
                $action = explode("@", $value);
                try {
                    return $this->callAction($action[0], $action[1], $matches);
                } catch (Exception $e) {
                    header("HTTP/1.0 404 Not Found");
                    return errorEngineView("error/404");
                }
            }
        }

        header("HTTP/1.0 404 Not Found");
        return errorEngineView("error/404");
        //throw new Exception('No route defined for this URI.');
    }

    /*
     * This function calls the controller for an action.
     */
    protected function callAction($controller, $action, $vars = [])
    {
        $controller = "Boolnut\\App\\Controllers\\{$controller}";
        $controller = new $controller();

        if (!method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }
        return $controller->$action($vars);
    }
}
