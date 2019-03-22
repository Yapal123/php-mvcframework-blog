<?php

namespace application\core;

use application\core\View;

class Router {

    protected $routes = [];
    protected $params = [];
    
    public function __construct() {
        //path to routes
        $arr = require 'application/config/routes.php';
        //$key is a route and $val its a action and controller
        foreach ($arr as $key => $val) {

            $this->add($key, $val);
        }
    }
    //get all routes
    public function add($route, $params) {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }
    //find the current route
    public function match() {
        //get current URL
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run(){
        if ($this->match()) {
            //Path to current controller
            $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
            //check if this controller exist
            if (class_exists($path)) {
            //naming of action
                $action = $this->params['action'].'Action';
            //check if action exist
                if (method_exists($path, $action)) {
                    //create object of current controller
                    $controller = new $path($this->params);
                    //call to current action
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

}