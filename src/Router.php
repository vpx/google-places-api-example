<?php
namespace VP;

use VP\Exception\RouteNotFoundException;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @param string $pattern
     * @param callable $callback
     */
    public function add(string $pattern, callable $callback)
    {
        $this->routes[sprintf('/^%s$/', str_replace('/', '\/', $pattern))] = $callback;
    }

    /**
     * @param string $url
     *
     * @return callable
     */
    public function match(string $url): callable
    {
        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $url)) {
                return $callback;
            }
        }

        throw new RouteNotFoundException(sprintf('Route `%s` not found', $url), 404);
    }
}
