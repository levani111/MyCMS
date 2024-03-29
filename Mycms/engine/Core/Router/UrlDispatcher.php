<?php


namespace Engine\Core\Router;


class UrlDispatcher
{
    /**
     * @var array
     */
    private $method = [
        'GET',
        'POST'
    ];

    /**
     * @var array
     */
    private $routes = [
        'GET'   => [],
        'POST'  => []
    ];

    /**
     * @var array
     */
    private $patterns = [
        'int' => '[0-9]+',
        'str' => '[a-zA-Z\.\-_%]+',
        'any' => '[a-zA-Z0-9\.\-_%]+'
    ];

    /**
     * @param $key
     * @param $pattern
     */
    public function addPattern($key, $pattern)
    {
        $this->patterns[$key] = $pattern;
    }

    /**
     * @param $method
     * @return array|mixed
     */
    private function routes($method)
    {
        return isset($this->router[$method]) ? $this->routes[$method] : [];
    }

    public function register($method,$pattern, $controller)
    {
        $this->routes[strtoupper($method)][$pattern] = $controller;
    }


    /**
     * @param $method
     * @param $uri
     * @return DispatchedRoute|void
     */
    public function dispatch($method, $uri)
    {
        $routes = $this->routes(strtoupper($method));

        if (array_key_exists($uri, $routes))
        {
            return new DispatchedRoute($routes[$uri]);
        }
        return $this->doDispatch($method, $uri);
    }

    /**
     * @param $method
     * @param $uri
     */
    private function doDispatch($method, $uri)
    {
        foreach ($this->routes(strtoupper($method)) as $route => $controller)
        {
            $pattern = "#^". $route . "$#s";

            if (preg_match($pattern, $uri, $parameters))
            {
                return new DispatchedRoute($controller, $parameters);
            }
        }
    }

}