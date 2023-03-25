<?php
declare(strict_types=1);
namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes;

    // NB:: Any method that returns `self` i.e. $this type can be chained with 
    // another call to itself or a different method call 
    // e.g. register() below.
    public function register(
        string $requestMethod,
        string $route,
        callable |array $action
    ): self {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }

    public function get(string $route, callable |array $action): self
    {
        return $this->register('get', $route, $action);
    }
    public function post(string $route, callable |array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes();
    }

    public function resolve(string $requestUri, string $requestMethod): string|array
    {
        $route = explode("?", $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            // Let PHP invoke a user defined function reference
            return call_user_func($action);
        }

        // If Array
        if (is_array($action)) {
            [$class, $method] = $action;
            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        } // EndIf
    }
}
