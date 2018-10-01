<?php


class RouteResult
{
    private $routeOrigin;
    private $routeTargeted;

    public $match = false;
    private $parameters = [];

    private $route;

    /**
     * RouteResult constructor.
     * @param $routeOrigin
     * @param $routeTargeted
     * @param bool $match
     * @param array $parameters
     * @param Route $route
     */
    public function __construct($routeOrigin, $routeTargeted, bool $match, array $parameters, Route $route)
    {
        $this->routeOrigin = $routeOrigin;
        $this->routeTargeted = $routeTargeted;
        $this->match = $match;
        $this->parameters = $parameters;
        $this->route = $route;
    }


    public function call(): bool
    {
        if ($this->match) {
            try {
                $reflectionMethod = new ReflectionMethod($this->route->class, $this->route->method);
                $result = $reflectionMethod->invokeArgs(new $this->route->class(), $this->parameters);
                if (gettype($result) == "boolean") return $result;
                return true;
            } catch (ReflectionException $e) {
                return false;
            }
        }
        return false;
    }

}