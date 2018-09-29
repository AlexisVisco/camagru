<?php


class Route
{
    private $regex;

    public $class;
    public $method;

    /**
     * Route constructor.
     *
     * @param $regex
     * @param $callback
     */
    public function __construct($regex, $callback)
    {
        $this->regex = $regex;
        list($this->class, $this->method) = explode("@", $callback, 2);
    }

    public function match($urlWithoutHost) : RouteResult
    {
        $escapedSlash = str_replace("/", "\/", $this->regex);
        $parameters = [];
        $match = false;


        if (preg_match_all("/^" . $escapedSlash . "$/", $urlWithoutHost, $matchOut)) {
            if (count($matchOut) > 1) {
                $parameters = $this->combineArrays(array_slice($matchOut, 1));
            }
            $match = true;

        }
        return new RouteResult(
            $urlWithoutHost,
            $this->regex,
            $match,
            $parameters,
            $this
        );
    }

    private function combineArrays($arrays): array
    {
        $finalArray = [];
        foreach ($arrays as $arr) {
            foreach ($arr as $v) {
                array_push($finalArray, $v);
            }
        }
        return $finalArray;
    }
}