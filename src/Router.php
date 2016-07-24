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
     * @return array
     */
    public function match(): array
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $url, $parameters)) {
                array_shift($parameters);

                return [$callback, $parameters];
            }
        }

        throw new RouteNotFoundException(sprintf('Route `%s` not found', $url), 404);
    }
}
