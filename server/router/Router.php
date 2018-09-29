<?php

require_once 'Route.php';
require_once 'RouteResult.php';
require_once 'RouteOrder.php';

class Router
{
    private $routes = [];
    private $before = [];
    private $after = [];

    private $error = NULL;

    private static $instance = NULL;

    private function __construct()
    {
    }

    /**
     * @return array list of routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return array list of before routes
     */
    public function getBeforeRoutes(): array
    {
        return $this->before;
    }

    /**
     * @return array list of before routes
     */
    public function getAfterRoutes(): array
    {
        return $this->after;
    }

    /**
     * This method add tell to the router that a route match a controller function.
     * If the route match call this function with captured parameters in parameters
     * of this callable function.
     *
     * This method is chaineable.
     *
     * @param string $regex is the route ex: /home/
     * @param $callback
     * @param
     * @return Router
     */
    public function addRoute(string $regex, $callback, $routeType): Router
    {
        switch ($routeType) {
            case RouteOrder::$ROUTE:
                array_push($this->routes, new Route($regex, $callback));
                break;
            case RouteOrder::$AFTER:
                array_push($this->after, new Route($regex, $callback));
                break;
            case RouteOrder::$BEFORE:
                array_push($this->before, new Route($regex, $callback));
                break;
            default:
                array_push($this->routes, new Route($regex, $callback));
                break;
        }
        return $this;
    }

    public function entry($url)
    {
        $next = true;
        $routeMatch = false;

        $this->iterate($this->before, $url, $next, $routeMatch);

        if ($next) $this->iterate($this->routes, $url, $next, $routeMatch);

        if ($next) $this->iterate($this->after, $url, $next, $routeMatch);

        if (!$routeMatch) {
            if ($this->error) ($this->error)();
        }
    }

    /**
     * Access to the singleton router.
     *
     * @return Router
     */
    public static function getInstance(): Router
    {
        if (Router::$instance == NULL) Router::$instance = new Router();
        return Router::$instance;
    }

    /**
     * @param $routes
     * @param $url
     * @param $next
     * @param $routeMatch
     */
    private function iterate($routes, $url, &$next, &$routeMatch)
    {
        foreach ($routes as $r) {
            /* @var $r Route */

            $routeResult = $r->match($url);
            if ($routeResult->match) {
                $routeMatch = true;
                $next = $routeResult->call();
            }

            if (!$next) return;
        }
    }

    public function else(Closure $c)
    {
        $this->error = $c;
    }

}

