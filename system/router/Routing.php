<?php

namespace System\router;

use ReflectionMethod;

class Routing
{
    private $current_route;

    public function __construct()
    {
        global $current_route;

        $this->current_route = explode('/', $current_route);
    }

    public function run()
    {

        // get class name in current_url
        $path = realpath(dirname(__FILE__) . "/../../application/controllers/" . $this->current_route[0] . '.php');

        //how is file class

        if (!file_exists($path)) {
            echo '404-file not exist';
            exit;
        }

        require_once($path);

        // get method name
        sizeof($this->current_route) == 1 ? $method = 'index' : $method = $this->current_route[1];

        // call class and how is method sellect
        $class = "Application\Controllers\\" . $this->current_route[0];

        $object = new $class();

        if (method_exists($object, $method)) {

            $reflection = new ReflectionMethod($class, $method);

            // get count parametr in method
            $parameterCount = $reflection->getNumberOfParameters();

            if ($parameterCount <= count(array_slice($this->current_route, 2))) {

                call_user_func_array(array($object, $method), array_slice($this->current_route, 2));
            } else {
                echo '404 - not parameter!!';
            }
        } else {
            echo '404 - not method exist!!';
        }
    }
}